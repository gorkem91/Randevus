<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_dashboard');
    }

    //show admin dashboard
    public function index() {
        check_mandatory();
        $admin_id = (int) $this->session->userdata('ADMIN_ID');
        $data['total_vendor'] = $this->model_dashboard->Totalcount('app_admin', "type='V'");
        $data['total_payout_request'] = $this->model_dashboard->Totalcount('app_payment_request', "status!='S'");
        $data['total_customer'] = $this->model_dashboard->Totalcount('app_customer');
        $data['total_event'] = $this->model_dashboard->Totalcount('app_event');
        $data['total_appointment'] = $this->model_dashboard->Totalcount('app_event_book');
        $data['total_my_wallet'] = $this->model_dashboard->total_my_wallet($this->login_id);

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
        $data['title'] = translate('dashboard');
        $this->load->view('admin/dashboard', $data);
    }

    //show mandatory update
    public function mandatory_update() {
        $data['total_event_category'] = $this->model_dashboard->Totalcount('app_event_category');
        $data['total_location'] = $this->model_dashboard->Totalcount('app_location');
        $data['total_city'] = $this->model_dashboard->Totalcount('app_city');
        $data['total_package'] = $this->model_dashboard->Totalcount('app_package');
        $data['total_payment'] = $this->model_dashboard->check_payment();
        $data['title'] = translate('mandatory_update');
        $this->load->view('admin/mandatory-update', $data);
    }

    public function payout_request() {
        $fields = "";
        $fields .= "app_payment_request.*,CONCAT(app_admin.first_name,' ',app_admin.last_name) as vendor_name";
        $join = array(
            array(
                "table" => "app_admin",
                "condition" => "app_admin.id=app_payment_request.vendor_id",
                "jointype" => "INNER")
        );

        $payment_data = $this->model_dashboard->getData("app_payment_request", $fields, "", $join, "id DESC");

        $data['title'] = translate('payout_request');
        $data['payment_data'] = $payment_data;
        $this->load->view('admin/payout_request', $data);
    }

    public function payment_history() {
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

        $payment_data = $this->model_dashboard->getData("app_appointment_payment", $fields, "", $join, "id DESC");

        $data['title'] = translate('payout_request');
        $data['payment_data'] = $payment_data;
        $this->load->view('admin/payment_history', $data);
    }

    public function payment_status_update($id) {
        if ($id) {
            $payment_data = $this->model_dashboard->getData("app_appointment_payment", '*', "id=" . $id . " AND payment_status!='paid'");
            if (count($payment_data) > 0) {
                $data['payment_status'] = "paid";
                $this->model_dashboard->update('app_appointment_payment', $data, "id=$id");
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

    public function payment_update($id) {
        if ($id) {
            $payment_data = $this->model_dashboard->getData("app_payment_request", '*', "id=" . $id . " AND status!='S'");
            if (count($payment_data) > 0) {

                $payment_data = $payment_data[0];
                if (isset($payment_data['id']) && $payment_data['id'] > 0) {
                    $payment_data = $this->model_dashboard->getData("app_admin", 'first_name,last_name,email', "id=" . $payment_data['vendor_id']);

                    $first_name = isset($payment_data[0]['first_name']) ? $payment_data[0]['first_name'] : "";
                    $last_name = isset($payment_data[0]['last_name']) ? $payment_data[0]['last_name'] : "";
                    $email = isset($payment_data[0]['email']) ? $payment_data[0]['email'] : "";

                    $data['other_charge'] = $this->input->post('other_charge', true);
                    $data['updated_amount'] = $this->input->post('updated_amount', true);
                    $data['payment_gateway_fee'] = $this->input->post('payment_gateway_fee', true);
                    $data['status'] = 'S';
                    $data['reference_no'] = $this->input->post('reference_no', true);
                    $data['processed_date'] = date('Y-m-d H:i:s');
                    $this->model_dashboard->update('app_payment_request', $data, "id=$id");

                    $this->session->set_flashdata('msg', translate('payout_process'));
                    $this->session->set_flashdata('msg_class', 'success');

                    // Header
                    if (SEND_EMAIL) {


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
                                              ' . translate('payout_success_from_admin') . '
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>';

                        $subject = translate('payout_request');
                        if (isset($email) && $email != "" && $email != NULL) {
                            $define_param['to_name'] = $first_name . " " . $last_name;
                            $define_param['to_email'] = $email;
                            $this->sendmail->send($define_param, $subject, $html);
                        }
                    }
                    echo true;
                } else {
                    $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    echo FALSE;
                }
            } else {
                $this->session->set_flashdata('msg', $this->lang->line('Invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                echo FALSE;
            }
        }
    }

}

?>