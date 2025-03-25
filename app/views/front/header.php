<?php
$url_segment = $this->uri->segment(1);
$location_segment = $this->uri->segment(2);
if ($url_segment == 'appointment') {
    $appointment_active = 'active';
} else if ($url_segment == 'register') {
    $register_active = 'active';
} else if ($url_segment == 'vendor-register') {
    $vendor_register_active = 'active';
} else if ($url_segment == 'message') {
    $message_active = 'active';
} else if ($url_segment == 'profile' || $url_segment == 'change-password' || $url_segment == 'payment-history') {
    $profile_drop_active = 'active';
    if ($url_segment == 'profile') {
        $profile_active = 'active';
    } else if ($url_segment == 'payment-history') {
        $payment_active = 'active';
    } else {
        $password_active = 'active';
    }
} else {
    $home_active = 'active';
}
$select_City = "";
$select_City = $this->input->cookie('location', true);
$language_data = get_languages();
$Total_Event_Count = isset($total_Event) && is_array($total_Event) ? count($total_Event) : 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <?php
        if ($url_segment = "event-details") {
            if (isset($meta_description) && $meta_description != '') {
                ?>
                <meta name="description" content="<?php echo $meta_description; ?>"/>
                <?php
            }
            if (isset($meta_keyword) && $meta_keyword != '') {
                ?>
                <meta name="keywords" content="<?php echo $meta_keyword; ?>"/>
                <?php
            }
            if (isset($meta_og_img) && $meta_og_img != '') {
                ?>
                <meta name="og:image" content="<?php echo check_admin_image(UPLOAD_PATH . "event/seo_image/" . $meta_og_img); ?>"/>
                <?php
            }
        }
        ?>
        <link rel="icon" type="image/x-icon" href="<?php echo get_fevicon(); ?>"/>
        <title><?php
            echo ucfirst(get_CompanyName());
            if (!empty($title))
                echo " | " . $title;
            ?></title>
        <link href="<?php echo $this->config->item('css_url'); ?>font-awesome.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>bootstrap.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>bookmyslot.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>admin_panel.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>custom.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>homepage.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_url'); ?>datatables.min.css" rel="stylesheet"/>
        <script src="<?php echo $this->config->item('js_url'); ?>jquery-3.2.1.min.js"></script>

        <script src="<?php echo $this->config->item('js_url'); ?>popper.min.js"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>bootstrap.min.js"></script>

        <script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->config->item('js_url'); ?>datatables.min.js"></script>
        <script src="<?php echo $this->config->item('js_url'); ?>jquery.validate.min.js" type="text/javascript"></script>
        <script>
            var base_url = '<?php echo base_url() ?>';
            var display_record_per_page = '<?php echo get_site_setting('display_record_per_page'); ?>';
            var csrf_token_name = '<?php echo $this->security->get_csrf_hash(); ?>';
        </script>
        <!--loader-->
        <link href="<?php echo $this->config->item('assets_url'); ?>loader/css/preloader.css" rel="stylesheet">
        <script src="<?php echo $this->config->item('assets_url'); ?>loader/js/jquery.preloader.min.js"></script>
        <link href="<?php echo $this->config->item('js_url'); ?>ckeditor/prism.css" rel="stylesheet"/>
        <script src="<?php echo $this->config->item('js_url'); ?>ckeditor/prism.js"></script>
    </head>
    <body>
        <div id="loadingmessage" class="loadingmessage"></div>
        <div id="paymentloadingmessage" class="paymentloadingmessage"><h3> Please do not refresh the page and wait while we are processing your payment.<br>This can take a few minutes.</h3></div>

        <?php if ($url_segment != 'vendor-register' && $url_segment != 'register' && (get_site_setting('is_display_location') == 'Y' || get_site_setting('is_display_language') == 'Y')) { ?>
            <div class="topbar">
                <div class="container">
                    <div class="row mb-0">
                        <?php if (get_site_setting('is_display_location') == 'Y') { ?>
                            <div class="col-md-4 pt-1 mb-0">
                                <div class="texticon-group">
                                    <div class="texticon-group-icon">
                                        <i class="fa fa-map-marker"></i>  
                                        <span class="font-sm txt-tertiary"><?php echo translate('select_location'); ?></span>
                                    </div>
                                    <div class="location_input" data-toggle="modal" data-target="#locationPopup">
                                        <p>
                                            <span class="font-sm txt-primary city-name"><?php echo isset($select_City) && $select_City != '' ? ucfirst($select_City) : translate('city'); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        if (get_site_setting('is_display_language') == 'Y') {
                            ?>
                            <div class="col-md-4 my-0 ml-auto">
                                <div class="row">
                                    <div class="col-md-6 px-md-0 pt-1">
                                        <div class="texticon-group text-right">
                                            <div class="texticon-group-icon d-md-inline-block">
                                                <span class="txt-tertiary text-bold"><?php echo translate('select_language'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 pl-md-0 my-2">
                                        <?php
                                        $language_sesstion = $this->session->userdata('language');
                                        $language_text = translate('select') . " " . translate('language');
                                        if (isset($language_sesstion) && $language_sesstion != "" && $language_sesstion != NULL) {
                                            $language_title_data = get_single_row("app_language", "title", "db_field='" . $language_sesstion . "'");
                                            $language_text = ucfirst($language_title_data['title']);
                                        } else {
                                            $language = get_site_setting('language');
                                            $language_title_data = get_single_row("app_language", "title", "db_field='" . $language . "'");
                                            $language_text = ucfirst($language_title_data['title']);
                                        }
                                        ?>
                                        <div class="language_dropdown dropdown">
                                            <button class="btn white"><?php echo $language_text; ?></button>
                                            <div class="dropdown-content">
                                                <?php
                                                if (isset($language_data) && !empty($language_data)) {

                                                    foreach ($language_data as $row) {
                                                        ?>
                                                        <a href="<?php echo base_url('set_language/' . $row['db_field']); ?>"><?php echo ucfirst($row['title']); ?></a>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!--Header-->
        <?php $header_color_code = get_site_setting('header_color_code'); ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color : <?php echo $header_color_code != '' && $header_color_code != NULL ? $header_color_code : '#4b6499' ?>!important">
            <div class="container">

                <?php if (get_site_setting('is_display_location') == 'Y') { ?>
                    <a class="navbar-brand" href="<?php echo base_url(isset($select_City) && $select_City != '' ? 'events/' . $select_City : ''); ?>">
                        <img src="<?php echo check_admin_image(UPLOAD_PATH . "sitesetting/" . get_CompanyLogo()); ?>" class="img-fluid resp_h-35 h-39" alt="">
                    </a> 
                <?php } else { ?>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>">
                        <img src="<?php echo check_admin_image(UPLOAD_PATH . "sitesetting/" . get_CompanyLogo()); ?>" class="img-fluid resp_h-35 h-39" alt="">
                    </a> 
                <?php } ?>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto sidbar_ulnav top_navbar">
                        <li class="nav-item">
                            <a href="<?php echo base_url(isset($select_City) && $select_City != '' ? 'events/' . $select_City : '') ?>" class="nav-link <?php echo isset($home_active) ? $home_active : ''; ?>">
                                <?php echo translate('home'); ?>
                            </a>
                        </li>
                        <?php
                        if ($this->session->userdata('CUST_ID') || $this->session->userdata('Vendor_ID')) {
                            if ($this->session->userdata('Vendor_ID')) {
                                ?>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('vendor/dashboard') ?>" class="nav-link">
                                        <?php echo translate('dashboard'); ?>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('appointment') ?>" class="nav-link <?php echo isset($appointment_active) ? $appointment_active : ''; ?>">
                                        <?php echo translate('appointment'); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('message') ?>" class="nav-link <?php echo isset($message_active) ? $message_active : ''; ?>">
                                        <?php echo translate('message'); ?>
                                    </a>
                                </li>
                                <li class="nav-item dropdown px-0">
                                    <a class="nav-link dropdown-toggle border-0 <?php echo isset($profile_drop_active) ? $profile_drop_active : ""; ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php $login_customer = get_CustomerDetails(); ?>
                                        <img src="<?php echo check_admin_image(UPLOAD_PATH . "profiles/" . $login_customer['profile_image']); ?>" class="img-fluid hw_40" alt="user profile"/>
                                        <?php echo ucfirst($login_customer['first_name']) . " " . $login_customer['last_name']; ?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li> <a class="dropdown-item <?php echo isset($profile_active) ? $profile_active : ""; ?>" href="<?php echo base_url('profile'); ?>"><?php echo translate('profile'); ?></a></li>
                                        <li> <a class="dropdown-item <?php echo isset($password_active) ? $password_active : ""; ?>" href="<?php echo base_url('change-password'); ?>"><?php echo translate('Change_password'); ?></a></li>
                                        <li> <a class="dropdown-item <?php echo isset($payment_active) ? $payment_active : ""; ?>" href="<?php echo base_url('payment-history'); ?>"><?php echo translate('payment_history'); ?></a></li>
                                        <li> <a class="dropdown-item" href="<?php echo base_url('logout') ?>"><?php echo translate('logout'); ?></a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('login') ?>" class="nav-link">
                                    <?php echo translate('login'); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('register') ?>" class="nav-link <?php echo isset($register_active) ? $register_active : ''; ?>">
                                    <?php echo translate('register'); ?>
                                </a>
                            </li>
                            <?php if (get_site_setting('is_display_vendor') == "Y") { ?>
                                <li class="nav-item dropdown px-0">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <?php echo translate('vendor'); ?>                                  </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li> <a class="dropdown-item" href="<?php echo base_url('vendor/login') ?>"> <?php echo translate('login'); ?></a></li>
                                        <li><a class="dropdown-item <?php echo isset($vendor_register_active) ? $vendor_register_active : ''; ?>" href="<?php echo base_url('vendor-register') ?>"><?php echo translate('register'); ?></a></li>
                                    </ul>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>             
                </div>
            </div>
        </nav>        
        <!--End Header-->

        <?php if ($url_segment != 'vendor-register' && $url_segment != 'register') { ?>
            <!--Search Box-->

        <?php } ?>

        <!--End Search Box-->


        <!--Search box modal-->
        <div class="modal fade" id="searchPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg top_modal" role="document">
                <div class="modal-content">
                    <div class="container">
                        <div class="search_box_modal">
                            <div class="modal-header border-0">
                                <?php if (get_site_setting('is_display_location') == 'Y') { ?>
                                    <button class="btn open_location" data-toggle="modal" data-target="#locationPopup">
                                        <i class="fa fa-map-marker"></i>
                                        <?php echo translate('change_location') ?>: <span class="current-location"><?php echo isset($select_City) && $select_City != '' ? $select_City : ''; ?></span>
                                    </button>
                                <?php } ?>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="search_input">
                                    <form class="form-horizontal" method="get" action="<?php echo base_url('category-details/' . $location_segment) ?>">
                                        <div class="form-group">
                                            <i class="fa fa-search"></i>
                                            <input class="form-control" value="<?php echo isset($_GET['search_as']) ? $_GET['search_as'] : ""; ?>" autofocus="" name="search_as" id="search_as" type="search" placeholder="Search restaurants, spa, events, things to do...">
                                        </div>
                                        <div class="hero-search-button">
                                            <button class="btn btn-primary" type="submit"><?php echo translate('search') ?></button>
                                        </div>
                                    </form>
                                </div>

                                <div class="recom_searches">
                                    <div class="recom_info">
                                        <i class="fa fa-thumbs-up"></i>
                                        <span><?php echo translate('recommanded_searches'); ?></span>
                                    </div>
                                    <div class="search-tags margin-top-l">
                                        <?php
                                        if (isset($Recent_events) && !empty($Recent_events)) {
                                            foreach ($Recent_events as $row) {
                                                ?>
                                                <a href="<?php echo base_url('event-details/' . $row['created_by'] . '/' . $row['id']); ?>" class="badge badge-pill white"><?php echo $row['title']; ?></a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer justify-content-between border-0">
                                <div class="search__footer mt-4 mb-2">
                                    <img alt="logo" class="img-responsive" height="auto" src="<?php echo base_url() . img_path; ?>/logo.png" width="170">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Search box modal-->

        <!--Location Popup-->
        <div class="location_popup">
            <!-- Modal -->
            <div class="modal fade" id="locationPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg top_modal" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close location_close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="search loaders">
                                <!--Loader-->

                                <!--End Loader-->
                                <div class="container text-center">
                                    <br>
                                    <h5 class="h4 mt-4 mb-2 popup_header"><?php echo translate('pick_city'); ?></h5>
                                    <p class="grey-text mb-4"><?php echo translate('finds_awesome_events'); ?></p>

                                    <div class="searchbox mb-4">
                                        <form class="" method="post">
                                            <div class="row">
                                                <div class="col-md-8 m-auto">
                                                    <div class="search_box">
                                                        <div class="form-group">
                                                            <i class="fa fa-map-marker"></i>
                                                            <input autocomplete="off" id="search" class="form-control" name="search" placeholder="<?php echo translate('enter_your_city'); ?>" type="search" value="">
                                                        </div>
                                                    </div>
                                                    <div class="searchbox_suggestion_wrapper d-none">
                                                        <ul class="searchbox_suggestion">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!--template bindings={}--> 


                                    <p class="top_cities"><?php echo translate('top_cities'); ?></p>
                                    <div class="city_names">
                                        <?php
                                        if (isset($topCity_List) && !empty($topCity_List)) {
                                            foreach ($topCity_List as $crow) {
                                                ?>
                                                <a href="<?php echo base_url('events/' . $crow['city_title']); ?>" class="badge badge-pill white"><?php echo $crow['city_title']; ?></a>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>

                                    <div class="mt-4 mb-2">
                                        <img alt="logo" class="img-responsive" height="auto" src="<?php echo base_url() . img_path; ?>/logo.png" width="170">
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
        <!--End Location Popup-->