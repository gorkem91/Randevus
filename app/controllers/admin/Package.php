<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Package extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_package');
        $this->load->model('model_membership');
    }

    //show home page
    public function index() {
        $package = $this->model_package->getData('', '*');
        $data['package_data'] = $package;
        $data['title'] = translate('manage') . " " . translate('package');
        $this->load->view('admin/package-list', $data);
    }

    //show add package form
    public function add_package() {
        $data['title'] = translate('add') . " " . translate('package');
        $this->load->view('admin/manage-package', $data);
    }

    //show edit package form
    public function update_package($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $package = $this->model_package->getData("app_package", "*", "id='$id'");
        if (isset($package[0]) && !empty($package[0])) {
            $data['package_data'] = $package[0];
            $data['title'] = translate('update') . " " . translate('package');
            $this->load->view('admin/manage-package', $data);
        } else {
            show_404();
        }
    }

    //add/edit an package
    public function save_package() {
        $package_id = (int) $this->input->post('id', true);
        $this->form_validation->set_rules('title', '', 'required');
        $this->form_validation->set_rules('status', '', 'required');
        $this->form_validation->set_rules('price', '', 'required');
        $this->form_validation->set_rules('max_event', '', 'required');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == false) {
            if ($package_id > 0) {
                $this->update_package();
            } else {
                $this->add_package();
            }
        } else {
            $data['title'] = $this->input->post('title', true);
            $data['price'] = $this->input->post('price', true);
            $data['max_event'] = $this->input->post('max_event', true);
            $data['status'] = $this->input->post('status', true);

            if ($package_id > 0) {
                $this->model_package->update('app_package', $data, "id=$package_id");
                $this->session->set_flashdata('msg', translate('package_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                echo '<pre>';
                $this->model_package->insert('app_package', $data);
                $this->session->set_flashdata('msg', translate('package_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect('admin/manage-package', 'redirect');
        }
    }

    //delete an package
    public function delete_package($id = null) {
        if ($id == null) {
            $id = (int) $this->uri->segment(2);
        }
        $this->model_package->delete('app_package', 'id=' . $id);
        $this->session->set_flashdata('msg', translate('package_delete'));
        $this->session->set_flashdata('msg_class', 'success');
        echo true;
        exit;
    }

    //package payment page
    public function package_payment() {
        $data['payment_history'] = $this->model_membership->get_package_history();
        $data['title'] = translate('package_payment');
        $this->load->view('admin/package-payment-list', $data);
    }

}

?>