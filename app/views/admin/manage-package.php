<?php include VIEWPATH . 'admin/header.php'; 

$title = (set_value("title")) ? set_value("title") : (!empty($package_data) ? $package_data['title'] : '');
$price = (set_value("price")) ? set_value("price") : (!empty($package_data) ? $package_data['price'] : '0');
$max_event    = (set_value("max_event"))    ? set_value("max_event")    : (!empty($package_data) ? $package_data['max_event'] : '0');
$status = (set_value("status")) ? set_value("status") : (!empty($package_data) ? $package_data['status'] : '');

$id = (set_value("id")) ? set_value("id") : (!empty($package_data) ? $package_data['id'] : 0);
?>
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
                                    <?php echo isset($id) && $id > 0 ? translate('update') : translate('create'); ?> <?php echo translate('package'); ?>
                                </h3>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                $form_url = 'admin/save-package';
                                ?>
                                <?php
                                echo form_open_multipart($form_url, array('name' => 'PackageForm', 'id' => 'PackageForm'));
                                echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                                ?>
                                <div class="form-group">
                                    <label for="title"> <?php echo translate('title'); ?><small class="required">*</small></label>
                                    <input type="text" id="title" name="title" value="<?php echo $title; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">                                    
                                    <?php echo form_error('title'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="price"> <?php echo translate('price'); ?> <small class="required">*</small></label>
                                    <input type="number" placeholder="<?php echo translate('price'); ?>" id="price" name="price" min="0" value="<?php echo $price; ?>" class="form-control">                                    
                                    <?php echo form_error('price'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="max_event"> <?php echo translate('event'); ?> <small class="required">*</small></label>
                                    <input type="number" placeholder="<?php echo translate('event'); ?>" id="max_event" name="max_event" min="0" value="<?php echo $max_event; ?>" class="form-control">                                    
                                    <?php echo form_error('max_event'); ?>
                                </div>

                                <label> <?php echo translate('status'); ?> <small class="required">*</small></label>
                                <div class="form-group form-inline">
                                    <?php
                                    $active = $inactive = '';
                                    if ($status == "I") {
                                        $inactive = "checked";
                                    } else {
                                        $active = "checked";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input name='status' value="A" type='radio' id='active'   <?php echo $active; ?>>
                                        <label for="active"><?php echo translate('active'); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <input name='status' type='radio'  value='I' id='inactive'  <?php echo $inactive; ?>>
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
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/package.js" type="text/javascript"></script>
<?php include VIEWPATH . 'admin/footer.php'; ?>