<?php include VIEWPATH . 'front/header.php'; ?>
<?php
$first_name = (set_value("first_name")) ? set_value("first_name") : $customer_data['first_name'];
$last_name = (set_value("last_name")) ? set_value("last_name") : $customer_data['last_name'];
$email = (set_value("email")) ? set_value("email") : $customer_data['email'];
$phone = (set_value("phone")) ? set_value("phone") : $customer_data['phone'];
$profile_image = set_value("profile_image") ? set_value("profile_image") : $customer_data['profile_image'];
?>
<!-- Custom Script -->
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="mb-5">
        <!-- Start Container -->
        <div class="container">
            <h3 class="text-center mt-20"><?php echo translate('profile'); ?></h3>
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="mx-4 mt-4 resp_mx-0">
                            <?php
                            $attributes = array('id' => 'Profile', 'name' => 'Profile', 'method' => "post");
                            echo form_open_multipart('profile-save', $attributes);
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name"> <?php echo translate('first_name'); ?> <small class="required">*</small></label>
                                        <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" class="form-control" placeholder="<?php echo translate('first_name'); ?>">                                            
                                        <?php echo form_error('firstname'); ?>

                                    </div>
                                    <div class="error" id="first_name_validate"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Lastname"> <?php echo translate('last_name'); ?> <small class="required">*</small></label>
                                        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" class="form-control" placeholder="<?php echo translate('last_name'); ?>">                                            
                                        <?php echo form_error('last_name'); ?>
                                    </div>
                                    <div class="error" id="last_name_validate"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Email"> <?php echo translate('email'); ?> <small class="required">*</small></label>
                                        <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="form-control" placeholder="<?php echo translate('email'); ?>">                                            
                                        <?php echo form_error('email'); ?>

                                    </div>
                                    <div class="error" id="email_validate"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone"> <?php echo translate('phone'); ?> <small class="required">*</small></label>
                                        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" class="form-control integers" placeholder="<?php echo translate('phone'); ?>" maxlength="10" minlength="10">                                            
                                        <?php echo form_error('phone'); ?>
                                    </div>
                                    <div class="error" id="Phone_validate"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 style="font-size: .8rem; color: #757575; margin-bottom: 2.5rem;"><?php echo translate('select'); ?> <?php echo translate('image'); ?></h5>
                                    <div class="file-field">
                                        <div class="btn btn-primary btn-sm">
                                            <span><?php echo translate('choose_file'); ?></span>
                                            <input onchange="readURL(this)" id="imageurl"  type="file" name="profile_image"/>
                                        </div>
                                        <div class="file-path-wrapper" style="padding-top: 4px;">
                                            <input class="file-path validate form-control readonly" readonly type="text" placeholder="<?php echo translate('upload_your_file'); ?>" >
                                        </div>
                                        <?php echo form_error('profile_image'); ?>
                                    </div>
                                    <div class="error" id="profile_image_validate"></div>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    if (file_exists(FCPATH . uploads_path . "/profiles/" . $customer_data['profile_image']) && $customer_data['profile_image'] != '') {
                                        $img_src = base_url() . uploads_path . "/profiles/" . $customer_data['profile_image'];
                                    } else {
                                        $img_src = base_url() . img_path . "/user.png";
                                    }
                                    ?> 
                                    <h5 style="font-size: .8rem; color: #757575"> <?php echo translate('profile_image'); ?> </h5>
                                    <img id="imageurl"  class="img-thumbnail img-fluid p-8p"  style="border-radius:50%;" src="<?php echo $img_src; ?>" alt="<?php echo translate('profile'); ?> <?php echo translate('image'); ?>" width="100" height="100">
                                </div>
                            </div>
                            <div class="form-group ">
                                <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;"><?php echo translate('update'); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                        <!--/Form with header-->
                    </div>
                    <!-- End Col -->
                </div>
                <!--Row-->
            </section>
            <!-- End Login-->
        </div>
    </div>
</div>
<!-- Custom Script -->
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/content.js" type="text/javascript"></script>
<?php include VIEWPATH . 'front/footer.php'; ?>