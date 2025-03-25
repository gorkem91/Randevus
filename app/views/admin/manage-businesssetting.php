<?php
include VIEWPATH . 'admin/header.php';
$commission_percentage = isset($business_data->commission_percentage) ? $business_data->commission_percentage : set_value('commission_percentage');
$minimum_vendor_payout = isset($business_data->minimum_vendor_payout) ? $business_data->minimum_vendor_payout : set_value('minimum_vendor_payout');
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
                                <h3 class="white-text mb-3 font-bold"><?php echo translate('manage'); ?> <?php echo translate('business'); ?> <?php echo translate('setting'); ?></h3>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php echo form_open('admin/save-business-setting', array('name' => 'site_business_form', 'id' => 'site_business_form')); ?>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php echo form_label(translate('comission') . ' '.translate('in').' '.translate('percentage').' : <small class ="required">*</small>', 'commission_percentage', array('class' => 'control-label')); ?>
                                             <?php echo form_input(array('id' => 'commission_percentage', 'class' => 'form-control integers', 'name' => 'commission_percentage', 'value' => $commission_percentage, 'placeholder' => translate('comission') . ' '.translate('in').' '.translate('percentage'))); ?>
                                            <?php echo form_error('commission_percentage'); ?>
                                        </div>
                                        <div class="error" id="commission_percentage"></div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <?php echo form_label(translate('minimum') . ' '.translate('vendor').' '.translate('payout').' : <small class ="required">*</small>', 'minimum_vendor_payout', array('class' => 'control-label')); ?>
                                            <?php echo form_input(array('id' => 'minimum_vendor_payout', 'class' => 'form-control integers', 'name' => 'minimum_vendor_payout', 'value' => $minimum_vendor_payout, 'placeholder' => translate('minimum') . ' '.translate('vendor').' '.translate('payout'))); ?>
                                            <?php echo form_error('minimum_vendor_payout'); ?>
                                        </div>
                                        <div class="error" id="minimum_vendor_payout"></div>
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
