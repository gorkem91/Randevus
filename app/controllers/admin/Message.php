<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_message');
    }

    //show message page
    public function index($id = NULL) {
        $login_id = $this->login_id;
        $data['customer_list'] = $this->model_message->message_customer_list($this->login_id);

        if (is_null($id)) {
            $id = isset($data['customer_list'][0]) ? $data['customer_list'][0]['customer_id'] : 0;
        }
        $this->model_message->update('app_chat', array('msg_read' => 'Y'), "to_id='$login_id' AND from_id='$id' AND chat_type='C'");

        $data['msg_customer_data'] = $this->model_message->msg_customer_data($id);

        $data['msg_group_list'] = $this->model_message->msg_group_list($this->login_id, $id);
        $data['title'] = translate('manage') . " " . translate('event');
        $this->load->view('admin/message', $data);
    }

    public function message_action() {
        $from_id = (int) $this->login_id;
        $to_id = (int) $this->input->post('msg_to_id');
        $message = $this->input->post('message');
        $chat_id = (int) $this->model_message->get_chat_id($from_id, $to_id);
        if (isset($chat_id) && $chat_id > 0) {
            $inser_data = array(
                'chat_id' => $chat_id,
                'to_id' => $to_id,
                'from_id' => $from_id,
                'message' => $message,
                'chat_type' => 'NC',
                'created_on' => date('Y-m-d H:i:s')
            );
            $this->model_message->insert('app_chat', $inser_data);
        }
        $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
        redirect($folder_url . '/message/' . $to_id);
    }

}

?>