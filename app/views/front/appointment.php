<?php include VIEWPATH . 'front/header.php';
?>
<style>
    p span.alert {
        padding: 5px 12px;
        border-radius: 30px;
        font-weight: 600;
    }
</style>
<div class="dashboard-body">
    <!-- Start Content -->
    <!-- Start Container -->
    <div class="container mb-5">
        <h3 class="text-center mt-20"><?php echo translate('appointment'); ?></h3>
        <section class="form-light px-2 sm-margin-b-20">
            <div class="product_archive card">
                <div class="row">
                    <div class="col-md-12 single_product_wrapper">
                        <?php
                        if (isset($appointment_data) && count($appointment_data) > 0) {
                            foreach ($appointment_data as $key => $row) {
                                ?>
                                <div class="single_product">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="product__description">
                                                <?php
                                                if (isset($row['image']) && $row['image'] != '') {
                                                    $imageArr = json_decode($row['image']);
                                                }
                                                ?>
                                                <img src="<?php echo check_admin_image(isset($imageArr[0]) && $imageArr[0] != '' ? UPLOAD_PATH . "event/$imageArr[0]" : ''); ?>" alt="Purchase image" class="img-fluid">
                                                <div class="short_desc">
                                                    <h4><?php echo $row['title']; ?></h4>
                                                    <p><?php echo $row['event_description']; ?></p>
                                                </div>
                                            </div>
                                            <!-- end /.product__description -->
                                        </div>
                                        <!-- end /.col-md-5 -->

                                        <div class="col-lg-3 col-md-3 xs-fullwidth">
                                            <div class="product__additional_info">
                                                <ul class="list-inline">
                                                    <li>
                                                        <p>
                                                            <span><?php echo translate('date'); ?> : </span><?php echo date("d-m-Y", strtotime($row['created_on'])); ?></p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <span><?php echo translate('author'); ?> : </span><?php echo ucfirst(isset($row['company_name']) && $row['company_name'] != '' ? $row['company_name'] : get_CompanyName()); ?></p>
                                                    </li>
                                                    <li>
                                                        <p>
                                                            <span><?php echo translate('status'); ?> : </span><?php echo check_appointment_status($row['status']); ?></p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- end /.product__additional_info -->
                                        </div>
                                        <!-- end /.col-md-3 -->

                                        <div class="col-lg-4 col-md-4 xs-fullwidth">
                                            <div class="product__price_download">
                                                <div class="item_price v_middle">
                                                    <span><?php echo $row['payment_type'] == 'F' ? translate('free') : price_format(number_format($row['final_price']), 0); ?></span>
                                                </div>
                                                <div class="item_action v_middle text-center" style="min-width: 240px;">
                                                    <a onclick="get_details('<?php echo (int) $row['id']; ?>');" class="btn-danger btn-floating btn-sm btn-success" title="<?php echo translate('view_details'); ?>"><i class="fa fa-eye"></i></a>
                                                    <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn-danger btn-floating btn-sm red-gradient" title="<?php echo translate('delete'); ?>"><i class="fa fa-trash"></i></a>
                                                    <a class="btn-floating btn-sm" href="<?php echo base_url(UPLOAD_PATH . "invoice/" . $row['invoice_file']); ?>" download target="_blank"><i class="fa fa-download"></i></a>
                                                    <?php $your_raing = chek_rating($row['event_id']); ?>
                                                    <a href="javascript:void(0)" class="btn white btn--white rating--btn mt-10 <?php echo isset($your_raing) && $your_raing == 'true' ? '' : 'not--rated'; ?>" <?php echo isset($your_raing) && $your_raing == 'true' ? '' : 'data-toggle="modal" data-target="#rating_modal"'; ?>  onclick="append_id('<?php echo $row['event_id']; ?>')">
                                                        <p class="rate_it"><?php echo translate('rating_item') ?></p>
                                                        <div class="rating product--rating">
                                                            <ul class="list-inline inline-ul">
                                                                <?php
                                                                $rating = event_rating($row['event_id']);
                                                                $j = 5 - $rating;
                                                                for ($i = 1; $i <= $rating; $i++) {
                                                                    ?>
                                                                    <li>
                                                                        <span class="fa fa-star" style="color:#ffba00;"></span>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                for ($i = 1; $i <= $j; $i++) {
                                                                    ?>
                                                                    <li>
                                                                        <span class="fa fa-star"></span>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                    <!-- end /.rating_btn -->
                                                </div>
                                                <!-- end /.item_action -->
                                            </div>
                                            <!-- end /.product__price_download -->
                                        </div>
                                        <!-- end /.col-md-4 -->
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-md-12 text-center">
                                <img src="<?php echo base_url() . img_path . "/no-result.png"; ?>" alt="no-result">
                            </div>
                            <?PHP
                        }
                        ?>
                    </div>
                </div>
                <!-- end /.row -->
            </div>
        </section>
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
<!-- Modal -->
<div class="modal fade" id="view-record">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px;"><?php echo translate('appointment_details'); ?></h4>
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="get_view_data">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--Rating Modal-->
<div class="modal fade" id="rating_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-block">
                <h5 class="modal-title mb-3" id="exampleModalLabel"><?php echo translate('rating_item'); ?></h5>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="ReviewForm" method="post">
                <input type="hidden" id="event_id" value=""/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="mt-3"><?php echo translate('your_rating'); ?> :</h6>
                        </div>
                        <div class="col-md-8">
                            <a href="javascript:void(0)" class="btn white btn--white rating--btn not--rated">
                                <div class="rating product--rating submit-rating">
                                    <ul class="list-inline inline-ul">
                                        <li onclick="get_rating(this);">
                                            <i class="fa fa-star fa-2x"></i>
                                        </li>
                                        <li onclick="get_rating(this);">
                                            <i class="fa fa-star fa-2x"></i>
                                        </li>
                                        <li onclick="get_rating(this);">
                                            <i class="fa fa-star fa-2x"></i>
                                        </li>
                                        <li onclick="get_rating(this);">
                                            <i class="fa fa-star fa-2x"></i>
                                        </li>
                                        <li onclick="get_rating(this);">
                                            <i class="fa fa-star fa-2x"></i>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-bold"><?php echo translate('review'); ?></label>
                                <textarea name='review_value' id="review_value" required></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success waves-effect" onclick="submit_rating(this);"><?php echo translate('submit'); ?></button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><?php echo translate('close'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo $this->config->item('admin_js_url'); ?>module/appointment.js" type='text/javascript'></script>
<script>
                        $(document).ready(function () {
                            $('#example').DataTable({
                                columnDefs: [
                                    {
                                        targets: [0, 1, 2],
                                        className: 'mdl-data-table__cell--non-numeric'
                                    }
                                ]
                            });
                        });
                        function append_id(id) {
                            $('#event_id').val(id);
                        }
                        function get_details(id) {
                            $.ajax({
                                url: base_url + "get-appointment-details/" + id,
                                type: "post",
                                data: {token_id: csrf_token_name},
                                beforeSend: function () {
                                    $('#loadingmessage').show();
                                },
                                success: function (data) {
                                    $('#get_view_data').html(data);
                                    $('#loadingmessage').hide();
                                    $('#view-record').modal('show');
                                }
                            });
                        }
                        
                        function get_rating(e) {
                            $(e).parents('ul').find('li').find('i').css("color", "");
                            for (i = 0; i <= $(e).index(); i++) {
                                $(e).parents('ul').find('li:eq(' + i + ')').find('i').css("color", "#ffba00");
                            }
                        }
                        function submit_rating(e) {
                            if ($('#ReviewForm').valid()) {
                                rating = $('.submit-rating').find("ul li i[style]").length;
                                review = $('#review_value').val();
                                id = $('#event_id').val();
                                $.ajax({
                                    url: base_url + "front/submit_rating/" + id,
                                    type: "post",
                                    data: {rating: rating, review: review, token_id: csrf_token_name},
                                    beforeSend: function () {
                                        $('#loadingmessage').show();
                                    },
                                    success: function (data) {
                                        window.location.reload();
                                    }
                                });
                            }
                        }
</script>
<?php include VIEWPATH . 'front/footer.php'; ?>