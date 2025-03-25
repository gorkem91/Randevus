<?php
include VIEWPATH . 'front/header.php';
$category_id = $this->uri->segment(2);
$search_txt = $this->input->get('search_as');
$totalRowCount = isset($total_Event) && !empty($total_Event) ? count($total_Event) : 0;

$showLimit = get_site_setting('display_record_per_page');
if (get_site_setting('is_display_searchbar') == "Y") {
    ?>
    <div class="search_box_nav">
        <div class="container">
            <div class="row">
                <div class="col-md-7 m-auto">
                    <div class="search-bar" data-toggle="modal" data-target="#searchPopup">
                        <div class="search-bar__input">
                            <i class="fa fa-search"></i>
                            <p class="line-height-xs"><?php echo translate('search_restaurants_spa_events_city_location_vendor'); ?></p>
                        </div>
                        <button class="btn btn-primary search-bar_btn"><?php echo translate('search'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<input type="hidden" id="row" value="<?php echo get_site_setting('display_record_per_page'); ?>">
<input type="hidden" id="all" value="<?php echo isset($total_Event) && !empty($total_Event) ? count($total_Event) : 0; ?>">
<input type="hidden" value="P" id="sort_by" name="sort_by"/>
<input type="hidden" id="slug" name="slug" value="category"/>
<div class="container">
    <div class="my-3">
        <div class="row">
            <div class="col-md-5">
                <h6>
                    <?php echo $this->input->cookie('location', true) != '' ? translate('events_in') . ' ' . $this->input->cookie('location', true) : ''; ?>
                </h6>
            </div>
            <div class="col-md-7">
                <div class="sort_btn">
                    <div class="float-right">
                        <button  class="active" value="P" onclick="sort_by(this);"><?php echo translate('popular'); ?></button>
                        <button  value="N" onclick="sort_by(this);"><?php echo translate('whats_new'); ?></button>
                        <button  value="H" onclick="sort_by(this);"><?php echo translate('price_high_to_low'); ?></button>
                        <button  value="L" onclick="sort_by(this);"><?php echo translate('price_low_to_high'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="p-2">
                    <aside class="filter-categories">
                        <h5 class="category-heading"><?php echo translate('categories'); ?></h5>
                        <ul class="list-block menu list-inline" id="menu">
                            <?php
                            if (isset($Events_Category) && !empty($Events_Category)) {
                                foreach ($Events_Category as $row) {
                                    ?>  
                                    <li class="open">
                                        <a class="menu-header" href="<?php echo base_url('category-details/' . $row['id']) ?>">
                                            <span><?php echo ucfirst($row['title']); ?></span>
                                            <span class="count float-right pr-3"><?php echo "(" . $row['total_booking'] . ")"; ?></span>
                                        </a>

                                    </li>
                                    <?php
                                }
                            }
                            ?>

                        </ul>
                    </aside>
                    <?php if (get_site_setting('is_display_location') == 'Y') { ?>
                        <hr>
                        <ul class="list-block menu list-inline" id="location_menu">
                            <li id="open_l" class="open">
                                <a class="menu-header">
                                    <h5><?php echo $this->input->cookie('location', true); ?></h5>
                                </a>
                                <ul class="list-inline" id="sub-menu_option">
                                    <?php
                                    if (isset($Location_List) && !empty($Location_List)) {
                                        foreach ($Location_List as $row) {
                                            ?>  
                                            <li>
                                                <a>
                                                    <div class="form-group mb-1">
                                                        <input name="location[]" type="checkbox" class="custom-control-input" id="<?php echo $row['loc_id']; ?>" onchange="location_event(1);" value="<?php echo $row['loc_id']; ?>">
                                                        <label class="custom-control-label" for="<?php echo $row['loc_id']; ?>"><?php echo $row['loc_title']; ?></label>
                                                    </div>                                            
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <li>
                                            <p class="text-center">
                                                <?php echo translate('no_location_found'); ?>                            
                                            </p>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                </ul>
                            </li>
                        </ul>

                    <?php } ?>
                </div>
            </div>
        </div>   
        <div class="col-md-9 resp_mb-60" id="display_none_block" style="display: none;text-align: center">
            <img src="<?php echo base_url('assets/images/no-result.png'); ?>" alt="No Image"/>
        </div>
        <div class="col-md-9 resp_mb-60 events_wrapper">
            <div class="row">

            </div>
            <div class="col-md-3 m-auto text-center">
                <img class="m-3" src="<?php echo $this->config->item('images_url') . "/ajax-loading.gif" ?>" id="loadingmore_img" style="display: none;height: 30px;">
            </div>
            <div  class="loadmore d-none text-center" lastid="<?php echo get_site_setting('display_record_per_page'); ?>">
            </div>
            <div class="col-md-5 m-auto text-center">
                <button class="load_more btn btn-success mb-3 d-none btn-small" id="load_more" onclick="load_more()"><?php echo translate('load_more') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //Location Menu List
        $('#location_menu li#open_l').click(function () {
            if ($(this).hasClass("close-btn")) {
                $(this).addClass("open");
                $(this).removeClass("close-btn");

            } else {
                $(this).removeClass("open");
                $(this).addClass("close-btn");
            }
        });
        $("#sub-menu_option li").click(function (e) {
            e.stopPropagation();
        });

    });

    function sort_by(element) {
        console.log("1");
        $(".sort_btn button").removeClass("active");
        var val = $(element).val();
        $("#sort_by").val(val);

        $(element).addClass("active");
        location_event(1, 'category');
    }

</script>
<?php include VIEWPATH . 'front/footer.php'; ?>