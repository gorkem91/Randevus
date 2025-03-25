<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Front extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_front');
        $this->lang->load('basic', get_Langauge());
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $this->Per_Page = get_site_setting('display_record_per_page');
    }

    //show home page
    public function index() {
        $location_event = $this->uri->segment(1);
        $location_segment = urldecode($this->uri->segment(2));
        if (isset($location_event) && $location_event == "events") {
            $city_data_res = $this->model_front->getData('app_city', 'city_id', 'city_title="' . $location_segment . '"');
            if (count($city_data_res) > 0) {
                $this->session->set_userdata('location', $location_segment);
                $cookie_value = $this->input->cookie('location', true);
                $up_time = (int) (time() + 86400);
                $down_time = (int) (time() - 3600);
                if (isset($cookie_value) && $cookie_value != "") {
                    $cookied = array(
                        'name' => 'location',
                        'value' => $location_segment,
                        'expire' => $up_time
                    );
                    $this->input->set_cookie($cookied);
                } else {
                    $cookied = array(
                        'name' => 'location',
                        'value' => $location_segment,
                        'expire' => $up_time
                    );
                    $this->input->set_cookie($cookied);
                }
                redirect(base_url());
            } else {
                redirect(base_url());
            }
        }

        $is_search = $this->session->userdata('location');
        if ($is_search != '') {
            $city_Res = $this->model_front->get_row_result(array("city_title" => $is_search), 'app_city');
        }
        /*
         * list of top city
         */
        $city_join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'inner'
            )
        );
        $top_cities = $this->model_front->getData('app_city', 'app_city.*', 'app_event.status="A"', $city_join, 'city_id', 'city_id', '', 12, array(), '', array(), 'DESC');
        /*
         * list of event category
         */
        $events_category = $this->model_front->getData('app_event_category', 'app_event_category.*', 'app_event_category.status="A"');
        /*
         * recent list of booked events
         */
        $join = array(
            array(
                'table' => 'app_event_book',
                'condition' => 'app_event_book.event_id=app_event.id',
                'jointype' => 'inner'
            )
        );
        $book_cond = 'app_event.status="A"';

        $recent_events = $this->model_front->getData("app_event", 'app_event.*', $book_cond, $join, '', 'app_event.id', '', 10);
        $join = array(
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.location',
                'jointype' => 'left'
            ),
        );
        $cond = 'app_event.status="A"';
        if (isset($city_Res) && !empty($city_Res)) {
            $cond .= ' AND city = ' . $city_Res['city_id'];
        }

        $event = $this->model_front->getData("app_event", 'app_event.*,app_event_category.title as category_title,app_city.city_title, app_location.loc_title', $cond, $join, '', 'app_event.id', '', $this->Per_Page, array(), '', array(), '', '', $sort_by = 'N');
        $total_event = $this->model_front->getData("app_event", 'app_event.*,app_event_category.title as category_title,app_city.city_title, app_location.loc_title', $cond, $join, '', 'app_event.id');

        $data['total_Event'] = $total_event;

        $data['title'] = translate('manage') . " " . translate('event');
        $data['topCity_List'] = $top_cities;
        $data['Events_Category'] = $events_category;
        $data['Recent_events'] = $recent_events;
        $this->load->view('front/home', $data);
    }

    public function set_language($lang) {
        $app_language = $this->model_front->getData('app_language', 'id', 'db_field="' . $lang . '"');
        if (count($app_language) > 0) {
            $this->session->set_userdata('language', $lang);
            redirect(base_url());
        } else {
            redirect(base_url());
        }
    }

    //show category page
    public function event_category($category_id) {
        /*
         * list of top city
         */
        $city_join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'inner'
            )
        );
        $top_cities = $this->model_front->getData('app_city', 'app_city.*', 'app_event.status="A"', $city_join, 'city_id', 'city_id', '', 12, array(), '', array(), 'DESC');
        /*
         * recent list of booked events
         */
        $join = array(
            array(
                'table' => 'app_event_book',
                'condition' => 'app_event_book.event_id=app_event.id',
                'jointype' => 'inner'
            )
        );
        $book_cond = 'app_event.status="A"';
        $recent_events = $this->model_front->getData("app_event", 'app_event.*', $book_cond, $join, '', 'app_event.id', '', 10);

        $join = array(
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            )
        );
        $event = $this->model_front->getData("app_event", 'app_event.*,app_event_category.title as category_title,app_city.city_title', "app_event.status='A' AND category_id='$category_id'", $join);
        $data['event_data'] = $event;
        $data['title'] = isset($event) && count($event) > 0 ? $event[0]['category_title'] : translate('event_category');
        $data['topCity_List'] = $top_cities;
        $data['Recent_events'] = $recent_events;
        $this->load->view('front/event_category', $data);
    }

    //event details
    public function event_details() {
        /*
         * list of top city
         */
        $city_join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'inner'
            )
        );
        $top_cities = $this->model_front->getData('app_city', 'app_city.*', 'app_event.status="A"', $city_join, 'city_id', 'city_id', '', 12, array(), '', array(), 'DESC');
        $event_creator_id = (int) $this->uri->segment(2);
        $event_id = (int) $this->uri->segment(3);

        /*
         * recent list of booked events
         */
        $join = array(
            array(
                'table' => 'app_event_book',
                'condition' => 'app_event_book.event_id=app_event.id',
                'jointype' => 'inner'
            )
        );
        $book_cond = 'app_event.status="A"';

        $recent_events = $this->model_front->getData("app_event", 'app_event.*', $book_cond, $join, '', 'app_event.id', '', 10);

        $user_id = $this->session->userdata('CUST_ID');
        $join = array(
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            )
        );
        $event = $this->model_front->getData("app_event", "app_event.*,app_location.loc_title,app_city.city_title,app_event_category.title as category_title", "app_event.id='$event_id'", $join);

        if (isset($event) && count($event) > 0) {
            if (isset($event[0]['created_by']) && $event[0]['created_by'] > 0) {
                $event_book = $this->model_front->getData("app_event_book", "id", "event_id='$event_id'");
                $admin_data = $this->model_front->getData("app_admin", "*", "id=" . $event[0]['created_by']);
                $user_rating = $this->model_front->getData("app_rating", "*", "user_id='$user_id' AND event_id='$event_id'");
                $event_rating = $this->model_front->getData("app_rating", "*", "event_id='$event_id'");
                $avr_rating = $this->model_front->getData("app_rating", "SUM(rating) as rating,COUNT(user_id) as user", "event_id='$event_id'", '', 'event_id');


                $data['event_data'] = $event[0];
                $data['event_book'] = count($event_book);
                $data['user_rating'] = isset($user_rating) && count($user_rating) > 0 ? $user_rating[0] : '';
                $data['event_rating'] = $event_rating;
                $data['admin_data'] = $admin_data[0];
                $data['avr_rating'] = round(isset($avr_rating[0]['rating']) && $avr_rating[0]['rating'] != '' ? $avr_rating[0]['rating'] / $avr_rating[0]['user'] : 0);
                $data['title'] = translate('event_details');
                $data['meta_description'] = isset($event[0]['seo_description']) ? $event[0]['seo_description'] : '';
                $data['meta_keyword'] = isset($event[0]['seo_keyword']) ? $event[0]['seo_keyword'] : '';
                $data['meta_og_img'] = isset($event[0]['seo_og_image']) ? $event[0]['seo_og_image'] : '';
                $data['topCity_List'] = $top_cities;
                $data['Recent_events'] = $recent_events;
                $this->load->view('front/event-details', $data);
            } else {
                $this->session->set_flashdata('msg_class', 'failure');
                $this->session->set_flashdata('msg', translate('invalid_request'));
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect(base_url());
        }
    }

    //show days page
    public function day_slots($id) {
        $event = $this->model_front->getData("app_event", "*", "id='$id'");
        if (!isset($event) || isset($event) && count($event) == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect(base_url());
        }
        $min = $event[0]['slot_time'];
        $allow_day = explode(",", $event[0]['days']);
        $date = date('d-m-Y');
        $next_date = date('d-m-Y', strtotime(date('d-m-Y', strtotime("+1 month"))));
        $month = date("m", strtotime($date));
        $next_month = date("m", strtotime($next_date));
        $month_ch = date("M", strtotime($date));
        $next_month_ch = date("M", strtotime($next_date));
        $year = date("Y", strtotime($date));
        $next_year = date("Y", strtotime($next_date));
        $day = date("d", strtotime($date));
        $next_day = date("d", strtotime($next_date));
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $next_number = cal_days_in_month(CAL_GREGORIAN, $next_month, $next_year);
        $j = 1;
        if ($month == date('m')) {
            $current_day = unixtojd(mktime(0, 0, 0, $month, $day, $year));
            $day_number = cal_from_jd($current_day, CAL_GREGORIAN);
            $day_number = $day_number['day'];
            $j = $number - ($number - $day_number);
        }
        for ($i = $j; $i <= $number; $i++) {
            $jd = gregoriantojd($month, $i, $year);
            $dayOfWeek = jddayofweek($jd, 2);
            if (in_array($dayOfWeek, $allow_day)) {
                $check = $this->_day_slots_check($i . "-" . $month . "-" . $year, $min);
                $day_data[] = array("week" => $dayOfWeek, "month" => $month_ch, "date" => $i, "check" => $check, "full_date" => "$year-$month-$i");
            }
        }
        for ($k = 1; $k <= $number; $k++) {
            $jdk = gregoriantojd($next_month, $k, $next_year);
            $dayOfWeeks = jddayofweek($jdk, 2);
            if (in_array($dayOfWeeks, $allow_day)) {
                $checks = $this->_day_slots_check($k . "-" . $next_month . "-" . $next_year, $min);
                $day_data[] = array("week" => $dayOfWeeks, "month" => $next_month_ch, "date" => $k, "check" => $checks, "full_date" => "$next_year-$next_month-$k");
            }
        }
        //get user details
        $customer_id_sess = (int) $this->session->userdata('CUST_ID');
        $customer = $this->model_front->getData("app_customer", "id,first_name,last_name,email", "id=" . $customer_id_sess);

        $data['event_payment_price'] = number_format($event[0]['price'], 0);
        $data['event_payment_type'] = $event[0]['payment_type'];
        $data['slot_time'] = $event[0]['slot_time'];
        $data['event_title'] = $event[0]['title'];
        $data['event_id'] = $event[0]['id'];
        $data['current_date'] = $date;
        $data['day_data'] = $day_data;
        $data['event_data'] = isset($event[0]) ? $event[0] : array();
        $data['customer_data'] = isset($customer[0]) ? $customer[0] : array();
        $data['title'] = translate('manage') . " " . translate('event');
        $this->load->view('front/days', $data);
    }

    public function time_slots($min, $update = NULL) {
        $customer_id = (int) $this->session->userdata('CUST_ID');
        if ($customer_id == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('protected_message'));
            echo false;
            exit(0);
        }
        $event = $this->model_front->getData("app_event", "*", "slot_time='$min'");
        $slot_time = $event[0]['slot_time'];
        $j = date("h:i a", strtotime("-" . $slot_time . "minute", strtotime($event[0]['end_time'])));
        $datetime1 = new DateTime($event[0]['start_time']);
        $datetime2 = new DateTime($event[0]['end_time']);
        $interval = $datetime1->diff($datetime2);
        $minute = $interval->format('%h') * 60;
        for ($i = 1; $i <= $minute / $slot_time; $i++) {
            if ($i == 1) {
                $time_array[] = date("h:i a", strtotime($event[0]['start_time']));
            } else {
                $time_array[] = date("h:i a", strtotime("+" . $slot_time * ($i - 1) . " minute", strtotime($event[0]['start_time'])));
            }
        }
        if (($key = array_search(date("h:i a", strtotime($event[0]['end_time'])), $time_array)) !== false) {
            unset($time_array[$key]);
        }
        $date = $this->input->post('date');
        if (date('Y-m-d', strtotime($date)) == date("Y-m-d")) {
            $current_time = date("H:i");
            foreach ($time_array as $key => $value) {
                $time_slot = date('H:i', strtotime($value));
                if ($current_time > $time_slot) {
                    if (($key = array_search($value, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                }
            }
        }
        $result = $this->model_front->getData("app_event_book", "start_time,slot_time", "start_date = '$date'");
        if (isset($result) && count($result) > 0) {
            foreach ($result as $key => $value) {
                if ($min == $value['slot_time']) {
                    $time_slot = date('h:i a', strtotime($value['start_time']));
                    if (($key = array_search($time_slot, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                } else {
                    $time_array = $this->_check_slot($time_array, $value['start_time'], $value['slot_time'], $min);
                }
            }
        }
        $result_m = $this->model_front->getData("app_event_book", "start_time", "customer_id='$customer_id' AND start_date = '$date'");
        foreach ($result_m as $key => $value) {
            $time_slot = date('h:i a', strtotime($value['start_time']));
            if (($key = array_search($time_slot, $time_array)) !== false) {
                unset($time_array[$key]);
            }
        }
        $html = '<div class="row">';
        $is_exist_morning = $is_exist_noon = 0;
        foreach ($time_array as $key => $value) {
            $date_check = date("H", strtotime($value));
            $html .= '<div class="col-md-12">';

            if ($is_exist_morning == 0 && $date_check < 12) {
                $html .= '<div class="time-info"> <div>' . translate('morning') . '</div> </div>';
                $is_exist_morning = 1;
            }
            if ($is_exist_noon == 0 && $date_check >= 12) {
                $html .= '<div class="time-info"> <div>' . translate('noon') . '</div> </div>';
                $is_exist_noon = 1;
            }



            $html .= '<div class="col-md-12 mt-2 text-center">
                        <a class="time-button" onclick="confirm_time(this);" id="time-select">' . $value . '</a>';
            if (is_null($update)) {
                $html .= '<a class="time-button w-49 time-respo ml-2 time-confirm hide-confirm" onclick="confirm_form(this);" data-date="' . $date . '"> ' . translate('confirm') . '</a>';
            } else {
                $html .= '<a href="' . base_url('update-appointment/' . $update . "/" . $this->general->encrypt($date . " " . $value)) . '" class="time-button w-49 time-respo ml-2 time-confirm hide-confirm"> ' . translate('confirm') . '</a>';
            }
            $html .= '</div> 
                      </div>';
        }
        $html .= '</div>';
        echo $html;
        exit;
    }

    //add booking for free
    public function booking_free() {
        //Request post data
        $appointment_id = (int) $this->input->post('appointment_id');
        $description = $this->input->post('description');
        $slot_time = $this->input->post('user_slot_time');
        $event_id = $this->input->post('event_id');
        $bookdate = $this->input->post('user_datetime');
        $event_payment_type = $this->input->post('event_payment_type');

        //Check valid event id
        $event_data = $this->model_front->getdata('app_event', '*', "id='$event_id'");
        if (!isset($event_data) || isset($event_data) && count($event_data) == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect(base_url());
        }

        $customer_id = (int) $this->session->userdata('CUST_ID');
        if ($customer_id == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('protected_message'));
            redirect('login');
        }

        $insert['customer_id'] = $customer_id;
        $insert['description'] = $description;
        $insert['slot_time'] = $slot_time;
        $insert['event_id'] = $event_id;
        $insert['start_date'] = date("Y-m-d", strtotime($bookdate));
        $insert['start_time'] = date("H:i:s", strtotime($bookdate));
        $insert['payment_status'] = 'S';
        $insert['status'] = 'P';
        $book = $this->model_front->insert("app_event_book", $insert);

        if (SEND_EMAIL) {
            $customer = $this->model_front->getData("app_customer", "first_name,last_name,email", "id='$customer_id'");
            $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                          Appointment Booking  
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
                                               Hi ' . ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']) . ',
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               Your new appointment booking has been successfully.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
            $html .= '<br><center>';
            $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
            $html .= '<tr>';
            $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
            $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y h:i a", strtotime($bookdate)) . '</th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<th style="border:1px solid #27aa90;">Field</th>';
            $html .= '<th style="border:1px solid #27aa90;">Details</th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td style="border:1px solid #27aa90;">Description</td>';
            $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
            $html .= '</tr> ';
            $html .= '</table>
                    </center>';
            $html .= '</td>
                        </tr>
                    </table>';

            $subject = "Appointment Booking";
            $define_param['to_name'] = ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']);
            $define_param['to_email'] = $customer[0]['email'];
            $send = $this->sendmail->send($define_param, $subject, $html);
            //admin mail
            $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                         New Appointment Booking 
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
                                               Hi Admin,
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               New appointment.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
            $html .= '<br><center>';
            $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
            $html .= '<tr>';
            $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>User Detail</b></div></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td style="border:1px solid #27aa90;">Full Name</td>';
            $html .= '<td style="border:1px solid #27aa90;">' . ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']) . '</td>';
            $html .= '</tr>';
            $html .= '</table>
                    </center>';
            $html .= '<br><center>';
            $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
            $html .= '<tr>';
            $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
            $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y h:i a", strtotime($bookdate)) . '</th>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<th style="border:1px solid #27aa90;">Field</th>';
            $html .= '<th style="border:1px solid #27aa90;">Details</th>';
            $html .= '</tr>';

            $html .= '<tr>';
            $html .= '<td style="border:1px solid #27aa90;">Description</td>';
            $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
            $html .= '</tr> ';
            $html .= '</table>
                    </center>';
            $html .= '</td>
                        </tr>
                    </table>';

            $subject = "Appointment Booking";
            $define_param['to_name'] = "Admin";
            $define_param['to_email'] = ADMIN_EMAIL;
            $send = $this->sendmail->send($define_param, $subject, $html);
        }
        if ($appointment_id > 0) {
            $this->session->set_flashdata('msg', translate('booking_update'));
        } else {
            if ($event_payment_type == 'F') {
                $this->session->set_flashdata('msg', translate('booking_insert'));
            } else if (isset($transaction) && $transaction == true) {
                $this->session->set_flashdata('msg', translate('transaction_success_event') . "<br>" . translate('booking_insert'));
            } else if (isset($on_cash_booking) && $on_cash_booking == true) {
                $this->session->set_flashdata('msg', translate('booking_insert'));
            } else if (isset($transaction) && $transaction == false) {
                $this->session->set_flashdata('msg', translate('transaction_fail') . "<br>" . translate('booking_insert'));
            } else {
                $this->session->set_flashdata('msg', translate('booking_insert'));
            }
        }
        $this->session->set_flashdata('msg_class', 'success');
        redirect('appointment-success/' . $book);
    }

    //add booking by cash method
    public function booking_oncash() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $customer_id = (int) $this->session->userdata('CUST_ID');
        if ($customer_id == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('protected_message'));
            redirect('login');
        }

        $appointment_id = (int) $this->input->post('appointment_id');
        $description = $this->input->post('description');
        $slot_time = $this->input->post('user_slot_time');
        $event_id = $this->input->post('event_id');
        $bookdate = $this->input->post('user_datetime');
        $event_payment_type = $this->input->post('event_payment_type');

        //Check valid event id
        $event_data = $this->model_front->getdata('app_event', '*', "id='$event_id'");
        if (!isset($event_data) || isset($event_data) && count($event_data) == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect(base_url());
        }

        //discount data
        $discount_coupon = $this->input->post('discount_coupon');
        $discount_coupon_id = base64_decode($this->input->post('discount_coupon_id'));
        $final_price = isset($event_data[0]['price']) ? $event_data[0]['price'] : 0;

        if (isset($discount_coupon_id) && $discount_coupon_id > 0 && isset($discount_coupon)) {
            $final_price = get_discount_price($event_id, $discount_coupon, $discount_coupon_id);
        } else {
            $final_price = get_discount_price_by_date($event_id);
        }

        $vendor_amount = get_vendor_amount($final_price, $event_data[0]['created_by']);
        $admin_amount = get_admin_amount($final_price);

        $insert['customer_id'] = $customer_id;
        $insert['description'] = $description;
        $insert['slot_time'] = $slot_time;
        $insert['event_id'] = $event_id;
        $insert['start_date'] = date("Y-m-d", strtotime($bookdate));
        $insert['start_time'] = date("H:i:s", strtotime($bookdate));

        $process_type = $transaction = $on_cash_booking = false;
        if ($event_payment_type == 'F') {
            $insert['payment_status'] = 'S';
            $process_type = true;
        } else if ($event_payment_type == 'P') {
            $process_type = true;
            $on_cash_booking = true;

            $insert['payment_status'] = 'P';
            $insert['price'] = $final_price;
            $insert['vendor_price'] = $vendor_amount;
            $insert['admin_price'] = $admin_amount;
            $insert['status'] = 'P';
            $book = $this->model_front->insert("app_event_book", $insert);

            $data['customer_id'] = $customer_id;
            $data['vendor_id'] = $event_data[0]['created_by'];
            $data['event_id'] = $event_id;
            $data['booking_id'] = $book;
            $data['payment_id'] = '';
            $data['customer_payment_id'] = '';
            $data['transaction_id'] = '';
            $data['payment_price'] = $final_price;
            $data['vendor_price'] = $vendor_amount;
            $data['admin_price'] = $admin_amount;
            $data['failure_code'] = '';
            $data['failure_message'] = '';
            $data['payment_method'] = 'On Cash';
            $data['payment_status'] = 'pending';
            $data['created_on'] = date('Y-m-d H:i:s');

            $this->model_front->insert('app_appointment_payment', $data);
        }

        $up_qry_vendor = $this->db->query("UPDATE app_admin SET my_wallet=my_wallet+" . $vendor_amount . " WHERE id=" . $event_data[0]['created_by']);
        $up_qry_admin = $this->db->query("UPDATE app_admin SET my_wallet=my_wallet+" . $admin_amount . " WHERE id=1");
        if ($process_type == true) {

            $customer = $this->model_front->getData("app_customer", "first_name,last_name,email", "id='$customer_id'");
            if (SEND_EMAIL) {
                $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                          Appointment Booking  
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
                                               Hi ' . ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']) . ',
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               Your new appointment booking has been successfully.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
                $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y h:i a", strtotime($bookdate)) . '</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Field</th>';
                $html .= '<th style="border:1px solid #27aa90;">Details</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Description</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
                $html .= '</tr> ';
                $html .= '</table>
                    </center>';
                $html .= '</td>
                        </tr>
                    </table>';

                $subject = "Appointment Booking";
                $define_param['to_name'] = ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']);
                $define_param['to_email'] = $customer[0]['email'];
                $send = $this->sendmail->send($define_param, $subject, $html);
                //admin mail
                $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                         New Appointment Booking 
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
                                               Hi Admin,
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               New appointment.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>User Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Full Name</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']) . '</td>';
                $html .= '</tr>';
                $html .= '</table>
                    </center>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
                $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y h:i a", strtotime($bookdate)) . '</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Field</th>';
                $html .= '<th style="border:1px solid #27aa90;">Details</th>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Description</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
                $html .= '</tr> ';
                $html .= '</table>
                    </center>';
                $html .= '</td>
                        </tr>
                    </table>';

                $subject = "Appointment Booking";
                $define_param['to_name'] = "Admin";
                $define_param['to_email'] = ADMIN_EMAIL;
                $send = $this->sendmail->send($define_param, $subject, $html);
            }
            if ($appointment_id > 0) {
                $this->session->set_flashdata('msg', translate('booking_update'));
            } else {
                if ($event_payment_type == 'F') {
                    $this->session->set_flashdata('msg', translate('booking_insert'));
                } else if (isset($transaction) && $transaction == true) {
                    $this->session->set_flashdata('msg', translate('transaction_success_event') . "<br>" . translate('booking_insert'));
                } else if (isset($on_cash_booking) && $on_cash_booking == true) {
                    $this->session->set_flashdata('msg', translate('booking_insert'));
                } else if (isset($transaction) && $transaction == false) {
                    $this->session->set_flashdata('msg', translate('transaction_fail') . "<br>" . translate('booking_insert'));
                } else {
                    $this->session->set_flashdata('msg', translate('booking_insert'));
                }
            }
            $this->session->set_flashdata('msg_class', 'success');
            redirect('appointment-success/' . $book);
        }
    }

    //add by stripe method
    public function booking_stripe() {

        //Request post data
        $appointment_id = (int) $this->input->post('appointment_id');
        $description = $this->input->post('description');
        $slot_time = $this->input->post('user_slot_time');
        $event_id = $this->input->post('event_id');
        $bookdate = $this->input->post('user_datetime');
        $event_payment_type = $this->input->post('event_payment_type');

        //Check valid event id
        $event_data = $this->model_front->getdata('app_event', '*', "id='$event_id'");
        if (!isset($event_data) || isset($event_data) && count($event_data) == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect(base_url());
        }

        include APPPATH . 'third_party/init.php';
        $customer_id = (int) $this->session->userdata('CUST_ID');
        if ($customer_id == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('protected_message'));
            redirect('login');
        }

        $insert['customer_id'] = $customer_id;
        $insert['description'] = $description;
        $insert['slot_time'] = $slot_time;
        $insert['event_id'] = $event_id;
        $insert['start_date'] = date("Y-m-d", strtotime($bookdate));
        $insert['start_time'] = date("H:i:s", strtotime($bookdate));


        //discount data
        $discount_coupon = $this->input->post('discount_coupon');
        $discount_coupon_id = base64_decode($this->input->post('discount_coupon_id'));
        $final_price = isset($event_data[0]['price']) ? $event_data[0]['price'] : 0;

        if (isset($discount_coupon_id) && $discount_coupon_id > 0 && isset($discount_coupon)) {
            $final_price = get_discount_price($event_id, $discount_coupon, $discount_coupon_id);
        } else {
            $final_price = get_discount_price_by_date($event_id);
        }

        $process_type = $transaction = $on_cash_booking = false;
        if ($event_payment_type == 'F') {
            $insert['payment_status'] = 'S';
            $process_type = true;
        } else if ($event_payment_type == 'P') {
            $process_type = true;
            if ($this->input->post('stripeToken')) {

                $stripe_api_key = get_StripeSecret();
                \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                $customer_email = $this->db->get_where('app_customer', array('id' => $customer_id))->row()->email;

                $charge = \Stripe\Charge::create(array(
                            "amount" => ceil($final_price * 100),
                            "currency" => "USD",
                            "source" => $_POST['stripeToken'], // obtained with Stripe.js
                            "description" => $this->input->post('purpose')
                ));

                $charge = (array) $charge;
                foreach ($charge as $key => $value) {
                    $get_payment_details[] = $value;
                }
                if ($get_payment_details[1]['paid'] == true) {

                    $vendor_amount = get_vendor_amount($final_price, $event_data[0]['created_by']);
                    $admin_amount = get_admin_amount($final_price);

                    $insert['payment_status'] = 'S';
                    $insert['status'] = 'A';
                    $insert['vendor_price'] = $vendor_amount;
                    $insert['admin_price'] = $admin_amount;

                    $insert['price'] = $final_price;
                    $book = $this->model_front->insert("app_event_book", $insert);

                    $data['customer_id'] = $customer_id;
                    $data['vendor_id'] = $event_data[0]['created_by'];
                    $data['event_id'] = $event_id;
                    $data['booking_id'] = $book;
                    $data['payment_id'] = $get_payment_details[1]['id'];
                    $data['customer_payment_id'] = $_POST['stripeToken'];
                    $data['transaction_id'] = $get_payment_details[1]['balance_transaction'];
                    $data['payment_price'] = $final_price;
                    $data['vendor_price'] = $vendor_amount;
                    $data['admin_price'] = $admin_amount;
                    $data['failure_code'] = $get_payment_details[1]['failure_code'];
                    $data['failure_message'] = $get_payment_details[1]['failure_message'];
                    $data['payment_method'] = 'Stripe';
                    $data['payment_status'] = 'paid';
                    $data['created_on'] = date('Y-m-d H:i:s');

                    $this->model_front->insert('app_appointment_payment', $data);

                    $up_qry_vendor = $this->db->query("UPDATE app_admin SET my_wallet=my_wallet+" . $vendor_amount . " WHERE id=" . $event_data[0]['created_by']);
                    $up_qry_admin = $this->db->query("UPDATE app_admin SET my_wallet=my_wallet+" . $admin_amount . " WHERE id=1");

                    $transaction = true;
                } else {
                    $this->session->set_flashdata('msg', translate('transaction_fail'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect(base_url());
                }
            }
        }
        if ($process_type == true) {
            if (SEND_EMAIL) {
                $customer = $this->model_front->getData("app_customer", "first_name,last_name,email", "id='$customer_id'");
                $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                          Appointment Booking  
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
                                               Hi ' . ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']) . ',
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               Your new appointment booking has been successfully.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
                $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y h:i a", strtotime($bookdate)) . '</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Field</th>';
                $html .= '<th style="border:1px solid #27aa90;">Details</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Description</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
                $html .= '</tr> ';
                $html .= '</table>
                    </center>';
                $html .= '</td>
                        </tr>
                    </table>';

                $subject = "Appointment Booking";
                $define_param['to_name'] = ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']);
                $define_param['to_email'] = $customer[0]['email'];
                $send = $this->sendmail->send($define_param, $subject, $html);
                //admin mail
                $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                         New Appointment Booking 
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
                                               Hi Admin,
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               New appointment.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>User Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Full Name</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']) . '</td>';
                $html .= '</tr>';
                $html .= '</table>
                    </center>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
                $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y h:i a", strtotime($bookdate)) . '</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Field</th>';
                $html .= '<th style="border:1px solid #27aa90;">Details</th>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Description</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
                $html .= '</tr> ';
                $html .= '</table>
                    </center>';
                $html .= '</td>
                        </tr>
                    </table>';

                $subject = "Appointment Booking";
                $define_param['to_name'] = "Admin";
                $define_param['to_email'] = ADMIN_EMAIL;
                $send = $this->sendmail->send($define_param, $subject, $html);
            }
            if ($appointment_id > 0) {
                $this->session->set_flashdata('msg', translate('booking_update'));
            } else {
                if ($event_payment_type == 'F') {
                    $this->session->set_flashdata('msg', translate('booking_insert'));
                } else if (isset($transaction) && $transaction == true) {
                    $this->session->set_flashdata('msg', translate('transaction_success_event') . "<br>" . translate('booking_insert'));
                } else if (isset($on_cash_booking) && $on_cash_booking == true) {
                    $this->session->set_flashdata('msg', translate('booking_insert'));
                } else if (isset($transaction) && $transaction == false) {
                    $this->session->set_flashdata('msg', translate('transaction_fail') . "<br>" . translate('booking_insert'));
                } else {
                    $this->session->set_flashdata('msg', translate('booking_insert'));
                }
            }
            $this->session->set_flashdata('msg_class', 'success');
            redirect('appointment-success/' . $book);
        }
    }

    //add booking by paypal
    public function booking_paypal() {
        $this->load->library('paypal');
        $customer_id = (int) $this->session->userdata('CUST_ID');
        if ($customer_id == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('protected_message'));
            redirect('login');
        }

        $description = $this->input->post('description');
        $slot_time = $this->input->post('user_slot_time');
        $event_id = $this->input->post('event_id');
        $bookdate = $this->input->post('user_datetime');

        //Check valid event id
        $event_data = $this->model_front->getdata('app_event', '*', "id='$event_id'");
        if (!isset($event_data) || isset($event_data) && count($event_data) == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect(base_url());
        }

        //discount data
        $discount_coupon = $this->input->post('discount_coupon');
        $discount_coupon_id = base64_decode($this->input->post('discount_coupon_id'));
        $final_price = isset($event_data[0]['price']) ? $event_data[0]['price'] : 0;

        if (isset($discount_coupon_id) && $discount_coupon_id > 0 && isset($discount_coupon)) {
            $final_price = get_discount_price($event_id, $discount_coupon, $discount_coupon_id);
        } else {
            $final_price = get_discount_price_by_date($event_id);
        }

        $insert['customer_id'] = $customer_id;
        $insert['description'] = $description;
        $insert['slot_time'] = $slot_time;
        $insert['event_id'] = $event_id;
        $insert['start_date'] = date("Y-m-d", strtotime($bookdate));
        $insert['start_time'] = date("H:i:s", strtotime($bookdate));
        $insert['payment_status'] = 'P';
        $insert['created_on'] = date("Y-m-d H:i:s");
        $insert['status'] = 'P';

        $app_event_book = $this->model_front->insert("app_event_book", $insert);

        $this->session->set_userdata('booking_id', $app_event_book);
        $this->session->set_userdata('description', $description);
        $this->session->set_userdata('bookdate', $bookdate);
        $this->session->set_userdata('event_id', $event_id);
        $this->session->set_userdata('event_price', $final_price);


        $this->paypal->add_field('rm', 2);
        $this->paypal->add_field('cmd', '_xclick');
        $this->paypal->add_field('amount', $final_price);
        $this->paypal->add_field('item_name', "Event Booking Payment");
        $this->paypal->add_field('currency_code', "USD");
        $this->paypal->add_field('custom', $app_event_book);
        $this->paypal->add_field('business', get_payment_setting('paypal_merchant_email'));
        //$this->paypal->add_field('notify_url', base_url('paypal_ipn'));
        $this->paypal->add_field('cancel_return', base_url('paypal_cancel'));
        $this->paypal->add_field('return', base_url('paypal_success'));
        $this->paypal->submit_paypal_post();
    }

    public function paypal_success() {

        if (isset($_REQUEST['st']) && $_REQUEST['st'] == "Completed") {

            $booking_id = $this->session->userdata('booking_id');
            $description = $this->session->userdata('description');
            $bookdate = $this->session->userdata('bookdate');
            $event_price = $this->session->userdata('event_price');
            $event_id = $this->session->userdata('event_id');

            $customer_id = (int) $this->session->userdata('CUST_ID');
            $event_data = $this->model_front->getdata('app_event', '*', "id='$event_id'");


            $vendor_amount = get_vendor_amount($event_price, $event_data[0]['created_by']);
            $admin_amount = get_admin_amount($event_price);


            $data['customer_id'] = $customer_id;
            $data['vendor_id'] = $event_data[0]['created_by'];
            $data['event_id'] = $event_id;
            $data['booking_id'] = $booking_id;
            $data['vendor_price'] = $vendor_amount;
            $data['admin_price'] = $admin_amount;
            $data['payment_id'] = $_REQUEST['tx'];
            $data['customer_payment_id'] = $_REQUEST['tx'];
            $data['transaction_id'] = $_REQUEST['tx'];
            $data['payment_price'] = $event_price;
            $data['failure_code'] = '';
            $data['failure_message'] = '';
            $data['payment_method'] = 'PayPal';
            $data['payment_status'] = 'paid';
            $data['created_on'] = date('Y-m-d H:i:s');

            $appointment_id = $this->model_front->insert('app_appointment_payment', $data);
            $customer = $this->model_front->getData("app_customer", "first_name,last_name,email", "id='$customer_id'");

            //update app_event_book
            $app_event_book['status'] = 'A';
            $app_event_book['vendor_price'] = $vendor_amount;
            $app_event_book['admin_price'] = $admin_amount;
            $app_event_book['price'] = $event_price;

            $app_event_book['payment_status'] = 'S';
            $this->model_front->update('app_event_book', $app_event_book, "id=" . $booking_id);

            $up_qry_vendor = $this->db->query("UPDATE app_admin SET my_wallet=my_wallet+" . $vendor_amount . " WHERE id=" . $event_data[0]['created_by']);
            $up_qry_admin = $this->db->query("UPDATE app_admin SET my_wallet=my_wallet+" . $admin_amount . " WHERE id=1");


            if (SEND_EMAIL) {
                $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                          Appointment Booking  
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
                                               Hi ' . ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']) . ',
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               Your new appointment booking has been successfully.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
                $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y h:i a", strtotime($bookdate)) . '</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Field</th>';
                $html .= '<th style="border:1px solid #27aa90;">Details</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Description</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
                $html .= '</tr> ';
                $html .= '</table>
                    </center>';
                $html .= '</td>
                        </tr>
                    </table>';

                $subject = "Appointment Booking";
                $define_param['to_name'] = ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']);
                $define_param['to_email'] = $customer[0]['email'];
                $send = $this->sendmail->send($define_param, $subject, $html);


                //Send Notification to respective Vendor for booking
                $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                         New Appointment Booking 
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
                                               Hi Admin,
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               New appointment.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>User Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Full Name</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . ucfirst($customer[0]['first_name']) . " " . ucfirst($customer[0]['last_name']) . '</td>';
                $html .= '</tr>';
                $html .= '</table>
                    </center>';
                $html .= '<br><center>';
                $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
                $html .= '<th style="border:1px solid #27aa90;">' . date("d-m-Y h:i a", strtotime($bookdate)) . '</th>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td colspan="2"><div style="padding-left:30px;" align="center"><b>Appointment Detail</b></div></td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<th style="border:1px solid #27aa90;">Field</th>';
                $html .= '<th style="border:1px solid #27aa90;">Details</th>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<td style="border:1px solid #27aa90;">Description</td>';
                $html .= '<td style="border:1px solid #27aa90;">' . $description . '</td>';
                $html .= '</tr> ';
                $html .= '</table>
                    </center>';
                $html .= '</td>
                        </tr>
                    </table>';

                $subject = "Appointment Booking";
                $define_param['to_name'] = "Admin";
                $define_param['to_email'] = ADMIN_EMAIL;
                $send = $this->sendmail->send($define_param, $subject, $html);
            }
            //unset session
            $this->session->unset_userdata('booking_id');
            $this->session->unset_userdata('description');
            $this->session->unset_userdata('bookdate');
            $this->session->unset_userdata('event_price');
            $this->session->unset_userdata('event_id');


            $this->session->set_flashdata('msg', translate('transaction_success_event') . "<br>" . translate('booking_insert'));
            $this->session->set_flashdata('msg_class', 'success');
            redirect('appointment-success/' . $booking_id);
        } else {
            $booking_id = $this->session->userdata('booking_id');
            $this->db->where("id", $booking_id);
            $this->db->delete("app_event_book");

            $this->session->unset_userdata('booking_id');
            $this->session->unset_userdata('description');
            $this->session->unset_userdata('bookdate');
            $this->session->unset_userdata('event_price');
            $this->session->unset_userdata('event_id');

            $this->session->set_flashdata('msg', translate('transaction_fail'));
            $this->session->set_flashdata('msg_class', 'failure');
            redirect(base_url());
        }
    }

    public function paypal_cancel() {
        //remove booked event due to unseccesfull payment
        $booking_id = $this->session->userdata('booking_id');
        $this->db->where("id", $booking_id);
        $this->db->delete("app_event_book");

        //unset session value
        $this->session->unset_userdata('booking_id');
        $this->session->unset_userdata('description');
        $this->session->unset_userdata('bookdate');
        $this->session->unset_userdata('event_id');

        $this->session->set_flashdata('msg', translate('transaction_fail'));
        $this->session->set_flashdata('msg_class', 'failure');
        redirect(base_url());
    }

    //appointment list
    public function appointment() {
        $this->authenticate->check();
        $customer_id = (int) $this->session->userdata('CUST_ID');
        $join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_event.id=app_event_book.event_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_customer',
                'condition' => 'app_customer.id=app_event_book.customer_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_admin',
                'condition' => 'app_admin.id=app_event.created_by',
                'jointype' => 'left'
            )
        );
        $appointment = $this->model_front->getData("app_event_book", "app_event_book.*,app_event_book.price as final_price,app_admin.company_name,app_event.title,app_location.loc_title,app_city.city_title,app_event_category.title as category_title,app_customer.first_name,app_customer.last_name,app_customer.phone,app_event.price,app_admin.first_name,app_admin.last_name,app_admin.company_name,app_event.image,app_event.description as event_description, app_event.payment_type", "app_event_book.customer_id='$customer_id'", $join);
        $data['appointment_data'] = $appointment;
        $data['title'] = translate('appointment');
        $this->load->view('front/appointment', $data);
    }

    //delete appointment
    public function delete_appointment() {
        $id = (int) $this->uri->segment(2);
        $services = $this->model_front->getData("app_event_book", "start_date,start_time", "id='$id'");
        $bookdate = date("d-m-Y", strtotime($services[0]['start_date'])) . " " . date("h:i a", strtotime($services[0]['start_time']));
        $this->model_front->delete("app_event_book", "id='$id'");
        $html = '<table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td>
                                <table cellspacing = "0" cellpadding = "0" style = "width: 100%;">
                                    <tr>
                                        <td style="font-size:32px; padding: 10px 25px; color: #595959; text-align:center;" class = "mobile-spacing">
                                         Appointment Notification 
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
                                               Hi Admin,
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style = "text-align:left; color: #6f6f6f; font-size: 18px;">
                                               Delete appointment.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
        $html .= '<br><center>';
        $html .= '<table style="border:1px solid black;width:90%;"  cellspacing=2 cellpadding=4 class="force-full-width value">';
        $html .= '<tr>';
        $html .= '<th style="border:1px solid #27aa90;">Appointment Date</th>';
        $html .= '<th style="border:1px solid #27aa90;">' . $bookdate . '</th>';
        $html .= '</tr>';
        $html .= '</table>
                    </center>';
        $html .= '</td>
                        </tr>
                    </table>';

        $subject = "Appointment Notification";
        $define_param['to_name'] = "Admin";
        $define_param['to_email'] = ADMIN_EMAIL;
        $send = $this->sendmail->send($define_param, $subject, $html);
        $this->session->set_flashdata('msg', translate('appointment_delete'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    //update appointment
    public function update_appointment($id, $date = NULL) {
        $event = $this->model_front->getData("app_event_book", "*", "id='$id'");
        if (isset($event) && count($event) > 0) {
            if (!is_null($date)) {
                $data['update_date'] = $this->general->decrypt($date);
            }
            $data['appointment_data'] = $event[0];
            $data['title'] = translate('manage') . " " . translate('appointment');
            $this->load->view('front/manage-appointment', $data);
        } else {
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect(base_url());
        }
    }

    //check days available or not
    private function _day_slots_check($k, $min) {
        $event = $this->model_front->getData("app_event", "*", "status='A' AND slot_time='$min'");
        $monthly_allow = $event[0]['monthly_allow'];
        $slot_time = $event[0]['slot_time'];
        $j = date("h:i a", strtotime("-" . $slot_time . "minute", strtotime($event[0]['end_time'])));
        $datetime1 = new DateTime($event[0]['start_time']);
        $datetime2 = new DateTime($event[0]['end_time']);
        $interval = $datetime1->diff($datetime2);
        $minute = $interval->format('%h') * 60;
        for ($i = 1; $i <= $minute / $slot_time; $i++) {
            if ($i == 1) {
                $time_array[] = date("h:i a", strtotime($event[0]['start_time']));
            } else {
                $time_array[] = date("h:i a", strtotime("+" . $slot_time * ($i - 1) . " minute", strtotime($event[0]['start_time'])));
            }
        }
        if (($key = array_search(date("h:i a", strtotime($event[0]['end_time'])), $time_array)) !== false) {
            unset($time_array[$key]);
        }
        $start_date = date("Y-m-d", strtotime($k));
        if ($start_date == date("Y-m-d")) {
            foreach ($time_array as $key => $value) {
                if (date('H:i:s') > date('H:i:s', strtotime($value))) {
                    if (($key = array_search($value, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                }
            }
        }
        $customer_id = (int) $this->session->userdata('CUST_ID');
        $book_month = date('m', strtotime($start_date));
        $book = $this->model_front->getData("app_event_book", "start_time", "customer_id='$customer_id' AND MONTH(start_date) = '$book_month' AND slot_time='$min'");
        if (isset($book) && count($book) >= $monthly_allow) {
            return '0';
        }
        $result = $this->model_front->getData("app_event_book", "start_time,slot_time", "start_date = '$start_date'");
        if (isset($result) && count($result) > 0) {
            foreach ($result as $key => $value) {
                if ($min == $value['slot_time']) {
                    $time_slot = date('h:i a', strtotime($value['start_time']));
                    if (($key = array_search($time_slot, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                } else {
                    $time_array = $this->_check_slot($time_array, $value['start_time'], $value['slot_time'], $min);
                }
            }
            if (isset($time_array) && count($time_array) > 0) {
                return '1';
            }
            return '0';
        }
        return '1';
    }

    private function _check_slot($time_array, $start_time, $slot_time, $current_slot_time) {
        if ($slot_time > $current_slot_time) {
            $min_time = date('h:i a', strtotime($start_time));
            $max_time = date("h:i a", strtotime("+" . $slot_time . " minute", strtotime($start_time)));
            foreach ($time_array as $key => $value) {
                if ($min_time <= $value && $max_time > $value) {
                    if (($key = array_search($value, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                }
            }
        } else if ($slot_time < $current_slot_time) {
            $min_time = date('h:i a', strtotime($start_time));
            $max_time = date("h:i a", strtotime("+" . $slot_time . " minute", strtotime($start_time)));
            foreach ($time_array as $key => $value) {
                $current_end_time = date("h:i a", strtotime("+" . $current_slot_time . " minute", strtotime($value)));
                if ($value <= $min_time && $current_end_time > $min_time) {
                    if (($key = array_search($value, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                }
            }
        }
        return $time_array;
    }

    public function submit_rating($event_id) {
        $user_id = $this->session->userdata('CUST_ID');
        $rating = $this->input->post('rating');
        $review = $this->input->post('review');
        $check_rating = $this->model_front->getData('app_rating', 'id', "user_id='$user_id' AND event_id='$event_id'");
        if (isset($check_rating) && count($check_rating) == 0) {
            $data = array(
                'user_id' => $user_id,
                'event_id' => $event_id,
                'rating' => $rating,
                'review' => $review
            );
            $id = $this->model_front->insert('app_rating', $data);
        }
        echo 'true';
        exit;
    }

    public function profile_details() {
        $admin_id = (int) $this->uri->segment(2);
        $data['title'] = translate('manage') . " " . translate('profile');

        $admin_data = $this->model_front->getData("app_admin", "*", "id='$admin_id'");
        $data['admin_data'] = $admin_data[0];
        $join = array(
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.location',
                'jointype' => 'left'
            )
        );
        $event_data = $this->model_front->getData("app_event", "app_event.*,app_event_category.title as category_title,app_city.city_title,app_location.loc_title", "app_event.status='A' AND app_event.created_by='$admin_id'", $join);
        /*
         * list of top city
         */
        $city_join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'inner'
            )
        );
        $top_cities = $this->model_front->getData('app_city', 'app_city.*', 'app_event.status="A"', $city_join, 'city_id', 'city_id', '', 12, array(), '', array(), 'DESC');

        /*
         * recent list of booked events
         */
        $join = array(
            array(
                'table' => 'app_event_book',
                'condition' => 'app_event_book.event_id=app_event.id',
                'jointype' => 'inner'
            )
        );
        $book_cond = 'app_event.status="A"';

        $recent_events = $this->model_front->getData("app_event", 'app_event.*', $book_cond, $join, '', 'app_event.id', '', 10);

        $data['Recent_events'] = $recent_events;
        $data['topCity_List'] = $top_cities;
        $data['event_data'] = $event_data;
        $this->load->view('front/profile-details', $data);
    }

    public function message($id = NULL) {
        $customer_id = (int) $this->session->userdata('CUST_ID');
        $data['vendor_list'] = $this->model_front->message_vendor_list($customer_id);
        if (is_null($id)) {
            $id = isset($data['vendor_list'][0]['id']) ? $data['vendor_list'][0]['id'] : 0;
        }
        $check_chat = $this->model_front->getData('app_chat_master', 'id', "vendor_id='$id' AND customer_id='$customer_id'");
        if (isset($check_chat) && count($check_chat) == 0) {
            $insert_master = array(
                'customer_id' => $customer_id,
                'vendor_id' => $id,
                'created_on' => date('Y-m-d H:i:s')
            );
            $this->model_front->insert('app_chat_master', $insert_master);
        }
        $data['vendor_list'] = $this->model_front->message_vendor_list($customer_id);
        $this->model_front->update('app_chat', array('msg_read' => 'Y'), "to_id='$customer_id' AND from_id='$id' AND chat_type='NC'");
        $data['msg_vendor_data'] = $this->model_front->msg_vendor_data($id);
        $data['msg_group_list'] = $this->model_front->msg_group_list($id, $customer_id);
        $data['title'] = translate('message');
        $this->load->view('front/message', $data);
    }

    public function message_action() {
        $from_id = (int) $this->session->userdata('CUST_ID');
        $to_id = (int) $this->input->post('msg_to_id');
        $message = $this->input->post('message');
        $chat_id = (int) $this->model_front->get_chat_id($to_id, $from_id);
        if (isset($chat_id) && $chat_id > 0) {
            $inser_data = array(
                'chat_id' => $chat_id,
                'to_id' => $to_id,
                'from_id' => $from_id,
                'message' => $message,
                'chat_type' => 'C',
                'created_on' => date('Y-m-d H:i:s')
            );
            $this->model_front->insert('app_chat', $inser_data);
        }
        redirect('message/' . $to_id);
    }

    //show home page
    public function payment_history() {
        $join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_event.id=app_event_book.event_id',
                'jointype' => 'inner'
            ),
            array(
                'table' => 'app_appointment_payment',
                'condition' => 'app_appointment_payment.event_id=app_event_book.event_id',
                'jointype' => 'inner'
            )
        );
        $CUST_ID = (int) $this->session->userdata('CUST_ID');
        $payment_history = $this->model_front->getData("app_event_book", 'app_event.*,app_appointment_payment.payment_method as Payment_method, app_appointment_payment.payment_status as Payment_status,app_appointment_payment.created_on as payment_date', "app_event.status='A' AND app_appointment_payment.customer_id=" . $CUST_ID, $join,"","app_appointment_payment.id");
        $data['payment_history'] = $payment_history;
        $data['title'] = translate('manage') . " " . translate('payment_history');
        $this->load->view('front/payment_history', $data);
    }

    public function update_booking() {
        $appointment_id = (int) $this->input->post('appointment_id');
        $description = $this->input->post('description');
        $bookdate = $this->input->post('user_datetime');
        $insert['description'] = $description;
        $insert['start_date'] = date("Y-m-d", strtotime($bookdate));
        $insert['start_time'] = date("H:i:s", strtotime($bookdate));
        if ($appointment_id > 0) {
            $book = $this->model_front->update("app_event_book", $insert, "id='$appointment_id'");
        }
        $this->session->set_flashdata('msg', translate('booking_update'));
        $this->session->set_flashdata('msg_class', 'success');
        redirect('appointment');
    }

    function get_appointment_details($id) {
        $join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_event.id=app_event_book.event_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            )
        );
        $event = $this->model_front->getData("app_event_book", "app_event_book.*,app_event.title,app_location.loc_title,app_city.city_title,app_event_category.title as category_title", "app_event_book.id='$id'", $join);
        $html = '';
        if (isset($event) && count($event) > 0) {
            $html .= ' <table class="table mdl-data-table">
                    <tr>
                        <th>' . translate('title') . '</th>
                       <td>' . $event[0]['title'] . '</td>
                    </tr>
                    <tr>
                      <th>' . translate('category') . '</th>
                       <td>' . $event[0]['category_title'] . '</td>
                    </tr>
                    <tr>
                         <th>' . translate('city') . '</th>
                       <td>' . $event[0]['city_title'] . '</td>
                    </tr>
                    <tr>
                        <th>' . translate('location') . '</th>
                       <td>' . $event[0]['loc_title'] . '</td>
                    </tr>
                    <tr>
                         <th>' . translate('description') . '</th>
                       <td>' . $event[0]['description'] . '</td>
                    </tr>
                </table>';
        }
        echo $html;
        exit;
    }

    function appointment_success($id) {
        $from_id = (int) $this->session->userdata('CUST_ID');
        $join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_event.id=app_event_book.event_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            )
        );
        $event = $this->model_front->getData("app_event_book", "app_event_book.*,app_event.title,app_location.loc_title,app_city.city_title,app_event_category.title as category_title", "app_event_book.id='$id' AND app_event_book.customer_id=" . $from_id, $join);

        if (count($event) > 0) {
            $data['invoice_path'] = $this->GeneratePDF("E", $id);
            $this->model_front->update('app_event_book', array('invoice_file' => $data['invoice_path']), "id='$id'");
            $data['event_data'] = $event[0];
            $data['title'] = translate('appointment') . " " . translate('success');
            $this->load->view('front/appointment-success', $data);
        } else {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect(base_url());
        }
    }

    public function GeneratePDF($flag, $id) {
        $join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_event.id=app_event_book.event_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_customer',
                'condition' => 'app_customer.id=app_event_book.customer_id',
                'jointype' => 'left'
            )
        );
        $event = $this->model_front->getData("app_event_book", "app_event_book.*,app_event.title,app_location.loc_title,app_city.city_title,app_event_category.title as category_title,app_customer.first_name,app_customer.last_name,app_customer.phone,app_event.price", "app_event_book.id='$id'", $join);
        include APPPATH . 'third_party/fpdf/fpdfnew.php';

        //create a FPDF object
        $pdf = new PDF();
        $j = 0;
        global $conn;

        $pdf->AliasNbPages();
        $pdf->AddPage();


        $pdf->SetXY(10, 20);
        $pdf->Write(10, "M/s. : " . ucfirst($event[0]['first_name']) . " " . ucfirst($event[0]['last_name']));

        $pdf->SetXY(10, 25);
        $pdf->Write(10, 'Phone : ' . $event[0]['phone']);

        $pdf->SetXY(140, 20);
        $pdf->Write(10, "Invoice No. : AP/" . str_pad($id, 3, 0, STR_PAD_LEFT));

        $pdf->SetXY(140, 25);
        $pdf->Write(10, "Appointment : " . date('d-m-Y h:i a', strtotime($event[0]['start_date'] . " " . $event[0]['start_time'])));


        $pdf->SetDrawColor(188, 188, 188);
        $pdf->Line(10, 45, 200, 45);

        $pdf->SetXY(10, 50);
        $pdf->Write(10, 'Appointment Details');

        $pdf->SetXY(10, 60);
        $pdf->Cell(25, 10, 'Title', 1, 0, 'C');

        $pdf->SetXY(35, 60);
        $pdf->Cell(165, 10, $event[0]['title'], 1, 0, 'L');

        $pdf->SetXY(10, 70);
        $pdf->Cell(25, 10, 'Category', 1, 0, 'C');

        $pdf->SetXY(35, 70);
        $pdf->Cell(165, 10, $event[0]['category_title'], 1, 0, 'L');

        $pdf->SetXY(10, 80);
        $pdf->Cell(25, 10, 'Solt Time', 1, 0, 'C');

        $pdf->SetXY(35, 80);
        $pdf->Cell(165, 10, $event[0]['slot_time'] . " Minutes", 1, 0, 'L');

        $pdf->SetXY(10, 90);
        $pdf->Cell(25, 10, 'City', 1, 0, 'C');

        $pdf->SetXY(35, 90);
        $pdf->Cell(165, 10, $event[0]['city_title'], 1, 0, 'L');

        $pdf->SetXY(10, 100);
        $pdf->Cell(25, 10, 'Location', 1, 0, 'C');

        $pdf->SetXY(35, 100);
        $pdf->Cell(165, 10, $event[0]['loc_title'], 1, 0, 'L');

        $pdf->SetXY(10, 110);
        $pdf->Cell(25, 10, 'Price', 1, 0, 'C');

        $pdf->SetXY(35, 110);
        $vendor_price = isset($event[0]['vendor_price']) ? $event[0]['vendor_price'] : 0;
        $admin_price = isset($event[0]['admin_price']) ? $event[0]['admin_price'] : 0;
        $final_price = ($vendor_price + $admin_price);
        $pdf->Cell(165, 10, price_format($final_price), 1, 0, 'L');

        if ($flag == "E") {
            $filename = 'invoice_' . $id . '.pdf';
            $pdf->Output(UPLOAD_PATH . "invoice/" . $filename, 'F');
            chmod(UPLOAD_PATH . "invoice/" . $filename, 0777);
            return $filename;
        } else {
            $pdf->Output('invoice_' . $id . '.pdf', $flag);
        }
    }

    public function category_details($category_id = NULL) {
        if ($category_id == NULL) {
            $category_id = $this->uri->segment(2);
        }

        $search_txt = $this->input->get('search_as');
        $search_city = $this->input->cookie('location', true);
        $city_Res = "";

        if ($search_city != '') {
            $city_Res = $this->model_front->get_row_result(array("city_title" => $this->input->cookie('location', true)), 'app_city');
            $location_Res = $this->model_front->getData("app_location", "app_location.*", "loc_status = 'A' AND loc_city_id=" . $city_Res['city_id']);
        }

        $city_join = array(
            array(
                'table' => 'app_event',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'inner'
            )
        );
        /*
         * recent list of booked events
         */
        $join = array(
            array(
                'table' => 'app_event_book',
                'condition' => 'app_event_book.event_id=app_event.id',
                'jointype' => 'inner'
            )
        );
        $book_cond = 'app_event.status="A"';
        $recent_events = $this->model_front->getData("app_event", 'app_event.*', $book_cond, $join, '', 'app_event.id', '', 10);

        $top_cities = $this->model_front->getData('app_city', 'app_city.*', 'app_event.status="A"', $city_join, 'city_id', 'city_id', '', 12, array(), '', array(), 'DESC');

        $join = array(
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.location',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_admin',
                'condition' => 'app_admin.id=app_event.created_by',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_event_book',
                'condition' => 'app_event_book.event_id=app_event.id',
                'jointype' => 'left'
            ),
        );
        $cond = 'app_event.status="A"';
        if (isset($category_id) && $category_id != NULL && $category_id > 0) {
            $cond .= ' AND category_id=' . $category_id;
        }
        if (isset($city_Res) && !empty($city_Res)) {
            $cond .= ' AND city = ' . $city_Res['city_id'];
        }
        if ($search_txt != '') {
            $cond .= ' AND (app_event.title LIKE "' . $search_txt . '%" OR app_event_category.title LIKE "' . $search_txt . '%" OR app_city.city_title LIKE "' . $search_txt . '%" OR app_location.loc_title LIKE "' . $search_txt . '%" OR app_admin.company_name LIKE "' . $search_txt . '%")';
        }

        $event = $this->model_front->getData("app_event", 'app_event.*,app_event_category.title as category_title,app_city.city_title, app_location.loc_title', $cond, $join, '', 'app_event.id', '', $this->Per_Page, array(), '', array(), '', '', $sort_by = 'P');
        $total_event = $this->model_front->getData("app_event", 'app_event.*,app_event_category.title as category_title,app_city.city_title, app_location.loc_title', $cond, $join, '', 'app_event.id');
        $data['event_data'] = $event;
        if (isset($city_Res) && !empty($city_Res)) {
            $events_category = $this->model_front->getData('app_event_category', 'app_event_category.*,(SELECT COUNT(app_event.id) FROM app_event WHERE  app_event.category_id = app_event_category.id AND app_event.city = ' . $city_Res['city_id'] . ' AND app_event.status = "A") as total_booking', 'app_event_category.status="A" AND (SELECT COUNT(app_event.id) FROM app_event WHERE app_event.category_id = app_event_category.id AND app_event.city = 1 AND app_event.status = "A") > 0');
        } else {
            $events_category = $this->model_front->getData('app_event_category', 'app_event_category.*,(SELECT COUNT(app_event.id) FROM app_event WHERE  app_event.category_id = app_event_category.id AND app_event.status = "A") as total_booking', 'app_event_category.status="A" AND (SELECT COUNT(app_event.id) FROM app_event WHERE app_event.category_id = app_event_category.id AND app_event.city = 1 AND app_event.status = "A") > 0');
        }
        $data['title'] = "Category Details";
        $data['total_Event'] = $total_event;
        $data['topCity_List'] = $top_cities;
        $data['Location_List'] = isset($location_Res) ? $location_Res : array();
        $data['Recent_events'] = $recent_events;
        $data['Events_Category'] = $events_category;
        $this->load->view('front/category-details', $data);
    }

    public function locations() {

        $search_txt = $this->input->post('search_txt');
        $city_Res = $this->model_front->getData("app_city", 'app_city.*', "city_status='A' AND city_title LIKE '" . $search_txt . "%'", array());
        if (isset($city_Res) && !empty($city_Res)) {
            echo json_encode(array("status" => "success", "data" => $city_Res));
            exit(0);
        } else {
            echo json_encode(array("status" => "failure"));
            exit(0);
        }
    }

    public function search_events() {

        $search_txt = $this->input->post('search_txt');
        $events = $this->model_front->getData("app_event", 'app_event.*', "app_event.status='A' AND title LIKE '" . $search_txt . "%'", array());
        if (isset($events) && !empty($events)) {
            echo json_encode(array("status" => "success", "data" => $events));
            exit(0);
        } else {
            echo json_encode(array("status" => "failure"));
            exit(0);
        }
    }

    public function locations_events() {
        $locations = $this->input->post('locations');
        $is_search = $this->input->cookie('location', true);
        if ($locations != '') {
            $locations = implode(",", $this->input->post('locations'));
        }
        $category_id = $this->input->post('category_id');
        $search_txt = $this->input->post('search_txt');
        $row = $this->input->post('row');
        $sort_by = $this->input->post('sort_by');

        $join = array(
            array(
                'table' => 'app_event_category',
                'condition' => 'app_event_category.id=app_event.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_event.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_event.location',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_admin',
                'condition' => 'app_admin.id=app_event.created_by',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_event_book',
                'condition' => 'app_event_book.event_id=app_event.id',
                'jointype' => 'left'
            ),
        );

        $cond = 'app_event.status="A"';
        if (get_site_setting('is_display_location') == 'Y') {
            $cond .= ' AND app_city.city_title="' . $is_search . '"';
        }

        if (isset($category_id) && $category_id != NULL && $category_id > 0) {
            $cond .= ' AND category_id=' . $category_id;
        }
        if ($search_txt != '') {
            $cond .= ' AND (app_event.title LIKE "' . $search_txt . '%" OR app_event_category.title LIKE "' . $search_txt . '%" OR app_city.city_title LIKE "' . $search_txt . '%" OR app_location.loc_title LIKE "' . $search_txt . '%" OR app_admin.company_name LIKE "' . $search_txt . '%")';
        }
        if (isset($locations) && !empty($locations)) {
            $cond .= ' AND location  IN (' . $locations . ')';
        }
        $events = $this->model_front->getData("app_event", '(SELECT COUNT(id) FROM app_event_book WHERE event_id = app_event.id) as totalBook, app_event.*,app_event_category.title as category_title,app_city.city_title, app_location.loc_title, app_admin.profile_image, app_admin.company_name', $cond, $join, '', 'app_event.id', '', '', array(), '', array(), '', $row, $sort_by);

        $total_Event = $this->model_front->getData("app_event", 'app_event.*,app_event_category.title as category_title,app_city.city_title, app_location.loc_title, app_admin.profile_image, app_admin.company_name', $cond, $join, '', 'app_event.id', '', '', array(), '', array(), '');
        if (isset($events) && !empty($events)) {
            echo json_encode(array("status" => "success", "data" => $events, "total_Event" => count($total_Event)));
            exit(0);
        } else {
            echo json_encode(array("status" => "failure"));
            exit(0);
        }
    }

    public function discount_coupon() {
        $event_id = $this->input->post('event_id');
        $discount_coupon = $this->input->post('discount_coupon');
        $coupon = $this->model_front->getData("app_coupon", "*", "code='$discount_coupon' AND status='A'");
        $app_event = $this->model_front->getData("app_event", "*", "id=" . $event_id . " AND status='A'");

        if (count($app_event) > 0) {
            $app_event_data = $app_event[0];

            if (count($coupon) > 0) {
                $coupon_signle_data = $coupon[0];
                $valid_till = $coupon_signle_data['valid_till'];
                $event_id_array = $coupon_signle_data['event_id'];
                $discount_type = $coupon_signle_data['discount_type'];
                $discount_value = $coupon_signle_data['discount_value'];

                //get event price details
                $event_price = 0;
                $discountDate = date('Y-m-d');
                if (isset($app_event_data['discounted_price']) && $app_event_data['discounted_price'] > 0 && ($discountDate >= $app_event_data['from_date']) && ($discountDate <= $app_event_data['to_date'])) {
                    $event_price = $app_event_data['discounted_price'];
                } else {
                    $event_price = $app_event_data['price'];
                }

                $final_price = $event_price;
                //Apply coupon disocunt on event price
                if ($discount_type == 'P') {
                    $final_price = ($final_price - ($final_price * ($discount_value / 100)));
                } else {
                    $final_price = $final_price - $discount_value;
                }

                $event_id_ary = json_decode($event_id_array);

                if ($valid_till >= date('Y-m-d')) {

                    if (in_array($event_id, $event_id_ary)) {
                        $html = "";
                        echo json_encode(array("status" => true, 'id' => base64_encode($coupon_signle_data['id']), 'price' => $final_price, "message" => translate('coupon_code_apply')));
                        exit(0);
                    } else {
                        echo json_encode(array("status" => false, "message" => translate('coupon_code_not_associated_event')));
                        exit(0);
                    }
                } else {
                    echo json_encode(array("status" => false, "message" => translate('coupon_code_expired')));
                    exit(0);
                }
            } else {
                echo json_encode(array("status" => false, "message" => translate('invalid_coupon_code')));
                exit(0);
            }
        } else {
            echo json_encode(array("status" => false, "message" => translate('invalid_request')));
            exit(0);
        }
    }

}

?>