<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include APPPATH . 'third_party/mail/class.phpmailer.php';
include APPPATH . "third_party/mail/class.smtp.php";

class Sendmail {

    public function send($toparam = array(), $subject, $html_body, $attachment = NULL) {
        

        $CI = & get_instance();
        $CI->db->select('*', FALSE);
        $CI->db->from('app_email_setting');
        $email_datat = $CI->db->get()->row_array();

        $CI->db->select('*', FALSE);
        $CI->db->from('app_site_setting');
        $sitesetting_datat = $CI->db->get()->row_array();

        $smtp_host = isset($email_datat['smtp_host']) ? $email_datat['smtp_host'] : "smtp.gmail.com";
        $smtp_username = isset($email_datat['smtp_username']) ? $email_datat['smtp_username'] : "test@xyz.com";
        $smtp_password = isset($email_datat['smtp_password']) ? $email_datat['smtp_password'] : "password";
        $smtp_port = isset($email_datat['smtp_port']) ? $email_datat['smtp_port'] : 587;
        $smtp_secure = isset($email_datat['smtp_secure']) ? $email_datat['smtp_secure'] : "tsl";
        $email_from_name = isset($email_datat['email_from_name']) ? $email_datat['email_from_name'] : "Knowledge Base Admin Panel";

        $CI = & get_instance();
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = $smtp_secure;
        $mail->Port = $smtp_port;
        $mail->From = $smtp_username;
        $mail->FromName = $email_from_name;

        if (isset($toparam) && count($toparam) > 0) {
            $to_email = $toparam['to_email'];
            $to_name = $toparam['to_name'];
        }

        if (file_exists(dirname(BASEPATH) . "/" . uploads_path . '/sitesetting/' . $sitesetting_datat['company_logo']) && $sitesetting_datat['company_logo'] != '') {
            $logo_image = base_url() . uploads_path . '/sitesetting/' . $sitesetting_datat['company_logo'];
        } else {
            $logo_image = base_url() . img_path . "/no-image.png";
        }
        // Main
        $html = '<table align="center" cellpadding="0" cellspacing="0" width="600px" >
                    <tr>
                        <td align="center" valign="top" width="100%">
                        <center>
                            <table cellspacing="0" cellpadding="0" width="600" class="w320">
                                <tr>
                                    <td align="center" valign="top">
                                        <table style="margin:15px auto;" cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td style="text-align: center;">
                                                    <a href="#"><img class="w320" src="' . $logo_image . '" alt="company logo" ></a>
                                                </td>
                                            </tr>
                                        </table>';
        // Main Body
        $html .= $html_body;


        // Footer
        $html .= '<table style="margin: 0 auto;width: 90%;color: #6f6f6f;" cellspacing="0" cellpadding="0">';
        $html .= '<tr>';
        $html .= '<td style="text-align: left;">
                            <br>
                              ' . translate('thank_you'). ',
                            <br>
                            ' . get_CompanyName() . '
                        </td>';
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '<table cellspacing="0" cellpadding="0" bgcolor="#363636"  style="width: 100%;margin: 30px auto 0;">';
        $html .= '<tr>';
        $html .= '<td style="color:#f0f0f0; font-size: 14px; text-align:center; padding: 20px;">'
                . '© ' . date("Y") . ' ' . translate('rights_reserved_message') . '
                        </td>';
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</table>';

        $mail->addAddress($to_email, $to_name);
        if ($attachment != NULL) {
            $mail->addAttachment($attachment);
        }
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html;
        
//        echo $html; exit;

        if (MAIL_SWITCH == true) {
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        }
    }

}
