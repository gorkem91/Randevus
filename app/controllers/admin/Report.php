<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_report');
    }

    //Show Vendor Report Page
    public function index() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        if ($month != '' || $year != '') {
            if ($month != '' && $year != '') {
                $condition = "MONTH(created_on) = '$month' AND YEAR(created_on) = '$year' AND type='V'";
            } elseif ($month != '') {
                $condition = "MONTH(created_on) = '$month' AND type='V'";
            } elseif ($year != '') {
                $condition = "MONTH(created_on) = MONTH(CURRENT_DATE()) AND YEAR(created_on) = '$year' AND type='V'";
            }
        } else {
            $condition = "MONTH(created_on) = (MONTH(CURRENT_DATE())) AND YEAR(created_on) AND type='V'";
            $month = date("m");
            $year = date("Y");
        }

        $data['month'] = $month;
        $data['year'] = $year;
        $monthly = $this->model_report->getData("app_admin", "*, COUNT(created_on) AS total, day(created_on) as day", $condition, "", "", "DATE(created_on)");
        $data['product_data'] = $monthly;
        $yeardata = $this->model_report->getData("app_admin", "MIN(YEAR(created_on)) as min,MAX(YEAR(created_on)) as max");
        $data['title'] = translate('vendor_report');
        $this->load->view('admin/vendor-report', $data);
    }

    //Show Customer Report Page
    public function customer_report() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        if ($month != '' || $year != '') {
            if ($month != '' && $year != '') {
                $condition = "MONTH(created_on) = '$month' AND YEAR(created_on) = '$year'";
            } elseif ($month != '') {
                $condition = "MONTH(created_on) = '$month'";
            } elseif ($year != '') {
                $condition = "MONTH(created_on) = MONTH(CURRENT_DATE()) AND YEAR(created_on) = '$year'";
            }
        } else {
            $condition = "MONTH(created_on) = (MONTH(CURRENT_DATE())) AND YEAR(created_on)";
            $month = date("m");
            $year = date("Y");
        }

        $data['month'] = $month;
        $data['year'] = $year;
        $monthly = $this->model_report->getData("app_customer", "*, COUNT(created_on) AS total, day(created_on) as day", $condition, "", "", "DATE(created_on)");
        $data['product_data'] = $monthly;
        $yeardata = $this->model_report->getData("app_customer", "MIN(YEAR(created_on)) as min,MAX(YEAR(created_on)) as max");
        $data['title'] = translate('customer_report');
        $this->load->view('admin/customer-report', $data);
    }

    //Show Appointment Report Page
    public function appointment_report() {
        if ($this->login_type == 'V') {
            $vendor_id = $this->login_id;
        } else {
            $vendor_id = $this->input->post('vendor_id');
        }
        $year = $this->input->post('year');

        $join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_event_book.event_id=app_event.id',
                'jointype' => 'left'
            )
        );

        if ($vendor_id != '' || $year != '') {
            if ($vendor_id != '' && $year != '') {
                $condition = "app_event.created_by = '$vendor_id' AND YEAR(app_event_book.created_on) = '$year'";
            } elseif ($vendor_id != '') {
                $condition = "app_event.created_by   = '$vendor_id'";
            } elseif ($year != '') {
                $condition = "YEAR(app_event_book.created_on) = '$year'";
            }
        } else {
            $year = date("Y");
            $condition = "YEAR(app_event_book.created_on) = '$year'";
        }
        $data['login_type'] = $this->login_type;
        $data['vendor_id'] = $vendor_id;
        $data['year'] = $year;
        $monthly = $this->model_report->getData("app_event_book", "COUNT(app_event_book.id) AS total , MONTH(app_event_book.created_on) as month", $condition, $join, "", "MONTH(app_event_book.created_on),YEAR(app_event_book.created_on)");
        $data['product_data'] = $monthly;
        $data['vendor_list'] = $this->model_report->getData("app_admin", "*");
        $yeardata = $this->model_report->getData("app_event_book", "MIN(YEAR(created_on)) as min,MAX(YEAR(created_on)) as max");
        $data['year_data'] = $yeardata[0];
        $data['title'] = translate('appointment_report');
        $this->load->view('admin/appointment-report', $data);
    }

}
