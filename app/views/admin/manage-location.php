<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
$loc_title = (set_value("loc_title")) ? set_value("loc_title") : (!empty($loc_data) ? $loc_data['loc_title'] : '');
$loc_city_id = (set_value("loc_city_id")) ? set_value("loc_city_id") : (!empty($loc_data) ? $loc_data['loc_city_id'] : '');
$loc_status = (set_value("loc_status")) ? set_value("loc_status") : (!empty($loc_data) ? $loc_data['loc_status'] : '');
$id = (set_value("loc_id")) ? set_value("loc_id") : (!empty($loc_data) ? $loc_data['loc_id'] : 0);
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-8 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex">
                                <h3 class="white-text mb-3 font-bold">
                                    <?php echo isset($id) && $id > 0 ? translate('update') : translate('create'); ?> <?php echo translate('location'); ?>
                                </h3>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                    $form_url = 'vendor/save-location';
                                } else {
                                    $form_url = 'admin/save-location';
                                }
                                ?>
                                <?php
                                echo form_open($form_url, array('name' => 'LocationForm', 'id' => 'LocationForm'));
                                echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                                ?>

                                <div class="form-group">
                                    <p class="grey-text"><?php echo translate('select'); ?> <?php echo translate('city'); ?> <small class="required">*</small></p>
                                    <?php
                                    $options[''] = translate('select') . ' ' . translate('city');
                                    if (isset($city_list) && !empty($city_list)) {
                                        foreach ($city_list as $row) {
                                            $options[$row['city_id']] = $row['city_title'];
                                        }
                                    }
                                    $attributes = array('class' => 'kb-select initialized', 'id' => 'loc_city_id', '');
                                    echo form_dropdown('loc_city_id', $options, $loc_city_id, $attributes);
                                    echo form_error('loc_city_id');
                                    ?>
                                </div>

                                <div class="form-group">
                                    <label for="loc_title"> <?php echo translate('title'); ?><small class="required">*</small></label>
                                    <input type="text" id="loc_title" name="loc_title" value="<?php echo $loc_title; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">                                    
                                    <?php echo form_error('loc_title'); ?>
                                </div>

                                <label style="color: #757575;" > <?php echo translate('status'); ?> <small class="required">*</small></label>
                                <div class="form-group form-inline">
                                    <?php
                                    $active = $inactive = '';
                                    if ($loc_status == "I") {
                                        $inactive = "checked";
                                    } else {
                                        $active = "checked";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input name='loc_status' value="A" type='radio' id='active'   <?php echo $active; ?>>
                                        <label for="active"><?php echo translate('active'); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <input name='loc_status' type='radio'  value='I' id='inactive'  <?php echo $inactive; ?>>
                                        <label for='inactive'><?php echo translate('inactive'); ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"><?php echo translate('save'); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!--/Form with header-->
                        </div>
                        <!--Card-->
                    </div>
                    <!-- End Col -->
                </div>
                <!--Row-->
            </section>
            <!-- End Login-->
        </div>
    </div>
</div>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/location.js" type="text/javascript"></script>
<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>