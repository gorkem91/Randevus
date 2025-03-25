<?php
$this->db->select('*', false);
$this->db->from('app_site_setting');
$company_data = $this->db->get()->row();
$footer_color_code = get_site_setting('footer_color_code');
$Total_Event_Count = isset($total_Event) && is_array($total_Event) ? count($total_Event) : 0;
?>
<footer class="page-footer mt-0 p-0 lr-page" style="background-color : <?php echo $footer_color_code != '' && $footer_color_code != NULL ? $footer_color_code : '#4b6499' ?>!important">
    <div class="container">    
        <!--Copyright--> 
        <div class="footer-copyright d-inline">
            <div class="mt-0 p-0 float-left">
                <strong>&copy;</strong> <?php echo get_CompanyName() . " " . date("Y"); ?>
            </div>
        </div>
        <ul class="ml-auto inline-ul d-inline">
            <?php if (isset($company_data->fb_link) && $company_data->fb_link != '') { ?>
                <li><a href="<?php echo $company_data->fb_link ?>"><i class="fa fa-facebook white-text"></i></a></li>
            <?php } ?>

            <?php if (isset($company_data->google_link) && $company_data->google_link != '') { ?>
                <li><a href="<?php echo $company_data->google_link ?>"><i class="fa fa-google-plus white-text"></i></a></li>
            <?php } ?>

            <?php if (isset($company_data->twitter_link) && $company_data->twitter_link != '') { ?>
                <li><a href="<?php echo $company_data->twitter_link ?>"><i class="fa fa-twitter white-text"></i></a></li>
            <?php } ?>

            <?php if (isset($company_data->linkdin_link) && $company_data->linkdin_link != '') { ?>
                <li><a href="<?php echo $company_data->linkdin_link ?>"><i class="fa fa-linkedin  white-text"></i></a></li>
            <?php } ?>

            <?php if (isset($company_data->insta_link) && $company_data->insta_link != '') { ?>
                <li><a href="<?php echo $company_data->insta_link ?>"><i class="fa fa-instagram white-text"></i></a></li>
            <?php } ?>
        </ul>
    </div>
    <!--Copyright--> 
</footer>

<!-- Back to Top -->
<a id="toTop" class="animated lightSpeedIn" title="<?php echo translate('back_top'); ?>">
    <i class="fa fa-angle-up"></i>
</a>
<!-- /Back to Top -->

<!--Login Register Modal--> 
<div id="login_register_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?php echo translate('login') . "/" . translate('register'); ?>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="login_register_modal_body">
                <?php echo translate('login_required_for_book'); ?>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default pull-right waves-effect waves-light" href="<?php echo base_url('login?next=' . $this->uri->uri_string()); ?>"><?php echo translate('login'); ?></a>
                <a class="btn btn-primary pull-right waves-effect waves-light" href="<?php echo base_url('register?next=' . $this->uri->uri_string()); ?>"><?php echo translate('register'); ?></a>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->config->item('js_url'); ?>bookmyslot.js"></script>
