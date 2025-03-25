<?php
//print_r();exit;
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
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
                                    <h3 class="white-text font-bold pt-3"><?php echo translate('translate') . " " . ucfirst($language_data['title']) . " " . translate('words'); ?></h3>
                                </span>  
                                <span style="width: 30%;padding-right: 20px" class="text-right">
                                    <a  href='<?php echo base_url('admin/manage-language'); ?>' class="btn-floating btn-sm btn-success"><i class="fa fa-backward"></i></a>
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
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('title'); ?></th>
                                                <th class="text-center font-bold dark-grey-text"><?php echo translate('translated_word'); ?></th>
                                                <th width="350" class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($words) && count($words) > 0) {

                                                foreach ($words as $key => $row) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $key + 1; ?></td>
                                                        <td class="text-left"><?php echo ucfirst($row['english']); ?></td>
                                                        <td class="text-left"><input id="db_field_<?php echo $row['id']; ?>" value="<?php echo isset($row[$language_data['db_field']]) ? $row[$language_data['db_field']] : ""; ?>" name="translated_word[]" class="form-control"/></td>
                                                        <td class="td-actions text-center" w>
                                                            <a href="javascript:void(0)" data-id="<?php echo trim($row['id']); ?>" data-field="<?php echo trim($language_data['db_field']); ?>" class="btn btn-primary btn-sm" onclick="save_translated_lang(this)" title="<?php echo translate('translate_word'); ?>"><i class="fa fa-save"></i> <?php echo translate('save'); ?></a>
                                                        </td>
                                                    </tr>
                                                    <?php
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
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/language.js" type='text/javascript'></script>
<?php
include VIEWPATH . 'admin/footer.php';
?>