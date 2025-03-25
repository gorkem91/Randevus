<?php
include VIEWPATH . 'admin/header.php';
$is_display_vendor = isset($company_data->is_display_vendor) ? $company_data->is_display_vendor : set_value('is_display_vendor');
$is_display_category = isset($company_data->is_display_category) ? $company_data->is_display_category : set_value('is_display_category');
$is_display_location = isset($company_data->is_display_location) ? $company_data->is_display_location : set_value('is_display_location');
$is_display_searchbar = isset($company_data->is_display_searchbar) ? $company_data->is_display_searchbar : set_value('is_display_searchbar');
$is_display_language = isset($company_data->is_display_language) ? $company_data->is_display_language : set_value('is_display_language');
$display_record_per_page = isset($company_data->display_record_per_page) ? $company_data->display_record_per_page : set_value('is_display_searchbar');
$header_color_code = isset($company_data->header_color_code) ? $company_data->header_color_code : (set_value('header_color_code') != '' ? set_value('header_color_code') : '#4b6499');
$footer_color_code = isset($company_data->footer_color_code) ? $company_data->footer_color_code : (set_value('footer_color_code') != '' ? set_value('footer_color_code') : '#4b6499');
$google_map_key = isset($company_data->google_map_key) ? $company_data->google_map_key : set_value('google_map_key');
$google_location_search_key = isset($company_data->google_location_search_key) ? $company_data->google_location_search_key : set_value('google_location_search_key');
?>
<link href="<?php echo $this->config->item('css_url'); ?>jquery.minicolors.css" rel="stylesheet">
<style>
    .select-wrapper input.select-dropdown {
        color: black;
    }
