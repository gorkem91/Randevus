<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Membership extends MY_Controller {

    public function __construct() {
        parent::__construct();
        /*
         * check vendor module enable by admin
         */
        if (get_site_setting('is_display_vendor') == "N") {
            redirect('front');
        }
        $this->load->model('model_membership');
    }

    //show vendor package history
    public function index() {
        $data['membership_history'] = $this->model_membership->get_package_history($this->login_id);
        $data['title'] = translate('membership');
        $this->load->view('vendor/membership-history', $data);
    }

    public function membership_purchase() {
        $check_package = $this->model_membership->getData('app_membership_history', 'id', "customer_id='$this->login_id' AND status='A'");
        if (isset($check_package) && count($check_package) == 0) {
            $data['package_data'] = $this->model_membership->get_package();
            $data['title'] = translate('membership_purchase');
            $this->load->view('vendor/membership-purchase', $data);
        } else {
            show_404();
        }
    }

    public function purchase_details($id) {
        $check_package = $this->model_membership->getData('app_membership_history', 'id', "customer_id='$this->login_id' AND status='A'");
        if (isset($check_package) && count($check_package) == 0) {
            $package_data = $this->model_membership->get_package($id);
            if (isset($package_data) && count($package_data) > 0) {
                $data['package_data'] = $package_data[0];
                $data['title'] = translate('membership_purchase');
                $this->load->view('vendor/membership-details', $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function check_package_price($id) {
        $amount = $this->model_membership->get_package_price($id);
        echo $amount;
        exit;
    }

    public function package_purchase() {
        include APPPATH . 'third_party/init.php';
        $package_id = $this->input->post('package_id');
        $package_data = $this->model_membership->get_package($package_id);
        $payment_method = $this->input->post('payment_method');
        if ($payment_method == 'on_cash') {
            $data['customer_id'] = $this->login_id;
            $data['package_id'] = $package_id;
            $data['remaining_event'] = $package_data[0]['max_event'];
            $data['payment_method'] = $payment_method;
            $data['payment_status'] = 'paid';
            $data['price'] = $package_data[0]['price'];
            $data['status'] = 'A';
            $data['created_on'] = date('Y-m-d H:i:s');
            $this->model_membership->insert('app_membership_history', $data);
            $this->model_membership->update('app_admin', array('package_id' => $package_id), "id='$this->login_id'");
            $this->session->set_flashdata('msg', translate('transaction_success'));
            $this->session->set_flashdata('msg_class', 'success');
            redirect('vendor/membership');
        } else if ($payment_method == 'stripe') {
            if ($this->input->post('stripeToken')) {
                $stripe_api_key = get_StripeSecret();
                \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                $vendor_email = $this->db->get_where('app_admin', array('id' => $this->login_id))->row()->email;

                $charge = \Stripe\Charge::create(array(
                            "amount" => ceil($package_data[0]['price'] * 100),
                            "currency" => "USD",
                            "source" => $_POST['stripeToken'], // obtained with Stripe.js
                            "description" => ''
                ));

                $charge = (array) $charge;
                foreach ($charge as $key => $value) {
                    $get_payment_details[] = $value;
                }
                if ($get_payment_details[1]['paid'] == true) {
                    $data['customer_id'] = $this->login_id;
                    $data['package_id'] = $package_id;
                    $data['remaining_event'] = $package_data[0]['max_event'];
                    $data['payment_method'] = $payment_method;
                    $data['transaction_id'] = $get_payment_details[1]['balance_transaction'];
                    $data['customer_payment_id'] = $_POST['stripeToken'];
                    $data['payment_id'] = $get_payment_details[1]['id'];
                    $data['payment_status'] = 'paid';
                    $data['failure_code'] = $get_payment_details[1]['failure_code'];
                    $data['failure_message'] = $get_payment_details[1]['failure_message'];
                    $data['price'] = $package_data[0]['price'];
                    $data['status'] = 'A';
                    $data['created_on'] = date('Y-m-d H:i:s');
                    $this->model_membership->insert('app_membership_history', $data);
                    $this->model_membership->update('app_admin', array('package_id' => $package_id), "id='$this->login_id'");
                    $this->session->set_flashdata('msg', translate('transaction_success'));
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect('vendor/membership');
                } else {
                    $this->session->set_flashdata('msg', translate('transaction_fail'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('vendor/purchase-details/' . $package_id);
                }
            } else {
                $this->session->set_flashdata('msg', translate('invalid_card'));
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('vendor/purchase-details/' . $package_id);
            }
        } else {
            $this->session->set_flashdata('msg', translate('select_payment'));
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('vendor/purchase-details/' . $package_id);
        }
    }

}

?>