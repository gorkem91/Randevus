<?php
include VIEWPATH . 'front/header.php';
$location = $this->uri->segment(2);
$search_txt = $this->input->get('search_as');
$totalRowCount = isset($total_Event) && !empty($total_Event) ? count($total_Event) : 0;
$showLimit = get_site_setting('display_record_per_page');

?>
<input type="hidden" id="row" value="<?php echo get_site_setting('display_record_per_page'); ?>">
<input type="hidden" id="all" value="<?php echo isset($total_Event) && !empty($total_Event) ? count($total_Event) : 0; ?>">
<input type="hidden" value="N" id="sort_by" name="sort_by"/>
<input type="hidden" id="slug" name="slug" value="home"/>
<link href="<?php echo $this->config->item('js_url'); ?>owl-carousel/owl.theme.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('js_url'); ?>owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $this->config->item('js_url'); ?>owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
<?php if (get_site_setting('is_display_searchbar') == "Y" && $totalRowCount > 0) { ?>
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
<?php if (get_site_setting('is_display_category') == "Y") { ?>
    <div class="event_slider">
        <div class="container">
            <div class="owl-carousel owl-theme">
                <?php
                if (isset($Events_Category) && !empty($Events_Category)) {
                    foreach ($Events_Category as $row) {
                        ?>
                        <div class="item">
                            <a href="<?php echo base_url('category-details/' . $row['id']); ?>">
                                <div class="event_img_title">
                                    <div class="event_img">
                                        <?php
                                        if (file_exists(FCPATH . "assets/uploads/category/" . $row['event_category_image'])) {
                                            $img_src = base_url() . UPLOAD_PATH . "category/" . $row['event_category_image'];
                                        } else {
                                            $img_src = base_url() . UPLOAD_PATH . "category/default_events.jpg";
                                        }
                                        ?>
                                        <img src="<?php echo $img_src; ?>" class="img-fluid"/>
                                    </div>
                                    <h6><?php echo $row['title']; ?></h6>                        
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                }
                ?>


            </div>
        </div>
    </div>
<?php } ?>

<div class="container">
    <div class="mt-20">
        <?php $this->load->view('message'); ?>        
    </div>
    <h3 class="text-center mt-20"><?php echo translate('book_your_event'); ?></h3>
    <?php
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    }
    ?>	
    <div class="mb-4 resp_mb-60">
        <div class="row">
            <div class="event_block"></div>
        </div>
    </div>
    <div class="col-md-12 resp_mb-60" id="display_none_block" style="display: none;text-align: center">
        <img src="<?php echo base_url('assets/images/no-result.png'); ?>" alt="No Image"/>
    </div>
    <div class="col-md-3 m-auto text-center">
        <img class="m-3" src="<?php echo $this->config->item('images_url') . "/ajax-loading.gif" ?>" id="loadingmore_img" style="display: none;height: 30px;">
    </div>
    <div  class="loadmore d-none text-center" lastid="<?php echo get_site_setting('display_record_per_page'); ?>">
    </div>
    <?php if ($totalRowCount > $showLimit) { ?>
        <div class="col-md-3 m-auto text-center">
            <button class="load_more btn btn-success mb-3 d-none btn-small" id="load_more" onclick="load_more()"><?php echo translate('load_more') ?></button>
        </div>
    <?php } ?>
</div>

<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            autoplay: false,
            loop: true,
            dots: false,
            nav: true,
            margin: 0,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    slideBy: 3,
                    nav: true
                },
                600: {
                    items: 4,
                    slideBy: 4,
                    nav: true
                },
                980: {
                    items: 6,
                    slideBy: 6,
                    nav: true
                },
                1000: {
                    items: 7,
                    slideBy: 7,
                    nav: true,
                    loop: false,
                    margin: 20
                }
            }

        });
        $(".owl-prev").html('<i class="fa fa-angle-left"></i>');
        $(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
</script>
<?php include VIEWPATH . 'front/footer.php'; ?>
