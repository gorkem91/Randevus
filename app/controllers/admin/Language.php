<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Language extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_event');
    }

    //show language page
    public function index() {
        $language_data = $this->model_event->getData('app_language', '*');
        $data['language_data'] = $language_data;
        $data['title'] = translate('manage') . " " . translate('language');
        $this->load->view('admin/language/language_list', $data);
    }

    //show add language form
    public function add_language() {
        $data['title'] = translate('add') . " " . translate('language');
        $this->load->view('admin/language/add_update_language', $data);
    }

    //show edit language form
    public function update_language($id) {
        $language_data = $this->model_event->getData("app_language", "*", "id='$id'");
        if (count($language_data) > 0) {
            $data['language_data'] = $language_data[0];
            $data['title'] = translate('update') . " " . translate('language');
            $this->load->view('admin/language/add_update_language', $data);
        } else {
            redirect('admin/language');
        }
    }

    //Set Language Translation
    public function language_translate($id) {
        $language_data = $this->model_event->getData("app_language", "*", "id='$id'");
        if (count($language_data) > 0) {

            $this->db->order_by('id', 'asc');
            $data['words'] = $this->db->get('app_language_data')->result_array();
            $data['title'] = translate('translate') . " " . translate('words');
            $data['language_data'] = $language_data[0];
            $this->load->view('admin/language/language_translate', $data);
        } else {
            $this->session->set_flashdata('msg', translate('invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('admin/language');
        }
    }

    //add/edit an language
    public function save_language() {
        $id = (int) $this->input->post('id', true);
        $this->form_validation->set_rules('title', '', 'trim|alpha_numeric_spaces|required|is_unique[app_language.title.id.' . $id . ']');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($id > 0) {
                $this->update_language($id);
            } else {
                $this->add_language();
            }
        } else {
            $data['title'] = strtolower($this->input->post('title', true));
            $data['status'] = $this->input->post('status', true);
            if ($id > 0) {
                $id = $this->model_event->update('app_language', $data, "id=$id");
                $this->session->set_flashdata('msg', translate('language_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_date'] = date('Y-m-d H:i:s');
                $data['db_field'] = strtolower(str_replace(' ', '_', $this->input->post('title', true)));
                $id = $this->model_event->insert('app_language', $data);

                $this->add_language_field(strtolower($this->input->post('title', true)));
                $this->session->set_flashdata('msg', translate('language_add'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect('admin/manage-language');
        }
    }

    //delete an language
    public function delete_language($id) {
        $id = (int) $id;
        $app_site_setting = $this->model_event->getData('app_site_setting', 'language', "id=1");
        $get_lang_data = $this->model_event->getData('app_language', 'title', "id=" . $id);
        if ($id > 1) {
            if (isset($get_lang_data[0]['title'])) {
                if ($app_site_setting[0]['language'] == $get_lang_data[0]['db_field']) {
                    $this->session->set_flashdata('msg', translate('language_used'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    echo 'false';
                    exit;
                } else {
                    //get language data
                    //Delete Lanaguage Column
                    $delete_langu_column = str_replace(' ', '_', $get_lang_data[0]['title']);
                    $this->load->dbforge();
                    $this->dbforge->drop_column('app_language_data', $delete_langu_column);

                    $this->model_event->delete('app_language', 'id=' . $id);
                    $this->session->set_flashdata('msg', translate('language_delete'));
                    $this->session->set_flashdata('msg_class', 'success');
                    echo 'true';
                    exit;
                }
            } else {
                echo 'false';
                exit(0);
            }
        } else {
            $this->session->set_flashdata('msg', translate('language_used'));
            $this->session->set_flashdata('msg_class', 'failure');

            echo 'false';
            exit(0);
        }
    }

    public function add_language_field($language) {
        $language = str_replace(' ', '_', $language);
        $this->db->query("ALTER TABLE `app_language_data` ADD " . $language . " TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL");
    }

    public function save_translated_language() {
        $id = (int) $this->input->post('id', true);
        $field = $this->input->post('field', true);
        $text_value = $this->input->post('text_value', true);

        $data[$field] = $text_value;
        $this->model_event->update('app_language_data', $data, 'id=' . $id);
        echo TRUE;
    }

}

?>