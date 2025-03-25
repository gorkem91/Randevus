<?php
include VIEWPATH . 'front/header.php';
?>
<div class="container">
    <div class="mt-20">
        <?php
        $this->load->view('message');
        $profile_image = base_url() . img_path . "/default_user.png";
        if (isset($admin_data) && count($admin_data) > 0 && !empty($admin_data['profile_image']) && $admin_data['profile_image'] != 'null') {
            $profile_image = check_admin_image(UPLOAD_PATH . "profiles/" . $admin_data['profile_image']);
        }
        ?>        
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="user_details">
                        <div class="text-center">
                            <img src="<?php echo $profile_image; ?>" class="img-fluid rounded-circle" />
                            <p class="user-name"><?php echo $admin_data['first_name'] . ' ' . $admin_data['last_name']; ?></p>
                            <?php if (isset($admin_data['fb_link']) || isset($admin_data['twitter_link']) || isset($admin_data['google_link'])) { ?>
                                <div class="social_icon">
                                    <ul class="list-inline inline-ul">
                                        <?php if (isset($admin_data['fb_link']) && $admin_data['fb_link'] != '') { ?>
                                            <li>
                                                <a href="<?php echo $admin_data['fb_link']; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                            </li>
                                        <?php } if (isset($admin_data['twitter_link']) && $admin_data['twitter_link'] != '') { ?>
                                            <li>
                                                <a href="<?php echo $admin_data['twitter_link']; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                            </li>
                                        <?php } if (isset($admin_data['google_link']) && $admin_data['google_link'] != '') { ?>
                                            <li>
                                                <a href="<?php echo $admin_data['google_link']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="gobtn">
                                <?php if ($this->session->userdata('CUST_ID')) { ?>
                                    <a class="btn btn-dark w-100" href="<?php echo base_url('message/' . $admin_data['id']); ?>"><?php echo translate('send_message'); ?></a>
                                <?php } else {
                                    ?>
                                    <a class="btn btn-dark w-100" href="<?php echo base_url('login'); ?>"><?php echo translate('send_message'); ?></a>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <p class="details_info">
                        <?php
                        if (isset($admin_data['profile_text'])) {
                            echo $admin_data['profile_text'];
                        } else {
                            echo translate('profile_text_content');
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <h3>
                        <?php echo translate('information'); ?>
                    </h3>
                    <hr>

                    <ul class="data list-inline">
                        <li>
                            <p><?php echo translate('full_name') ?></p>
                            <span> <?php echo ucfirst($admin_data['first_name']) . " " . $admin_data['last_name']; ?></span>
                        </li>
                        <?php if ($admin_data['company_name'] != '') { ?>
                            <li>
                                <p><?php echo translate('company_name') ?></p>
                                <span><?php echo ucfirst($admin_data['company_name']); ?></span>
                            </li>
                        <?php } ?>
                        <li>
                            <p><?php echo translate('phone') ?></p>
                            <span> <?php echo $admin_data['phone']; ?></span>
                        </li>
                        <?php if ($admin_data['website'] != '') { ?>
                            <li>
                                <p><?php echo translate('website') ?></p>
                                <span><?php echo $admin_data['website']; ?></span>
                            </li>
                        <?php } ?>
                        <li>
                            <p><?php echo translate('member_join') ?></p>
                            <span><?php echo date('d-m-Y', strtotime($admin_data['created_on'])); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="silder_section">
                <!--Carousel Wrapper-->
                <div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
                    <!--Slides-->
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $get_profile_slider = get_profile_slider($admin_data['id']);
                        if (isset($get_profile_slider) && count($get_profile_slider) > 0) {
                            foreach ($get_profile_slider as $slider_key => $slider_value) {
                                ?>
                                <div class="carousel-item <?php echo isset($slider_key) && $slider_key == 0 ? 'active' : ''; ?>">
                                    <img class="d-block w-100 h-270" src="<?php echo check_admin_image(UPLOAD_PATH . "slider/" . $slider_value['image']); ?>" alt="First slide">
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="carousel-item active">
                                <img class="d-block w-100 h-270" src="<?php echo base_url() . DEFAULT_SLIDER_IMAGE; ?>" alt="First slide">
                            </div>
                        <?php }
                        ?>
                    </div>
                    <!--/.Slides-->
                    <!--Controls-->
                    <a class="carousel-control-prev" href="#carousel-thumb" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-thumb" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                </div>
                <!--/.Carousel Wrapper-->
            </div>
            <hr/>
            <div class="row mt-4 resp_mb-60">
                <?php
                foreach ($event_data as $rows) {

                    if (isset($rows) && count($rows) > 0 && !empty($rows['image']) && $rows['image'] != 'null') {
                        $image_array = json_decode($rows['image']);
                        $event_image = check_admin_image(UPLOAD_PATH . "event/" . $image_array[0]);
                        ?>
                        <div class="col-md-6 mt-0">
                            <div class="card hoverable position-r home_card">
                                <div class="view overlay <?php echo isset($key) && $key == 0 ? 'active' : ''; ?> ">

                                    <img class="card-img-top" src="<?php echo $event_image; ?>">
                                    <div class="prod_btn">
                                        <a class="transparent border" href="<?php echo base_url('event-details/' . $rows['created_by'] . '/' . $rows['id']); ?>">
                                           <?php echo translate('more_info'); ?>
                                        </a>
                                    </div>


                                    <ul class="titlebtm list-inline inline-ul pb-10">
                                        <li class="product_cat">
                                            <a href="<?php echo base_url('event-category/' . $rows['category_id']); ?>" style="text-decoration: none;">
                                                <?php echo $rows['category_title']; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body product-docs pb-5px">
                                    <h4 class="card-title"><?php echo $rows['title']; ?></h4>
                                    <div class="w-100">
                                        <div class="sell mb-3">
                                            <p><i class="fa fa-map-marker pr-10 text-danger"></i>
                                                <?php echo $rows['city_title']; ?> 
                                                <span class="location-area"><i>  <?php echo $rows['loc_title']; ?> </i></span>
                                            </p> 
                                        </div>
                                        <div class="sell mb-3">
                                            <p><i class="fa fa-clock-o mr-10 text-success"></i>
                                                <?php
                                                echo str_replace('{slot_time}', $rows['slot_time'], translate('event_time'));
                                                $discountDate = date("Y-m-d");
                                                if ($rows['payment_type'] == 'P' && $rows['discounted_price'] > 0 && ($discountDate >= $rows['from_date']) && ($discountDate <= $rows['to_date'])) {
                                                    $is_discount_available = 'Y';
                                                    ?>
                                                    <span class="total_discount"><?php echo number_format($rows['discount'], 0); ?>% <?php echo translate('off'); ?></span>
                                                    <?php
                                                } else {
                                                    $is_discount_available = 'N';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-purchase">
                                    <div class="sell">
                                        <?php $created_by = get_VendorDetails($rows['created_by']); ?>
                                        <a href="<?php echo base_url('profile-details/' . $created_by['user_id']); ?>" style="text-decoration: none;">
                                            <img class="auth-img" src="<?php echo check_admin_image(UPLOAD_PATH . "profiles/" . $created_by['profile_image']); ?>" alt=""/>
                                        </a>
                                        <p>
                                            <a href="<?php echo base_url('profile-details/' . $created_by['user_id']); ?>" style="text-decoration: none;">
                                                <span class="category-title" style="color: #151111"><?php echo ucfirst(isset($created_by['company_name']) && $created_by['company_name'] != '' ? $created_by['company_name'] : get_CompanyName()); ?></span>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="price_love">
                                        <span>
                                            <?php
                                            if (isset($rows['payment_type']) && $rows['payment_type'] == 'F') {
                                                echo translate('free');
                                            } else {
                                                if (isset($is_discount_available) && $is_discount_available == 'Y') {
                                                    ?>
                                                    <?php
                                                    echo "$" . (number_format($rows['discounted_price']));
                                                    ?>
                                                    <span class="total_price"><?php echo "$" . (number_format($rows['price'])); ?></span> 
                                                    <?php
                                                } else {
                                                    echo price_format($rows['price']);
                                                }
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>

<?php include VIEWPATH . 'front/footer.php'; ?>