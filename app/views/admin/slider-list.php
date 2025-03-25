<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
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
                                <span style="width: 70%;" class="text-left">
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('manage'); ?> <?php echo translate('slider'); ?></h3>
                                </span>  
                                <span style="width: 30%;padding-right: 20px" class="text-right">
                                    <?php if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') { ?>
                                        <a  href='<?php echo base_url('vendor/add-slider'); ?>' class="btn-floating btn-sm btn-success"><i class="fa fa-plus-circle"></i></a>
                                    <?php } else { ?>
                                        <a  href='<?php echo base_url('admin/add-slider'); ?>' class="btn-floating btn-sm btn-success"><i class="fa fa-plus-circle"></i></a>
                                    <?php } ?>
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
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('image'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('created_date'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($slider_data) && count($slider_data) > 0) {
                                                foreach ($slider_data as $key => $row) {

                                                    if (isset($row['id']) && $row['id'] != NULL) {
                                                        if ($row['status'] == "A") {
                                                            $status_string = '<span class="alert alert-success">' . translate('active') . '</span>';
                                                        } else {
                                                            $status_string = '<span class="alert alert-danger">' . translate('inactive') . '</span>';
                                                        }

                                                        if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                                            $update_url = 'vendor/update-slider/' . $row['id'];
                                                        } else {
                                                            $update_url = 'admin/update-slider/' . $row['id'];
                                                        }

                                                        $image_data = !empty($row) ? $row['image'] : '';
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $key + 1; ?></td>
                                                            <td class="text-center">
                                                                <?php if (isset($image_data) && $image_data != '') { ?>
                                                                    <img class="img"  style="border-radius:2%;" src="<?php echo check_admin_image(UPLOAD_PATH . "slider/" . $image_data); ?>" alt="No Image" width="100" height="100">
                                                                <?php } else { ?>
                                                                    <img class="img"  style="border-radius:2%;" src="<?php echo check_admin_image(img_path . "/no-image.png"); ?>" alt="No Image" width="100" height="100">
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center"><?php echo $status_string; ?></td>
                                                            <td class="text-center"><?php echo date("d-m-Y", strtotime($row['created_on'])); ?></td>
                                                            <td class="td-actions text-center">
                                                                <a href="<?php echo base_url($update_url); ?>" class="btn-danger btn-floating btn-sm blue-gradient" title="<?php echo translate('edit'); ?>"><i class="fa fa-pencil"></i></a>
                                                                <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn-danger btn-floating btn-sm red-gradient" title="<?php echo translate('delete'); ?>"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
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


<script src="<?php echo $this->config->item('admin_js_url'); ?>module/slider.js" type='text/javascript'></script>
<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>