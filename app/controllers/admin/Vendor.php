<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendor extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_vendor');
        check_mandatory();
    }

    //show vendor list
    public function index() {
        $data['title'] = translate('manage') . " " . translate('vendor');

        $join = array(
            array(
                "table" => "app_package",
                "condition" => "app_package.id=app_admin.package_id",
                "jointype" => "LEFT")
        );
        $field = 'app_admin.*, app_package.title as package_name';
        $vendor = $this->model_vendor->getData("app_admin", $field, "type='V'", $join);
        $data['vendor_data'] = $vendor;
        $this->load->view('admin/vendor-list', $data);
    }

    //delete vendor
    public function delete_vendor($id) {
        $this->model_vendor->delete('app_admin', 'id=' . $id);
        $this->session->set_flashdata('msg', translate('vendor_deleted'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    //change status of vendor
    public function change_vendor_tatus($id) {
        $status = $this->input->post('status', true);
        $update = array(
            'status' => $status
        );
        $this->model_vendor->update('app_admin', $update, 'id=' . $id);
        $this->session->set_flashdata('msg', translate('vendor_status'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    public function vendor_payment() {
        $data['vendor_payment'] = $this->model_vendor->get_vendor_payment_list($this->login_id);
        $data['title'] = translate('vendor_Payment');
        $this->load->view('admin/vendor-payment-list', $data);
    }

    public function send_vendor_payment($id) {
        $this->model_vendor->update('app_appointment_payment', array('transfer_status' => 'S'), "id='$id'");
        $this->session->set_flashdata('msg', translate('vendor_payment_send'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

}

?>