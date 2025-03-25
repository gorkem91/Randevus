<?php include VIEWPATH . 'front/header.php'; ?>
<!-- Custom Script -->
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="mx-4 mt-4 resp_mx-0">
                            <form action="<?php echo site_url('update-booking'); ?>" id="BookForm" method="post">
                                <input type="hidden" id="user_slot_time" name="user_slot_time" value="<?php echo $appointment_data['slot_time']; ?>"/>
                                <input type="hidden" id="event_id" name="event_id" value="<?php echo $appointment_data['event_id']; ?>"/>
                                <input type="hidden" id="appointment_id" name="appointment_id" value="<?php echo $appointment_data['id']; ?>"/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description"><?php echo translate('description'); ?></label>
                                            <textarea type="text" class="form-control" rows="5" placeholder="<?php echo translate('description'); ?>" id="description" name="description" style="height: auto" required><?php echo $appointment_data['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_datetime"><?php echo translate('appointment_date'); ?></label>
                                            <input type="text" class="form-control position-r" placeholder="<?php echo translate('appointment_date'); ?>" id="user_datetime" name="user_datetime" required value="<?php echo isset($update_date) ? $update_date : $appointment_data['start_date'] . " " . date('h:i a', strtotime($appointment_data['start_time'])); ?>" readonly/>
                                            <div>
                                                <a href="<?php echo base_url('day-slots/' . $appointment_data['event_id'] . "/" . $appointment_data['id']); ?>" class="btn btn-success btn-sm waves-effect waves-light" style="position: absolute;top: 33px;right: 20px;">Change</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-outline-success waves-effect" style="margin-top: 25px;">Update</button>
                            </form>
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