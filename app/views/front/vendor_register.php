<?php include VIEWPATH . 'front/header.php'; ?>
<!-- Start Content -->
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
<div class="content">
    <!-- Start Container -->
    <section class="form-light sm-margin-b-20">
        <!-- Row -->
        <div class="row">
            <div class="col-md-5 m-auto">
                <div class="header pt-3 bg-color-base">
                    <div class="d-flex px-3">
                        <h3 class="white-text mb-3 font-bold w-100 text-center"><?php echo translate('vendor_registration'); ?></h3>
                    </div>
                </div>
                <div class="card sm-mb-30">
                    <div class="card-body mt-4 resp_mx-0">
                        <?php $this->load->view('message'); ?>
                        <?php
                        $attributes = array('id' => 'Register_user', 'name' => 'Register_user', 'method' => "post");
                        echo form_open_multipart('vendor-register-save', $attributes);
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="first_name"> <?php echo translate('first_name'); ?> <small class="required">*</small></label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="<?php echo translate('first_name'); ?>" value="<?php echo set_value('first_name', $this->input->post('first_name')); ?>">                                        
                                    <?php echo form_error('first_name'); ?>
                                </div>
                                <div class="error" id="first_name_validate"></div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="last_name"> <?php echo translate('last_name'); ?><small class="required">*</small></label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="<?php echo translate('last_name'); ?>" value="<?php echo set_value('last_name', $this->input->post('last_name')); ?>">                                        
                                    <?php echo form_error('last_name'); ?>
                                </div>
                                <div class="error" id="last_name_validate"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="email"> <?php echo translate('email'); ?> <small class="required">*</small></label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="<?php echo translate('email'); ?>"  value="<?php echo set_value('email', $this->input->post('email')); ?>">                                        
                                    <?php echo form_error('email'); ?>
                                </div>
                                <div class="error" id="email_validate"></div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="password"> <?php echo translate('password'); ?> <small class="required mr-5px">*</small><i class="fa fa-info-circle" tabindex="0"
                                                                                                                                                   data-html="true" 
                                                                                                                                                   data-toggle="popover" 
                                                                                                                                                   title="<b>Password</b> - Rules" 
                                                                                                                                                   data-content='<span class="d-block"><b> <?php echo translate('info'); ?> - </b></span><span class="d-block">- <?php echo translate('password_length'); ?></span><span class="d-block">- <?php echo translate('password_lowercase'); ?></span><span class="d-block">- <?php echo translate('password_uppercase'); ?></span><span class="d-block">- <?php echo translate('password_numeric'); ?></span>'></i></label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo translate('password'); ?>">                                        
                                    <?php echo form_error('password'); ?>
                                </div>
                                <div class="error" id="password_validate"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="company"> <?php echo translate('company'); ?> <small class="required">*</small></label>
                                    <input type="text" id="company" name="company" class="form-control" placeholder="<?php echo translate('company'); ?>"  value="<?php echo set_value('company', $this->input->post('company')); ?>">                                        
                                    <?php echo form_error('company'); ?>
                                </div>
                                <div class="error" id="company_validate"></div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="website"> <?php echo translate('website'); ?> <small class="required">*</small></label>
                                    <input type="text" id="website" name="website" class="form-control" placeholder="<?php echo translate('website'); ?>"  value="<?php echo set_value('website', $this->input->post('website')); ?>">                                        
                                    <?php echo form_error('website'); ?>
                                </div>
                                <div class="error" id="website_validate"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="phone"> <?php echo translate('phone'); ?> <small class="required">*</small></label>
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="<?php echo translate('phone'); ?>" minlength="10" maxlength="10"  value="<?php echo set_value('phone', $this->input->post('phone')); ?>">                                        
                                    <?php echo form_error('phone'); ?>
                                </div>
                                <div class="error" id="phone_validate"></div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-outline-success waves-effect"> <?php echo translate('register'); ?> </button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!--/Form with header-->
                </div>
                <!--Card-->
            </div>
            <!-- End Col -->
    </section>
</div>

<script src="<?php echo $this->config->item('admin_js_url'); ?>module/vendor_register.js" type="text/javascript"></script>
<?php include VIEWPATH . 'front/footer.php'; ?>