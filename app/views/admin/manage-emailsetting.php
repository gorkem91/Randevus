<?php
include VIEWPATH . 'admin/header.php';
$smtp_host = isset($email_data->smtp_host) ? $email_data->smtp_host : set_value('smtp_host');
$smtp_username = isset($email_data->smtp_username) ? $email_data->smtp_username : set_value('smtp_username');
$smtp_password = isset($email_data->smtp_password) ? $email_data->smtp_password : set_value('smtp_password');
$smtp_port = isset($email_data->smtp_port) ? $email_data->smtp_port : set_value('smtp_port');
$smtp_secure = isset($email_data->smtp_secure) ? $email_data->smtp_secure : set_value('smtp_secure');
$email_from_name = isset($email_data->email_from_name) ? $email_data->email_from_name : set_value('email_from_name');
?>
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
                                <h3 class="white-text mb-3 font-bold"><?php echo translate('manage'); ?> <?php echo translate('smtp'); ?> <?php echo translate('email'); ?></h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php echo form_open('admin/save-email-setting', array('name' => 'site_email_form', 'id' => 'site_email_form')); ?>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php echo form_label(translate('smtp_host') . ' : <small class ="required">*</small>', 'smtp_host', array('class' => 'control-label')); ?>
                                            <?php echo form_input(array('id' => 'smtp_host', 'class' => 'form-control', 'name' => 'smtp_host', 'value' => $smtp_host, 'placeholder' => translate('smtp_host'))); ?>
                                            <?php echo form_error('smtp_host'); ?>
                                        </div>
                                        <div class="error" id="smtp_host_validate"></div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php echo form_label(translate('password') . ' : <small class ="required">*</small>', 'smtp_password', array('class' => 'control-label')); ?>
                                            <?php echo form_password(array('id' => 'smtp_password', 'class' => 'form-control', 'name' => 'smtp_password', 'value' => $smtp_password, 'placeholder' => translate('password'))); ?>
                                            <?php echo form_error('smtp_password'); ?>
                                        </div>
                                        <div class="error" id="smtp_password_validate"></div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php echo form_label(translate('smtp_secure') . ' : <small class ="required">*</small>', 'smtp_secure', array('class' => 'control-label')); ?>
                                            <select name="smtp_secure" id="smtp_secure" class="kb-select">
                                                <option value="tsl" <?php echo isset($smtp_secure) && $smtp_secure == 'tsl' ? "selected" : "" ?>>TSL</option>
                                                <option value="ssl" <?php echo isset($smtp_secure) && $smtp_secure == 'ssl' ? "selected" : "" ?>>SSL</option>
                                            </select>
                                            <?php echo form_error('smtp_secure'); ?>
                                        </div>
                                        <div class="error" id="smtp_secure_validate"></div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php echo form_label(translate('username') . ' : <small class ="required">*</small>', 'smtp_username', array('class' => 'control-label')); ?>
                                            <?php echo form_input(array('id' => 'smtp_username', 'class' => 'form-control', 'name' => 'smtp_username', 'value' => $smtp_username, 'placeholder' => translate('username'))); ?>
                                            <?php echo form_error('smtp_username'); ?>
                                        </div>
                                        <div class="error" id="smtp_username_validate"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php echo form_label(translate('port') . ' : <small class ="required">*</small>', 'smtp_port', array('class' => 'control-label')); ?>
                                            <?php echo form_input(array('id' => 'smtp_port', 'class' => 'form-control', 'type' => 'number', 'name' => 'smtp_port', 'value' => $smtp_port, 'placeholder' => translate('port'))); ?>
                                            <?php echo form_error('smtp_port'); ?>
                                        </div>
                                        <div class="error" id="smtp_port_validate"></div>
                                    </div> 
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php echo form_label(translate('from_name') . ' : <small class ="required">*</small>', 'email_from_name', array('class' => 'control-label')); ?>
                                            <?php echo form_input(array('id' => 'email_from_name', 'class' => 'form-control', 'name' => 'email_from_name', 'value' => $email_from_name, 'placeholder' => translate('from') . ' ' . translate('name'))); ?>
                                            <?php echo form_error('email_from_name'); ?>
                                        </div>
                                        <div class="error" id="email_from_name_validate"></div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 b-r">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"><?php echo translate('update'); ?></button>
                                        </div>
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
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/sitesetting.js" type="text/javascript"></script>
<?php include VIEWPATH . 'admin/footer.php'; ?>
