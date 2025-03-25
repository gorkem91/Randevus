<?php include VIEWPATH . 'admin/header.php'; ?>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid ">
            <section class="form-light px-2 sm-margin-b-20">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header bg-color-base">
                            <div class="d-flex">
                                <span>
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('manage'); ?> <?php echo translate('vendor'); ?></h3>
                                </span>  
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mdl-data-table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-center font-bold dark-grey-text">#</th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('name'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('company_name'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('email'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('website'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('phone'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            if (isset($vendor_data) && count($vendor_data) > 0) {
                                                foreach ($vendor_data as $row) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $i; ?></td>
                                                        <td class="text-center"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                        <td class="text-center"><?php echo $row['company_name']; ?></td>
                                                        <td class="text-center"><?php echo $row['email']; ?></td>
                                                        <td class="text-center"><?php echo $row['website']; ?></td>
                                                        <td class="text-center"><?php echo $row['phone']; ?></td>
                                                        <td class="text-center"><?php echo print_vendor_status($row['status']); ?></td>
                                                        <td class="td-actions text-center">
                                                            <a id="" data-toggle="modal" onclick='ChangeStatus(this)' data-target="#change-status" data-id="<?php echo (int) $row['id']; ?>" class="btn-danger btn-floating btn-sm blue-gradient" title="<?php echo translate('change_status'); ?>"><i class="fa fa-eye"></i></a>
                                                            <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn-danger btn-floating btn-sm red-gradient" title="Customer"><i class="fa fa-close"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--col-md-12-->
                </div>
                <!--Row-->
            </section>
        </div>
    </div>   
</div>
<!-- Modal -->
<div class="modal fade" id="delete-record">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="DeleteRecordForm" name="DeleteRecordForm" method="post">
                <input type="hidden" id="record_id"/>
                <div class="modal-header">
                    <h4 id='some_name' class="modal-title" style="font-size: 18px;"></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id='confirm_msg' style="font-size: 15px;"></p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo translate('close'); ?></button>
                    <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" id="RecordDelete" ><?php echo translate('confirm'); ?></a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Status Modal -->
<div class="modal fade" id="change-status">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="StausForm" name="StausForm" method="post">
                <input type="hidden" id="CustomerIDVal"/>
                <div class="modal-header">
                    <h4 id='CustomerTitle' class="modal-title" style="font-size: 18px;"></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="get_status" id="get_status" class="form-control" required style="display: block !important;">
                            <option value=""><?php echo translate('change_status'); ?></option>
                            <option value="A"><?php echo translate('active'); ?></option>
                            <option value="I"><?php echo translate('inactive'); ?></option>
                            <option value="P"><?php echo translate('pending'); ?></option>
                            <option value="D"><?php echo translate('deleted'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn blue-gradient btn-rounded pull-left" type="button"><?php echo translate('close'); ?></button>
                    <a class="btn purple-gradient btn-rounded" href="javascript:void(0)" id="CustomerChange" ><?php echo translate('confirm'); ?></a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/vendor.js" type='text/javascript'></script>
<?php include VIEWPATH . 'admin/footer.php'; ?>