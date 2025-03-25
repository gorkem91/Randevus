<?php include VIEWPATH . 'front/header.php'; ?>
<div class="dashboard-body">
    <!-- Start Content -->
        <!-- Start Container -->
        <div class="container">
            <h3 class="text-center mt-20"><?php echo translate('Change_password'); ?></h3>
            <!--Section-->
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <!-- Col -->
                    <div class="col-md-8 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="alert alert-info alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class="d-block"><b> <?php echo translate('info'); ?> - </b></span>
                            <span class="d-block">- <?php echo translate('password_length'); ?></span>
                            <span class="d-block">- <?php echo translate('password_lowercase'); ?></span>
                            <span class="d-block">- <?php echo translate('password_uppercase'); ?></span>
                            <span class="d-block">- <?php echo translate('password_numeric'); ?></span>
                        </div>
                        <!--Form with header-->
                        <?php
                        $hidden = array("ID" => $ID);
                        $attributes = array('id' => 'Update_password', 'name' => 'Update_password', 'method' => "post");
                        echo form_open('update-password-action', $attributes);
                        ?>
                        <div class="form-group">
                            <label for="old_password"> <?php echo translate('current'); ?> <?php echo translate('password'); ?> <small class="required">*</small></label>
                            <input type="password" id="old_password" name="old_password" class="form-control" placeholder="<?php echo translate('current'); ?> <?php echo translate('password'); ?>">                                    
                            <?php echo form_error('old_password'); ?>
                        </div>
                        <div class="form-group">
                            <label for="password"> <?php echo translate('password'); ?> <small class="required">*</small></label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo translate('password'); ?>">                                    
                            <?php echo form_error('password'); ?>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password"> <?php echo translate('confirm_password'); ?> <small class="required">*</small></label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="<?php echo translate('confirm_password'); ?>">                                    
                            <?php echo form_error('confirm_password'); ?>
                        </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"><?php echo translate('update'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                        <!--/Form with header-->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </section>
            <!-- End Section-->
        </div>
</div>
<!-- Custom Script --><script src="<?php echo $this->config->item('admin_js_url'); ?>module/content.js" type="text/javascript"></script>
<?php include VIEWPATH . 'front/footer.php'; ?>
