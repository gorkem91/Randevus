<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_customer');
    }

    //show customer list
    public function index() {
        $data['title'] = translate('manage') . " " . translate('customer');
        $order = "created_on DESC";
        $customer = $this->model_customer->getData("app_customer", "*", "", "", $order);
        $data['customer_data'] = $customer;
        $this->load->view('admin/customer-list', $data);
    }

    //delete customer
    public function delete_customer($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $this->model_customer->delete('app_customer', 'id=' . $id);
        $this->session->set_flashdata('msg', translate('customer_deleted'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    //change status of customer
    public function change_customer_tatus($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $status = $this->input->post('status', true);
        $update = array(
            'status' => $status
        );
        $this->model_customer->update('app_customer', $update, 'id=' . $id);
        $msg = isset($status) && $status == "A" ? "Active" : "Inactive";
        $this->session->set_flashdata('msg', translate('customer_status'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

}

?>