<script src="<?php echo $this->config->item('js_url'); ?>admin_panel.js"></script>
<?php $select_City = $this->input->cookie('location', true); ?>
<script>
    var locationPopup = "<?php echo isset($select_City) ? trim($select_City) : 1; ?>";
    var is_display_location = "<?php echo get_site_setting('is_display_location'); ?>";
    var Total_Event_Count = "<?php echo isset($Total_Event_Count) ? trim($Total_Event_Count) : 0; ?>";
    if (locationPopup == 1 && is_display_location == 'Y' && Total_Event_Count > 0) {
        $("#locationPopup").modal('show');
    }
    location_event(1);
    function show_dropdown(e) {
        $(e).attr("aria-expanded", "true");
        $(e).next('.dropdown-menu').attr("style", "display: none;");
    }
    $("#day-carousel").carousel({
        interval: false,
        wrap: false
    })
    $(".left").click(function () {
        $("#day-carousel").carousel("prev");
    });
    $(".right").click(function () {
        $("#day-carousel").carousel("next");
    });

    //Search Modal Box
    $(document).ready(function () {
        $('.open_location').on('click', function () {
            $("#locationPopup").addClass("modal-show");
            $("#searchPopup").addClass("modal-hide");
        });
        $(".location_close").click(function () {
            $("#searchPopup").removeClass("modal-hide");
        });
        $("#locationPopup").on('hidden.bs.modal', function () {
            $("body").addClass("modal-open");
        });
        $("#locationPopup").on('shown.bs.modal', function () {
            $("body").addClass("modal-open");
        });
        $("#search").on("keyup", function () {
            var search_txt = $(this).val();
            if (search_txt == '') {
                $(".searchbox_suggestion_wrapper").addClass("d-none");
            } else {
                $.ajax({
                    type: "POST",
                    url: base_url + "front/locations",
                    data: {search_txt: search_txt},
                    beforeSend: function () {
                        $("#loadingmessage").show();
                    },
                    success: function (responseJSON) {
                        $("#loadingmessage").hide();
                        var response = JSON.parse(responseJSON);
                        $("#loadingmessage").hide();
                        $(".searchbox_suggestion").html("");
                        if ($.trim(response.status) == 'success') {
                            var append_html = '';
                            $(response.data).each(function (i, item) {
                                append_html += '<li>';
                                append_html += '<a href="' + base_url + 'events/' + item.city_title.toString().toLowerCase() + '">';
                                append_html += '<h6 class="searchbox_suggestion_heading">' + item.city_title + '</h6>';
                                append_html += '</a>';
                                append_html += '</li>';
                            });
                            $(".searchbox_suggestion").append(append_html);
                            $(".searchbox_suggestion_wrapper").removeClass("d-none");

                        } else {
                            $(".searchbox_suggestion_wrapper").addClass("d-none");
                        }
                    }
                });
            }

        });
    });

    function location_event(type) {
        var load_more_val = 0;
        var slug = $('#slug').val()
        if (type == 1) {
            $('#row').val(0);
            $(".loadmore").attr("lastid", 0);
        }
        var checked_arr = [];
        $.each($("input[name='location[]']:checked"), function () {
            checked_arr.push($(this).val());
        });

        var row = Number($('#row').val());
        var allcount = Number($('#all').val());
        var rowperpage = '<?php echo get_site_setting('display_record_per_page'); ?>';
        row = parseInt(row);

        var sort_by = $("#sort_by").val();
        $.ajax({
            type: "POST",
            url: base_url + "front/locations_events",
            async: false,
            data: {row: row, locations: checked_arr, category_id: '<?php echo isset($category_id) ? $category_id : 0; ?>', search_txt: '<?php echo isset($search_txt) ? $search_txt : ""; ?>', sort_by: sort_by},
            beforeSend: function () {

                $("#loadingmore_img").show();
            },
            success: function (responseJSON) {
                var response = JSON.parse(responseJSON);
                $("#all").val(response.total_Event);

                if ($.trim(response.status) == 'success') {
                    var append_html = '';

                    $(response.data).each(function (i, item) {
                        $("#display_none_block").hide();

                        var event_img = JSON.parse(item.image);
                        var thumb_img_name = base_url + 'assets/images/no-image.png';

                        $(event_img).each(function (i, item1) {
                            if (i == 0) {
                                thumb_img_name = base_url + 'assets/uploads/event/' + get_thumb(item1);
                            }
                            i++;
                        });
                        if (item.payment_type == 'P' && (parseInt(item.discount) > 0)) {

                            var CurrentDate = new Date();
                            var disc_from_date = item.from_date;
                            var disc_from_date_arr = disc_from_date.split("-");

                            var SelectedFrom_Date = new Date(disc_from_date_arr[0],
                                    disc_from_date_arr[1] - 1,
                                    disc_from_date_arr[2]
                                    );

                            var disc_to_date = item.to_date;
                            var disc_to_date_arr = disc_to_date.split("-");
                            var SelectedTo_Date = new Date(disc_to_date_arr[0],
                                    disc_to_date_arr[1] - 1,
                                    disc_to_date_arr[2]
                                    );

                            if (CurrentDate >= SelectedFrom_Date && CurrentDate <= SelectedTo_Date) {
                                var is_discount_available = 'Y';
                            } else {
                                var is_discount_available = 'N';
                            }

                        }


                        if (item.payment_type == 'F') {
                            price = '<span><?php echo translate('free'); ?></span>';
                        } else {
                            if (parseInt(item.discount) > 0 && is_discount_available == 'Y') {
                                price = '<span>$' + addCommas(parseFloat(item.discounted_price).toFixed(0)) + ' <span class="total_price">$' + addCommas(parseFloat(item.price).toFixed(0)) + '</span> </span>';
                            } else {
                                price = '<span>$' + addCommas(item.price);
                                +'</span>';
                            }

                        }
                        append_html += '<div class="col-md-4 event_block">';
                        append_html += '<div class="card hoverable position-r home_card">';

                        append_html += '<div class="view overlay">';
                        append_html += '<a class="d-block" href="' + base_url + 'event-details/' + item.category_id + '/' + item.id + '">';
                        if (slug == 'home') {
                            append_html += '<img class="card-img-top" src="' + thumb_img_name + '">';
                        } else {
                            append_html += '<img class="card-img-two" src="' + thumb_img_name + '">';
                        }
                        append_html += '<div class="prod_btn">';
                        append_html += '<a href="' + base_url + 'event-details/' + item.category_id + '/' + item.id + '" class="transparent border">';
                        append_html += '<?php echo translate('more_info'); ?>';
                        append_html += '</a>';
                        append_html += '</div>';
                        append_html += '</a>';
                        append_html += '<ul class="titlebtm list-inline inline-ul">';
                        append_html += '<li class="product_cat">';
                        append_html += '<a href="' + base_url + 'event-category/' + item.category_id + '" style="text-decoration: none;">';
                        append_html += item.category_title;
                        append_html += '</a>';
                        append_html += '</li>';
                        append_html += '</ul>';
                        append_html += '</div>';

                        append_html += '<div class="card-body product-docs pb-5px">';
                        append_html += '<a class="d-block" href="' + base_url + 'event-details/' + item.category_id + '/' + item.id + '">';
                        append_html += '<h4 class="card-title">' + item.title + '</h4>';

                        append_html += '<div class="w-100">';
                        append_html += '<div class="sell mb-3">';
                        append_html += ' <p><i class="fa fa-map-marker pr-10 text-danger"></i>' + item.city_title;
                        append_html += ' <span class="location-area"><i>' + item.loc_title + '</i></span>';
                        append_html += '</p>';
                        append_html += ' </div>';
                        append_html += '<div class="sell mb-3">';
                        append_html += '<p><i class="fa fa-clock-o mr-10 text-success"></i>';
                        append_html += item.slot_time + ' <?php echo translate('minute') ?>';
                        if (parseInt(item.discount) > 0 && is_discount_available == 'Y') {
                            append_html += '<span class="total_discount">' + parseFloat(item.discount).toFixed(0) + '% <?php echo translate('off') ?></span>';
                        }
                        append_html += '</p>';
                        append_html += '</div>';
                        append_html += '</div>';

                        append_html += '</a>';
                        append_html += '</div>';

                        append_html += '<div class="product-purchase">';
                        append_html += '<div class="sell">';
                        append_html += '<a href="' + base_url + 'profile-details/' + item.created_by + '" style="text-decoration: none;">';
                        if (item.profile_image != '') {
                            append_html += '<img class="auth-img" src="' + base_url + 'assets/uploads/profiles/' + item.profile_image + '" alt="">';
                        } else {
                            append_html += '<img class="auth-img" src="' + base_url + 'assets/images/no-image.png" alt="">';
                        }

                        append_html += '</a>';
                        append_html += '<p>';
                        append_html += '<a href="' + base_url + 'profile-details/' + item.created_by + '" style="text-decoration: none;">';
                        append_html += '<span class="category-title" style="color: #151111">' + item.company_name + '</span>';
                        append_html += '</a>';
                        append_html += '</p>';
                        append_html += '</div>';
                        append_html += '<div class="price_love">';
                        append_html += price;
                        append_html += '</div>';
                        append_html += '</div>';


                        append_html += '</a>';
                        append_html += '</div>';


                        append_html += '</div>';
                        append_html += '</div>';
                        load_more_val++;

                    });

                    var all = parseInt($("#all").val());
                    total_event = parseInt(load_more_val);

                    prev_load_event = parseInt($(".loadmore").attr("lastid"));
                    if (!isNaN(prev_load_event)) {
                        total_event = parseInt(prev_load_event + total_event);
                    }
                    $(".loadmore").attr("lastid", total_event);

                    if (type == 1) {
                        $(".events_wrapper .row").html("");
                        $("#loadingmore_img").hide();
                        if ($(".event_block:last-child").length > 0) {

                            $(".event_block:last-child").after(append_html).show().fadeIn("slow");


                        } else {
                            $(".events_wrapper .row").append(append_html);
                        }
                        var rowno = parseInt(row) + parseInt(rowperpage);
                        $("#row").val(rowno);
                    } else if (type == 2) {



                        $("#loadingmore_img").hide();
                        // appending posts after last post with class="post"
                        $(".event_block:last-child").after(append_html).show().fadeIn("slow");


                        var rowno = parseInt(row) + parseInt(rowperpage);
                        $("#row").val(rowno);

                    }
                    if (total_event >= all) {
                        $(".load_more").addClass("d-none");
                    } else {
                        $(".load_more").removeClass("d-none");
                    }

                } else {
                    $(".events_wrapper .row").html('');
                    $("#display_none_block").show();
                    $("#loadingmore_img").hide();
                }
            }
        }, 500);
    }

//    $(window).scroll(function () {
    function load_more() {
        $('.show_more').hide();
        $('.loding').show();
        var slug = $("#slug").val();
        location_event(2, slug);
    }
//    });
    function get_thumb(img) {
        var image_name = img.split(".");
        final_img_name = image_name[0] + "_thumb" + "." + image_name[1];
        return final_img_name;
    }
    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>
</body>
</html>
