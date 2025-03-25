<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appointment extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_appointment');
    }

    //show appointment page
    public function index($id = '0') {
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
        if ($this->login_type == 'V') {
            $cond = "app_event.created_by = $this->login_id";
        } else {
            $cond = '';
        }
        if ((int) $id > 0) {
            $cond = "app_event_book.event_id = '$id'";
        }
        $appointment = $this->model_appointment->getData('', 'app_event_book.*,app_customer.first_name,app_customer.last_name,app_event.title,app_event.created_by', $cond, $join, 'app_event_book.id DESC');
        $data['appointment_data'] = $appointment;
        $data['title'] = translate('manage') . " " . translate('appointment');
        $this->load->view('admin/appointment-list', $data);
    }

    public function change_appointment($id, $status) {
        if ((int) $id > 0) {
            $this->model_appointment->update('', array('status' => strtoupper($status)), "id='$id'");
            $this->session->set_flashdata('msg', str_replace('{status}', print_appointment_status(strtoupper($status)), translate('appointment_status')));
            $this->session->set_flashdata('msg_class', 'success');
        }
        echo 'true';
        exit;
    }

    public function send_remainder() {
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
        $id = $this->input->post('event_book_id', true);
        if ((int) $id > 0) {
            $cond = "app_event_book.id = '$id'";
            $appointment = $this->model_appointment->getData('', 'app_event_book.*,app_customer.first_name,app_customer.last_name,app_customer.email, app_event.title,app_event.description, app_event.created_by', $cond, $join);
           
            if (isset($appointment) && !empty($appointment)) {
                foreach ($appointment as $res) {
                    $event_title = $res['title'];
                    $name = ucfirst($res['first_name']) . " " . ucfirst($res['last_name']);
                    $email = $res['email'];
                    $description = $res['description'];
                    $startdate = date("m/d/Y", strtotime($res['start_date']));
                    $starttime = date("H:i a", strtotime($res['start_time']));
                }
                $define_param['to_name'] = $name;
                $define_param['to_email'] = $email;
                $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                          ' . translate('reminder_event_booking') . '
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
                                               Hi ' . $name . ',
                                                <br>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
                $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y", strtotime($startdate)) . '</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Appointment Time</th>';
                $html .= '<th style="border:1px solid #27aa90;">' . date("h:i a", strtotime($starttime)) . '</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Field</th>';
                $html .= '<th style="border:1px solid #27aa90;">Details</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Title</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . $event_title . '</td>';
                $html .= '</tr> ';
                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Description</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
                $html .= '</tr> ';
                $html .= '</table>
                    </center>';
                $html .= '</td>
                        </tr>
                    </table>';

                $subject = "Appointment Booking Reminder";
                $send = $this->sendmail->send($define_param, $subject, $html);
                if ($send) {
                    $this->session->set_flashdata('msg', translate('remainder_mail_success'));
                    $this->session->set_flashdata('msg_class', 'success');
                    
                }else{
                    $this->session->set_flashdata('msg', translate('remainder_mail_failure'));
                    $this->session->set_flashdata('msg_class', 'failure');
                 
                }
            }
        }
    }

}

?>