</style>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex">
                                <h3 class="white-text mb-3 font-bold"><?php echo translate('manage'); ?> <?php echo translate('display'); ?> <?php echo translate('site_setting'); ?></h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php echo form_open('admin/save-display-setting', array('name' => 'site_email_form', 'id' => 'site_email_form')); ?>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('vendor') . ' ' . translate('module') . ' : <small class ="required">*</small>', 'is_display_vendor', array('class' => 'control-label')); ?>
                                        <div class="switch round blue-white-switch">
                                            <label>
                                                No
                                                <input type="checkbox" <?php echo $is_display_vendor == 'Y' ? "checked='checked'" : ""; ?> id="is_display_vendor" name="is_display_vendor" onchange="update_display_setting(this);">
                                                <span class="lever"></span>
                                                Yes
                                            </label>
                                        </div>
                                    </div>
                                        <div class="col-md-6 ">
                                            <!-- Switch -->
                                            <?php echo form_label(translate('enable') . ' ' . translate('category') . ' ' . translate('module') . ' : <small class ="required">*</small>', 'is_display_category', array('class' => 'control-label')); ?>
                                            <div class="switch round blue-white-switch">
                                                <label>
                                                    No
                                                    <input type="checkbox"  <?php echo $is_display_category == 'Y' ? "checked='checked'" : ""; ?> id="is_display_category" name="is_display_category" onchange="update_display_setting(this);">
                                                    <span class="lever"></span>
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <!-- Switch -->
                                            <?php echo form_label(translate('enable') . ' ' . translate('location') . ' ' . translate('module') . ' : <small class ="required">*</small>', 'is_display_location', array('class' => 'control-label')); ?>
                                            <div class="switch round blue-white-switch">
                                                <label>
                                                    No
                                                    <input type="checkbox"  <?php echo $is_display_location == 'Y' ? "checked='checked'" : ""; ?> id="is_display_location" name="is_display_location" onchange="update_display_setting(this);">
                                                    <span class="lever"></span>
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <!-- Switch -->
                                            <?php echo form_label(translate('enable') . ' ' . translate('searching') . ' ' . translate('module') . ' : <small class ="required">*</small>', 'is_display_searchbar', array('class' => 'control-label')); ?>

                                            <div class="switch round blue-white-switch">
                                                <label>
                                                    No
                                                    <input type="checkbox"  <?php echo $is_display_searchbar == 'Y' ? "checked='checked'" : ""; ?> id="is_display_searchbar" name="is_display_searchbar" onchange="update_display_setting(this);">
                                                    <span class="lever"></span>
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <!-- Switch -->
                                            <?php echo form_label(translate('enable') . ' ' . translate('language') . ' ' . translate('module') . ' : <small class ="required">*</small>', 'is_display_language', array('class' => 'control-label')); ?>

                                            <div class="switch round blue-white-switch">
                                                <label>
                                                    No
                                                    <input type="checkbox"  <?php echo $is_display_language == 'Y' ? "checked='checked'" : ""; ?> id="is_display_language" name="is_display_language" onchange="update_display_setting(this);">
                                                    <span class="lever"></span>
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                                <?php echo form_label(translate('display') . ' ' . translate('records') . ' ' . translate('per_page') . ' : <small class ="required">*</small>', 'display_record_per_page', array('class' => 'control-label')); ?>
                                                <?php echo form_input(array('type' => 'number', 'id' => 'display_record_per_page', 'class' => 'form-control', 'name' => 'display_record_per_page', 'value' => $display_record_per_page, 'placeholder' =>translate('display') . ' ' . translate('records') . ' ' . translate('per_page'), 'onblur' => 'update_display_setting(this)')); ?>
                                              
                                        </div>
                                        <div class="col-md-6 ">
                                                <?php echo form_label(translate('header') . ' ' . translate('color') . ' ' . translate('code') . ' : ', 'header_color_code', array('class' => 'control-label')); ?>
                                                <?php echo form_input(array('type' => 'text', 'id' => 'header_color_code', 'class' => 'form-control demo check-color ', 'name' => 'header_color_code', 'value' => $header_color_code, 'placeholder' =>translate('header') . ' ' . translate('color') . ' ' . translate('code'), 'onblur' => 'update_display_setting(this)')); ?>
                                              
                                        </div>
                                        <div class="col-md-6 ">
                                                <?php echo form_label(translate('footer') . ' ' . translate('color') . ' ' . translate('code') . ' : ', 'footer_color_code', array('class' => 'control-label')); ?>
                                                <?php echo form_input(array('type' => 'text', 'id' => 'footer_color_code', 'class' => 'demo check-color form-control', 'name' => 'footer_color_code', 'value' => $footer_color_code, 'placeholder' =>translate('footer') . ' ' . translate('color') . ' ' . translate('code'), 'onblur' => 'update_display_setting(this)')); ?>
                                              
                                        </div>
                                        <div class="col-md-6 ">
                                                <?php echo form_label(translate('google') . ' ' . translate('map') . ' ' . translate('key') . ' : ', 'google_map_key', array('class' => 'control-label')); ?>
                                                <?php echo form_input(array('type' => 'text', 'id' => 'google_map_key', 'class' => 'form-control', 'name' => 'google_map_key', 'value' => $google_map_key, 'placeholder' =>translate('google') . ' ' . translate('map') . ' ' . translate('key'), 'onblur' => 'update_display_setting(this)')); ?>
                                              
                                        </div>
                                        <div class="col-md-6 ">
                                                <?php echo form_label(translate('google') . ' ' . translate('location') . ' ' . translate('search') . ' ' . translate('key').' : ', 'google_location_search_key', array('class' => 'control-label')); ?>
                                                <?php echo form_input(array('type' => 'text', 'id' => 'google_location_search_key', 'class' => 'form-control', 'name' => 'google_location_search_key', 'value' => $google_location_search_key, 'placeholder' =>translate('google') . ' ' . translate('location') . ' ' . translate('search') . ' ' . translate('key'), 'onblur' => 'update_display_setting(this)')); ?>
                                              
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                            <!--/Form with header-->
                        </div>
                        <!--Card-->
                    </div>
                    <!-- End Col -->
            </section>
        </div>
        <!--Row-->
        <!-- End Login-->
    </div>
</div>
<script src="<?php echo $this->config->item('js_url'); ?>jquery.minicolors.js"></script>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/sitesetting.js" type="text/javascript"></script>

<?php include VIEWPATH . 'admin/footer.php'; ?>
