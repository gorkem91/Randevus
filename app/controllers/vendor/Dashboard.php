<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        /*
         * check vendor module enable by admin
         */
        if (get_site_setting('is_display_vendor') == "N") {
            redirect('front');
        }
        $this->load->model('model_dashboard');
        $this->load->model('model_event');
    }

    //show vendor dashboard
    public function index() {
        $vendor_id = (int) $this->session->userdata('Vendor_ID');
        $commission_percentage = get_site_setting('commission_percentage');
        $package_id = $this->model_event->get_current_membership($vendor_id);
        $data['total_event'] = $this->model_dashboard->Totalcount('app_event', "created_by='$vendor_id'");
        $data['total_appointment'] = $this->model_dashboard->vendor_total_appointment($vendor_id);

        $join = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_event_book.customer_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_event",
                "condition" => "app_event.id=app_event_book.event_id",
                "jointype" => "LEFT")
        );
        $current_date = date('Y-m-d');
        $up_date = date('Y-m-d', strtotime(date('Y-m-d') . ' + 10 days'));
        $current_time = date('H:i:s');
        $cond = "app_event_book.start_date >= '$current_date' AND app_event_book.start_date <= '$up_date' AND app_event.created_by='$this->login_id'";
        $appointment = $this->model_dashboard->getData('app_event_book', 'app_event_book.*,app_customer.first_name,app_customer.last_name,app_event.created_by', $cond, $join);

        $data['appointment_data'] = $appointment;

        //get total amount
        $joins = array(
            array(
                "table" => "app_event",
                "condition" => "app_event.id=app_event_book.event_id",
                "jointype" => "INNER")
        );
        $vendor_appointment_amount = $this->model_dashboard->getData('app_event_book', 'SUM(app_event_book.vendor_price) as vendor_appointment_amount', "app_event.created_by=" . $vendor_id, $joins);

        $data['commission_percentage'] = $commission_percentage;
        $data['vendor_appointment_amount'] = $vendor_appointment_amount;
        $data['title'] = translate('dashboard');
        $this->load->view('vendor/dashboard', $data);
    }

    public function wallet() {
        $data['title'] = translate('my_wallet_amount');
        $Vendor_ID = $this->session->userdata('Vendor_ID');
        if (isset($Vendor_ID) && $Vendor_ID > 0) {
            $minimum_vendor_payout = get_site_setting('minimum_vendor_payout');
            $total = $this->model_dashboard->getData('app_admin', 'my_wallet', "id = " . $Vendor_ID);
            $data['payment_data'] = $this->model_dashboard->getData("app_payment_request", '*', '', "vendor_id=" . $Vendor_ID, "id desc");
            $data['minimum_vendor_payout'] = $minimum_vendor_payout;
            $data['total_wallet'] = isset($total[0]['my_wallet']) ? $total[0]['my_wallet'] : "";
            $this->load->view('vendor/payout_request', $data);
        } else {
            redirect('vendor/dashboard');
        }
    }

    public function payment_history() {
        $Vendor_ID = $this->session->userdata('Vendor_ID');
        $fields = "";
        $fields .= "app_appointment_payment.*,CONCAT(app_admin.first_name,' ',app_admin.last_name) as vendor_name,app_event.title as event_name,CONCAT(app_customer.first_name,' ',app_customer.last_name) as customer_name";
        $join = array(
            array(
                "table" => "app_admin",
                "condition" => "app_admin.id=app_appointment_payment.vendor_id",
                "jointype" => "INNER"),
            array(
                "table" => "app_event",
                "condition" => "app_event.id=app_appointment_payment.event_id",
                "jointype" => "INNER"),
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_appointment_payment.customer_id",
                "jointype" => "INNER")
        );

        $payment_data = $this->model_dashboard->getData("app_appointment_payment", $fields, "app_appointment_payment.vendor_id=" . $Vendor_ID, $join, "id DESC");

        $data['title'] = translate('payout_request');
        $data['payment_data'] = $payment_data;
        $this->load->view('vendor/payment_history', $data);
    }

    public function payment_request_save() {
        $Vendor_ID = $this->session->userdata('Vendor_ID');
        if ($Vendor_ID > 0) {
            $minimum_vendor_payout = get_site_setting('minimum_vendor_payout');
            $vendor_wallet = $this->model_dashboard->getData("app_admin", 'my_wallet', '', "vendor_id=" . $Vendor_ID);

            if (isset($vendor_wallet[0]['my_wallet']) && $vendor_wallet[0]['my_wallet'] > 0) {

                $my_wallet = $this->input->post('payout_amount');

                if ($my_wallet > $vendor_wallet[0]['my_wallet']) {
                    $this->session->set_flashdata('msg', translate('wallet_error'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('vendor/payout-request');
                } else {
                    if ($my_wallet >= $minimum_vendor_payout) {
                        $app_vendor_payment['vendor_id'] = $Vendor_ID;
                        $app_vendor_payment['amount'] = $my_wallet;
                        $app_vendor_payment['created_date'] = date('Y-m-d H:i:s');
                        $app_vendor_payment['status'] = 'P';
                        $app_vendor_payment['payment_gateway_ref'] = $this->input->post('payment_gateway_ref');
                        $app_vendor_payment['choose_payment_gateway'] = $this->input->post('payment_gateway');

                        $this->db->insert('app_payment_request', $app_vendor_payment);
                        $id = $this->db->insert_ID();
                        if ($id) {
                            $this->db->query("UPDATE app_admin SET my_wallet=my_wallet-" . $my_wallet . " WHERE id=" . $Vendor_ID);
                            $this->session->set_flashdata('msg', translate('payout_request_success'));
                            $this->session->set_flashdata('msg_class', 'success');
                            if (SEND_EMAIL) {


                                // Header
                                $html = "";
                                $html .= '<table cellspacing="0" cellpadding="0" style="background-color:#3bcdb0;width: 100%;">
                        <tr>
                            <td style = "background-color:#3bcdb0;">
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style = "font-size:40px; padding: 10px 25px; color: #ffffff; text-align:center;" class = "mobile-spacing">
                                              ' . translate('payout_request') . '
                                        <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>';

                                $html .= '<table cellspacing = "0" cellpadding = "0" style = "width: 100%;" bgcolor = "#ffffff" >
                        <tr>
                            <td style = "background-color:#ffffff; padding-top: 15px;">
                                <center>
                                <table style = "margin: 0 auto;width: 90%;" cellspacing = "0" cellpadding = "0">
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                                <br>
                                              ' . translate('payout_mail_content') . '
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>';

                                $subject = translate('payout_request');
                                $define_param['to_name'] = "Admin";
                                $define_param['to_email'] = ADMIN_EMAIL;
                                $this->sendmail->send($define_param, $subject, $html);
                            }
                            redirect('vendor/payout-request');
                        } else {
                            $this->session->set_flashdata('msg', translate('payout_request_error'));
                            $this->session->set_flashdata('msg_class', 'failure');
                            redirect('vendor/payout-request');
                        }
                    } else {
                        $this->session->set_flashdata('msg', translate('payout_minimum_amount') . " $" . $minimum_vendor_payout);
                        $this->session->set_flashdata('msg_class', 'failure');
                        redirect('vendor/payout-request');
                    }
                }
            } else {
                $this->session->set_flashdata('msg', translate('payout_minimum_amount') . " $" . $minimum_vendor_payout);
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('vendor/payout-request');
            }
        } else {
            redirect('vendor/dashboard');
        }
    }

    public function payment_status_update($id) {
        if ($id) {
            $payment_data = $this->model_dashboard->getData("app_appointment_payment", '*', "id=" . $id . " AND payment_status!='paid'");
            if (count($payment_data) > 0) {
                $Vendor_ID = $this->session->userdata('Vendor_ID');
                $data['payment_status'] = "paid";
                $this->model_dashboard->update('app_appointment_payment', $data, "id=" . $id . " AND vendor_id=" . $Vendor_ID);
                $this->session->set_flashdata('msg', translate('status_update'));
                $this->session->set_flashdata('msg_class', 'success');
                echo true;
                exit(0);
            } else {
                $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                echo FALSE;
                exit(0);
            }
        } else {
            $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            echo FALSE;
            exit(0);
        }
    }

}

?>