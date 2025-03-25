<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_customer');
        $this->lang->load('basic', get_Langauge());
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    //show customer dashboard if authenticated
    public function index() {
        $this->authenticate->check();
        redirect('dashboard');
    }

    //cutomer login
    public function login() {
        $next = $this->input->get('next');
        if (!$this->session->userdata('CUST_ID')) {
            $data['title'] = translate('login');
            $data['next'] = $next;
            $this->load->view('front/login', $data);
        } else {
            redirect('dashboard');
        }
    }

    //check authentication of cutomer when login
    public function login_action() {

        $username = $this->db->escape($this->input->post("username", true));
        $next = $this->input->post("next", true);
        $password = $this->input->post("password", true);
        $this->form_validation->set_rules('username', '', 'trim|required');
        $this->form_validation->set_rules('password', '', 'trim|required');
        $this->form_validation->set_message('required', translate('required_message'));
        if ($this->form_validation->run() == false) {
            $this->login();
        } else {
            $users = $this->model_customer->authenticate($username, $password);
            //Check for login
            if ($users['errorCode'] == 0) {
                $this->session->set_flashdata('msg', $users['errorMessage']);
                $this->session->set_flashdata('msg_class', 'failure');
                $this->login();
            } else {
                $this->session->set_flashdata('msg', translate('login_success'));
                $this->session->set_flashdata('msg_class', 'success');

                if (isset($next) && $next != "") {
                    redirect(base_url($next));
                } else {
                    redirect(base_url());
                }
            }
        }
    }

    //customer forgot password 
    public function forgot_password() {
        if (!$this->session->userdata('CUST_ID')) {
            $company_data = $this->model_customer->getData("app_site_setting", "*");
            $data['title'] = translate('forgot_password');
            $data['company_data'] = $company_data[0];
            $this->load->view('front/forgot_password', $data);
        } else {
            redirect(base_url("dashboard"));
        }
    }

    //authenticate email of customer and send mail
    public function forgot_password_action() {
        $email = $this->input->post("email", true);
        $rply = $this->model_customer->check_username($email);
        $this->load->helper('string');
        if ($rply['errorCode'] == 1) {
            $define_param['to_name'] = ucfirst($rply['Firstname']) . " " . ucfirst($rply['Lastname']);
            $define_param['to_email'] = $rply['Email'];
            $userid = $rply['ID'];
            $hidenuseremail = $rply['Email'];
            $hidenusername = ucfirst($rply['Firstname']) . " " . ucfirst($rply['Lastname']);
            //Encryprt data
            $encid = $this->general->encryptData($userid);
            $encemail = $this->general->encryptData($hidenuseremail);
            $url = $this->config->item("site_url") . "reset-password-admin/" . $encid . "/" . $encemail;

            $update['reset_password_check'] = 0;
            $update['reset_password_requested_on'] = date("Y-m-d H:i:S");
            $result = $this->model_customer->update("app_customer", $update, "ID='" . $userid . "'");

            // Header
            $html = "";
            $html .= '<table cellspacing="0" cellpadding="0" style="background-color:#3bcdb0;width: 100%;">
                        <tr>
                            <td style = "background-color:#3bcdb0;">
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style = "font-size:40px; padding: 10px 25px; color: #ffffff; text-align:center;" class = "mobile-spacing">
                                              ' . translate('forgot_mail_message') . '
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
                                              ' . translate('forgot_mail_content') . '
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table style = "margin:0 auto;" cellspacing = "0" cellpadding = "10" width = "100%">
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:center; margin:0 auto;">
                                                <br>
                                                    <div>
                                                    <a  style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:220px;-webkit-text-size-adjust:none;" href = "' . $url . '">' . translate('reset_password') . '</a>
                                                    </div>
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>';

            $subject = translate('reset_password');
            $define_param['to_name'] = $hidenusername;
            $define_param['to_email'] = $hidenuseremail;
            $this->sendmail->send($define_param, $subject, $html);

            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'success');
            redirect('login');
        } else {
            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('forgot-password');
        }
    }

    //show cutomer reset password form
    public function reset_password() {
        $id_ency = $this->uri->segment(2);
        $email_ency = $this->uri->segment(3);

        $id = (int) $this->general->decryptData($id_ency);
        $email = $this->general->decryptData($email_ency);
        $customer_data = $this->model_customer->getData("app_customer", "*", "id='" . $id . "' AND email='" . $email . "'");

        if (count($customer_data) > 0) {
            $add_min = date("Y-m-d H:i:s", strtotime($customer_data[0]['reset_password_requested_on'] . "+1 hour"));
            if ($add_min > date("Y-m-d H:i:s")) {
                if ($customer_data[0]['reset_password_check'] != 1) {
                    $content_data['title'] = translate('reset_password');
                    $content_data['id'] = $id;
                    $this->load->view('front/reset_password', $content_data);
                } else {
                    $this->session->set_flashdata('failure', translate('reset_failure'));
                    redirect('forgot_password');
                }
            } else {
                $this->session->set_flashdata('failure', translate('reset_failure'));
                redirect('forgot-password');
            }
        } else {
            $this->session->set_flashdata('failure', translate('invalid_request'));
            redirect('forgot-password');
        }
    }

    //reset password
    public function reset_password_action() {
        $password = $this->input->post('password');
        $id = $this->input->post('id');

        $this->form_validation->set_rules('password', '', 'trim|required');
        $this->form_validation->set_rules('Cpassword', '', 'trim|required');
        $this->form_validation->set_message('required', translate('required_message'));
        if ($this->form_validation->run() == false) {
            $content_data['id'] = $id;
            $this->load->view('front/reset_password', $content_data);
        } else {
            $update['reset_password_check'] = 1;
            $update['reset_password_requested_on'] = "0000-00-00 00:00:00";
            $update['password'] = md5($password);
            $this->model_customer->update("app_customer", $update, "id='" . $id . "'");
            $this->session->set_flashdata('msg', translate('reset_success'));
            $this->session->set_flashdata('msg_class', 'success');
            redirect('login');
        }
    }

    //show customer change password form
    public function update_password() {
        $this->authenticate->check();
        $data['title'] = translate('update_password');
        $this->load->view('front/update_password', $data);
    }

    //change password
    public function update_password_action() {
        $user_id = (int) $this->session->userdata('CUST_ID');
        $this->authenticate->check();
        $this->form_validation->set_rules('old_password', '', 'trim|required');
        $this->form_validation->set_rules('password', '', 'trim|required');
        $this->form_validation->set_rules('confirm_password', '', 'trim|required');
        $this->form_validation->set_message('required', translate('required_message'));
        if ($this->form_validation->run() == false) {
            $this->update_password();
        } else {
            $password = $this->input->post('old_password');
            $new_password = $this->input->post('password');
            $id = (int) $this->session->userdata("CUST_ID");
            $get_result = $this->model_customer->getData("app_customer", "*", "id='" . $id . "'");
            if (count($get_result) > 0) {
                $old_password = $get_result[0]['password'];
                if (isset($password) && $old_password == md5($password)) {
                    $update['default_password_changed'] = 1;
                    $update['password'] = md5($new_password);
                    $this->model_customer->update("app_customer", $update, "id='" . $id . "'");
                    $this->session->set_userdata("DefaultPassword", 1);
                    $this->session->set_flashdata('msg', translate('reset_success'));
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect('change-password');
                } else {
                    $this->session->set_flashdata('msg', translate('current_password_failure'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('change-password');
                }
            } else {
                $this->session->set_flashdata('msg', translate('invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('login');
            }
        }
    }

    //show customer profile
    public function profile() {
        $data['title'] = translate('customer_profile');
        $this->authenticate->check();
        $id = (int) $this->session->userdata('CUST_ID');
        if ($id > 0) {
            $customer_data = $this->model_customer->getData("app_customer", "*", "id=" . $id);
            if (isset($customer_data) && count($customer_data) > 0 && !empty($customer_data)) {
                $data['title'] = translate('profile');
                $data['customer_data'] = $customer_data[0];
                $this->load->view('front/profile', $data);
            } else {
                $this->session->set_flashdata('msg', translate('invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                show_404();
            }
        } else {
            $this->session->set_flashdata('msg', translate('invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            show_404();
        }
    }

    //update profile
    public function profile_save() {
        $user_id = (int) $this->session->userdata('CUST_ID');
        $this->authenticate->check();

        $this->form_validation->set_rules('first_name', '', 'required');
        $this->form_validation->set_rules('last_name', '', 'required');
        $this->form_validation->set_rules('email', '', 'required|is_unique[app_customer.Email.ID.' . $user_id . ']');
        $this->form_validation->set_rules('phone', '', 'required|is_unique[app_customer.Phone.ID.' . $user_id . ']');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->profile();
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'updated_on' => date("Y-m-d H:i:s")
            );
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != '') {

                $uploadPath = uploads_path . '/profiles';
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                $data['profile_image'] = $newfilename;
            }

            $result = $this->model_customer->update("app_customer", $data, "id='" . $user_id . "'");
            $this->session->set_flashdata('msg', translate('profile_success'));
            $this->session->set_flashdata('msg_class', "success");
            redirect('profile');
        }
    }

    //show customer register form
    public function register() {
        $next = $this->input->get('next');
        $data['next'] = $next;
        $data['title'] = translate('register');
        $this->load->view('front/register', $data);
    }

    //customer registration
    public function register_save() {
        $next = $this->input->post("next", true);
        $this->form_validation->set_rules('first_name', '', 'required');
        $this->form_validation->set_rules('last_name', '', 'required');
        $this->form_validation->set_rules('email', '', 'required|is_unique[app_customer.email]');
        $this->form_validation->set_rules('password', '', 'required');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->register();
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
                'created_on' => date("Y-m-d H:i:s")
            );

            $result = $this->model_customer->insert("app_customer", $data);
            $name = ucfirst($this->input->post('first_name')) . " " . ucfirst($this->input->post('last_name'));
            $hidenuseremail = $this->input->post('Email');
            // Header
            $html = "";
            $html .= '<table cellspacing="0" cellpadding="0" style="background-color:#3bcdb0;width: 100%;">
                        <tr>
                            <td style = "background-color:#3bcdb0;">
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style = "font-size:40px; padding: 10px 25px; color: #ffffff; text-align:center;" class = "mobile-spacing">
                                             ' . translate('account_registration') . '
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
                                               ' . translate('register_mail_message') . ' ' . $name . ',
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                                <br>
                                               ' . translate('register_mail_message') . '
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                    </table>';
            $subject = translate('account_registration');
            $define_param['to_name'] = $name;
            $define_param['to_email'] = $hidenuseremail;
            $send = $this->sendmail->send($define_param, $subject, $html);
            $this->session->set_flashdata('msg', translate('register_success'));
            $this->session->set_flashdata('msg_class', "success");

            if (isset($next) && $next != "") {
                redirect(base_url($next));
            } else {
                redirect('login');
            }
        }
    }

    //cutomer logout
    public function logout() {
        $this->session->unset_userdata('CUST_ID');
        $this->session->unset_userdata('DefaultPassword');
        $this->session->set_flashdata('msg', translate('logout_success'));
        $this->session->set_flashdata('msg_class', 'success');
        redirect(base_url());
    }

    //show customer register form
    public function vendor_register() {
        if ($this->session->userdata('Vendor_ID')) {
            $this->session->set_flashdata('msg_class', "failure");
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect('vendor/dashboard');
        }
        $data['title'] = translate('register');
        $package_data = $this->model_customer->getData("app_package", "*", "status='A'");
        $data['package_data'] = $package_data;
        $this->load->view('front/vendor_register', $data);
    }

    //customer registration
    public function vendor_register_save() {
        $this->form_validation->set_rules('first_name', '', 'required');
        $this->form_validation->set_rules('last_name', '', 'required');
        $this->form_validation->set_rules('email', '', 'required|is_unique[app_admin.email]');
        $this->form_validation->set_rules('password', '', 'required');
        $this->form_validation->set_rules('company', '', 'required');
        $this->form_validation->set_rules('website', '', 'required');
        $this->form_validation->set_rules('phone', '', 'required|is_unique[app_admin.phone]');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class = "error"> ', '</div>');
        if ($this->form_validation->run() == false) {
            $this->vendor_register();
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
                'company_name' => $this->input->post('company'),
                'website' => $this->input->post('website'),
                'phone' => $this->input->post('phone'),
                'type' => 'V',
                'status' => 'P',
                'created_on' => date("Y-m-d H:i:s")
            );

            $insert_id = $this->model_customer->insert("app_admin", $data);
            $this->vendor_verify_resend($insert_id);
        }
    }

    public function verify_vendor($encid, $encemail) {
        $id = (int) $this->general->decryptData($encid);
        $email = $this->general->decryptData($encemail);
        $vendor_data = $this->model_customer->getData("app_admin", "*", "id='" . $id . "' AND email='" . $email . "'");
        if (count($vendor_data) > 0) {
            $add_min = date("Y-m-d H:i:s", strtotime($vendor_data[0]['created_on'] . "+1 hour"));
            if ($add_min > date("Y-m-d H:i:s")) {
                if ($vendor_data[0]['profile_status'] == 'N') {
                    $this->model_customer->update('app_admin', array('profile_status' => 'V'), "id='$id'");
                    $this->session->set_flashdata('msg_class', "success");
                    $this->session->set_flashdata('msg', translate('account_verify_success'));
                    redirect('vendor/login');
                } else {
                    $this->session->set_flashdata('msg_class', "failure");
                    $this->session->set_flashdata('msg', translate('already_vendor_verify'));
                    redirect('vendor-register');
                }
            } else {
                $this->session->set_flashdata('msg_class', "failure");
                $this->session->set_flashdata('msg', translate('vendor_verify_failure'));
                redirect('vendor-register');
            }
        } else {
            $this->session->set_flashdata('msg_class', "failure");
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect('vendor-register');
        }
    }

    public function vendor_verify_resend($id) {
        $vendor_result = $this->model_customer->getData('app_admin', '*', "id='$id' AND profile_status='N'");

        if (count($vendor_result) > 0) {

            $this->model_customer->update('app_admin', array('created_on' => date("Y-m-d H:i:s")), "id='$id'");

            $encid = $this->general->encryptData($id);
            $encemail = $this->general->encryptData($vendor_result[0]['email']);
            $url = base_url('verify-vendor/' . $encid . "/" . $encemail);
            $name = ucfirst($vendor_result[0]['first_name']) . " " . ucfirst($vendor_result[0]['last_name']);
            $hidenuseremail = $vendor_result[0]['email'];
            // Header
            $html = "";
            $html .= '<table cellspacing="0" cellpadding="0" style="background-color:#3bcdb0;width: 100%;">
                        <tr>
                            <td style = "background-color:#3bcdb0;">
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style = "font-size:40px; padding: 10px 25px; color: #ffffff; text-align:center;" class = "mobile-spacing">
                                             ' . translate('account_registration') . '
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
                                              ' . translate('account_verification_content') . '
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table style = "margin:0 auto;" cellspacing = "0" cellpadding = "10" width = "100%">
                                    <tbody>
                                        <tr>
                                            <td style = "text-align:center; margin:0 auto;">
                                                <br>
                                                    <div>
                                                    <a  style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:220px;-webkit-text-size-adjust:none;" href = "' . $url . '">' . translate('click_here') . '</a>
                                                    </div>
                                                <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>';
            $subject = translate('account_registration');
            $define_param['to_name'] = $name;
            $define_param['to_email'] = $hidenuseremail;
            $send = $this->sendmail->send($define_param, $subject, $html);
            $this->session->set_flashdata('msg', translate('vendor_mail_success'));
            $this->session->set_flashdata('msg_class', "success");
            redirect('vendor');
        } else {
            $this->session->set_flashdata('msg_class', "failure");
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect('vendor');
        }
    }

    public function check_vendor_email() {
        $email = $this->input->post('email');
        $check_title = $this->model_customer->getData("app_admin", "email", "email='$email'");
        if (isset($check_title) && count($check_title) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    public function check_vendor_phone() {
        $phone = $this->input->post('phone');
        $check_title = $this->model_customer->getData("app_admin", "phone", "phone='$phone'");
        if (isset($check_title) && count($check_title) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

}
