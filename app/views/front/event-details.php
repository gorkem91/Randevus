<?php
$location_api_key = get_site_setting('google_map_key');
include VIEWPATH . 'front/header.php';
?>
<?php if (isset($event_data['is_display_address']) && $event_data['is_display_address'] == 'Y') { ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo isset($location_api_key) ? $location_api_key : ''; ?>&libraries=geometry"></script>
<?php } ?>
    
<input type="hidden" id="address" name="address" value="<?php echo isset($event_data['address']) ? $event_data['address'] : '' ?>"/>
<div class="container">
    <div class="mt-20">
        <?php $this->load->view('message'); ?>        
    </div>
    <?php
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    }

    if (isset($event_data) && count($event_data) > 0 && !empty($event_data['image']) && $event_data['image'] != 'null') {
        foreach (json_decode($event_data['image']) as $key => $value) {
            $all_image[] = check_admin_image(UPLOAD_PATH . "event/" . $value);
        }
    }
    $profile_image = base_url() . img_path . "/default_user.png";
    if (isset($admin_data) && count($admin_data) > 0 && !empty($admin_data['profile_image']) && $admin_data['profile_image'] != 'null') {
        $profile_image = check_admin_image(UPLOAD_PATH . "profiles/" . $admin_data['profile_image']);
    }
    ?>   
    <div class="mb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3><?php echo (trim($event_data['title'])); ?></h3>
                        <hr>
                        <div class="img_slider">
                            <div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
                                <!--Slides-->
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    if (isset($all_image) && count($all_image) > 0) {
                                        foreach ($all_image as $key => $value) {
                                            ?>
                                            <div class="carousel-item <?php echo isset($key) && $key == 0 ? 'active' : ''; ?>">
                                                <img class="d-block w-100" src="<?php echo $value; ?>">
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <!--/.Slides-->
                                <!--Controls-->
                                <a class="carousel-control-prev" href="#carousel-thumb" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only"><?php echo translate('previous'); ?></span>
                                </a>
                                <a class="carousel-control-next" href="#carousel-thumb" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only"><?php echo translate('next'); ?></span>
                                </a>
                                <!--/.Controls-->
                                <ol class="carousel-indicators mx-0">
                                    <?php
                                    if (isset($all_image) && count($all_image) > 0) {
                                        foreach ($all_image as $key => $value) {
                                            ?>
                                            <li data-target="#carousel-thumb" data-slide-to="<?php echo $key; ?>" class="<?php echo isset($key) && $key == 0 ? 'active' : ''; ?>"> <img class="d-block w-100" src="<?php echo $value; ?>" class="img-fluid"></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-5 card">
                    <div class="tabs_details">
                        <!-- Nav tabs -->
                        <div class="tabs-wrapper"> 
                            <ul class="nav classic-tabs tabs-cyan" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link waves-light active" data-toggle="tab" href="#details" role="tab"><?php echo translate('details'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link waves-light" data-toggle="tab" href="#rating" role="tab"><?php echo translate('rating_review'); ?></a>
                                </li>
                                <?php if (isset($event_data['is_display_address']) && $event_data['is_display_address'] == 'Y') { ?>
                                    <li class="nav-item">
                                        <a class="nav-link waves-light" data-toggle="tab" href="#map" role="tab"><?php echo translate('location'); ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="card-body">
                            <!-- Tab panels -->
                            <div class="tab-content">

                                <!--Panel 1-->
                                <div class="tab-pane fade in show active" id="details" role="tabpanel">
                                    <p><?php echo $event_data['description']; ?></p>
                                </div>
                                <!--/.Panel 1-->

                                <!--Panel 2-->
                                <div class="tab-pane fade" id="rating" role="tabpanel">
                                    <?php
                                    if (isset($event_rating) && count($event_rating) > 0) {
                                        foreach ($event_rating as $key_raing => $row) {
                                            ?>
                                            <div>
                                                <ul class="list-inline inline-ul">
                                                    <?php for ($i = 1; $i <= $row['rating']; $i++) { ?>
                                                        <li>
                                                            <i class="fa fa-star" style="color:#ffba00;"></i>
                                                        </li>
                                                    <?php } ?>
                                                    <?php
                                                    $j = 5 - $row['rating'];
                                                    for ($i = 1; $i <= $j; $i++) {
                                                        ?>
                                                        <li>
                                                            <i class="fa fa-star"></i>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <h6 class="user-name">
                                                    <?php echo $row['review']; ?>
                                                </h6>
                                            </div>
                                            <?php if (count($event_rating) != $key_raing + 1) { ?>
                                                <hr>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red; padding-top: 50px; font-size: 40px; text-align: center; width: 100%;" ></i>
                                        <h4 class='no_record'> <?php echo translate('no_record_found'); ?></h4>
                                    <?php }
                                    ?>
                                </div>
                                <!--/.Panel 2-->      
                                <?php if (isset($event_data['is_display_address']) && $event_data['is_display_address'] == 'Y') { ?>
                                    <!--Panel 3-->
                                    <div class="tab-pane fade" id="map" role="tabpanel">
                                        <button id="btnlocation" class="btn btn-success d-none" onClick="showCloseLocations()">Show Locations In Radius</button>
                                        <div id="googleMap" style="width:100%;height:400px;"></div>
                                    </div>
                                    <!--/.Panel 3-->
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6><?php echo translate('vendor'); ?></h6>
                        <hr>
                        <div class="user_details">
                            <div class="text-center">
                                <img src="<?php echo $profile_image; ?>" alt="profile" class="img-fluid rounded-circle" />
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
                                    <a class="btn btn-dark" href="<?php echo base_url('profile-details/' . $admin_data['id']); ?>"><?php echo translate('go_to_profile_page'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sidebar-card card-pricing card mt-4">
                    <div class="card-body">
                        <div class="price">
                            <h1 class="mb-0"><?php echo isset($event_data['payment_type']) && $event_data['payment_type'] == 'F' ? translate('free') : price_format($event_data['price']); ?></h1>
                        </div>

                        <div class="purchase-button btn_list">
                            <a href="<?php echo base_url('day-slots/' . $event_data['id']); ?>" class="btn btn-info btn-lg w-100 mx-0">
                                <i class="fa fa-ticket"></i>
                                <?php echo translate('book_your_event'); ?>
                            </a>
                        </div>
                        <!-- end /.purchase-button -->
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3>
                            <?php echo translate('event_information'); ?>
                        </h3>
                        <hr>

                        <ul class="data list-inline">
                            <li>
                                <p><?php echo translate('category') ?></p>
                                <span> <?php echo $event_data['category_title']; ?></span>
                            </li>
                            <li>
                                <p><?php echo translate('city') ?></p>
                                <span><?php echo $event_data['city_title']; ?></span>
                            </li>
                            <li>
                                <p><?php echo translate('location') ?></p>
                                <span> <?php echo $event_data['loc_title']; ?></span>
                            </li>
                            <li>
                                <p><?php echo translate('slot_time') ?></p>
                                <span> <?php echo str_replace('{slot_time}', $event_data['slot_time'], translate('event_time')); ?></span>
                            </li>
                            <li>
                                <p><?php echo translate('total_booking') ?></p>
                                <span><?php echo $event_book; ?></span>
                            </li>
                            <li>
                                <p><?php echo translate('rating') ?></p>
                                <ul class="list-inline inline-ul float-right">
                                    <?php for ($i = 1; $i <= $avr_rating; $i++) { ?>
                                        <li>
                                            <i class="fa fa-star" style="color:#ffba00;"></i>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    $j = 5 - $avr_rating;
                                    for ($i = 1; $i <= $j; $i++) {
                                        ?>
                                        <li>
                                            <i class="fa fa-star"></i>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var all_locations = [$('#address').val()];
    function myMap() {
        var mapProp = {
            center: new google.maps.LatLng(51.508742, -0.120850),
            zoom: 5,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    }
    var map = null;
    var radius_circle;
    var markers_on_map = [];
    var geocoder;
    var infowindow;
    function showCloseLocations() {
        var i;
//        var radius_km = $('#radius_km').val();
        var radius_km = 100;
        var address = $('#address').val();
        //remove all radii and markers from map before displaying new ones
        if (radius_circle) {
            radius_circle.setMap(null);
            radius_circle = null;
        }
        for (i = 0; i < markers_on_map.length; i++) {
            if (markers_on_map[i]) {
                markers_on_map[i].setMap(null);
                markers_on_map[i] = null;
            }
        }

        if (geocoder) {
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                        var address_lat_lng = results[0].geometry.location;
                        radius_circle = new google.maps.Circle({
                            center: address_lat_lng,
                            radius: radius_km * 1000,
                            clickable: false,
                            map: map
                        });
                        if (radius_circle) {
                            map.fitBounds(radius_circle.getBounds());
                            radius_circle.setMap(null);
                        }
                        for (var j = 0; j < all_locations.length; j++) {
                            (function (location) {
                                var marker_lat_lng = new google.maps.LatLng(location.lat, location.lng);
                                var distance_from_location = google.maps.geometry.spherical.computeDistanceBetween(address_lat_lng, marker_lat_lng); //distance in meters between your location and the marker
                                if (distance_from_location <= radius_km * 1000) {
                                    var new_marker = new google.maps.Marker({
                                        position: marker_lat_lng,
                                        map: map,
                                        title: location.name
                                    });
                                    google.maps.event.addListener(new_marker, 'click', function () {
                                        if (infowindow) {
                                            infowindow.setMap(null);
                                            infowindow = null;
                                        }
                                        infowindow = new google.maps.InfoWindow(
                                                {content: '<div><b></b>NAME : ' + all_locations + '</div>',
                                                    size: new google.maps.Size(150, 50),
                                                    pixelOffset: new google.maps.Size(0, -30)
                                                    , position: marker_lat_lng, map: map});
                                    });
                                    markers_on_map.push(new_marker);
                                }
                            })(all_locations[j]);
                        }
                    } else {
                        alert("No results found while geocoding!");
                    }
                } else {
                    alert("Geocode was not successful: " + status);
                }
            });
        }
    }
    $(document).ready(function () {

        var latlng = new google.maps.LatLng(40.723080, -73.984340); //you can use any location as center on map startup
        var myOptions = {
            zoom: 1,
            center: latlng,
            mapTypeControl: true,
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
            navigationControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
        geocoder = new google.maps.Geocoder();
        google.maps.event.addListener(map, 'click', function () {
            if (infowindow) {
                infowindow.setMap(null);
                infowindow = null;
            }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            if (target == "#map") {
                $("#btnlocation").trigger("click");
            }
        });

    });
</script>

<?php include VIEWPATH . 'front/footer.php'; ?>