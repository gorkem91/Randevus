<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
} else {
    include VIEWPATH . 'admin/header.php';
}
$location_api_key = get_site_setting('google_location_search_key');
$name = (set_value("name")) ? set_value("name") : (!empty($event_data) ? $event_data['title'] : '');
$description = (set_value("description")) ? set_value("description") : (!empty($event_data) ? $event_data['description'] : '');
$days = (set_value("days")) ? set_value("days") : (!empty($event_data) ? explode(",", $event_data['days']) : array());
$start_time = (set_value("start_time")) ? set_value("start_time") : (!empty($event_data) ? $event_data['start_time'] : '');
$end_time = (set_value("end_time")) ? set_value("end_time") : (!empty($event_data) ? $event_data['end_time'] : '');
$slot_time = (set_value("slot_time")) ? set_value("slot_time") : (!empty($event_data) ? $event_data['slot_time'] : '');
$per_allow = (set_value("per_allow")) ? set_value("per_allow") : (!empty($event_data) ? $event_data['monthly_allow'] : '');
$city = (set_value("city")) ? set_value("city") : (!empty($event_data) ? $event_data['city'] : '');
$location = (set_value("location")) ? set_value("location") : (!empty($event_data) ? $event_data['location'] : '');
$price = (set_value("price")) ? set_value("price") : (!empty($event_data) ? $event_data['price'] : '1');
$discount = (set_value("discount")) ? set_value("discount") : (!empty($event_data) && $event_data['discount'] > 0 ? $event_data['discount'] : '');
$discounted_price = (set_value("discounted_price")) ? set_value("discounted_price") : (!empty($event_data) ? $event_data['discounted_price'] : '');
$from_date = (set_value("from_date")) ? set_value("from_date") : (!empty($event_data) && $event_data['from_date'] != '' && $event_data['from_date'] != '0000-00-00' ? date("m/d/Y", strtotime($event_data['from_date'])) : '');
$to_date = (set_value("to_date")) ? set_value("to_date") : (!empty($event_data) && $event_data['to_date'] != '' && $event_data['to_date'] != '0000-00-00' ? date("m/d/Y", strtotime($event_data['to_date'])) : '');
$payment_type = (set_value("payment_type")) ? set_value("payment_type") : (!empty($event_data) ? $event_data['payment_type'] : 'F');
$category_id = (set_value("category_id")) ? set_value("category_id") : (!empty($event_data) ? $event_data['category_id'] : '');
$status = (set_value("status")) ? set_value("status") : (!empty($event_data) ? $event_data['status'] : '');
$is_display_address = (set_value("is_display_address")) ? set_value("is_display_address") : (!empty($event_data) ? $event_data['is_display_address'] : 'N');
$address = (set_value("address")) ? set_value("address") : (!empty($event_data) ? $event_data['address'] : '');
$longitude = (set_value("longitude")) ? set_value("longitude") : (!empty($event_data) ? $event_data['longitude'] : '');
$latitude = (set_value("latitude")) ? set_value("latitude") : (!empty($event_data) ? $event_data['latitude'] : '');
$image_data = (!empty($event_data) ? $event_data['image'] : '');
$seo_description = (set_value("seo_description")) ? set_value("seo_description") : (!empty($event_data) ? $event_data['seo_description'] : '');
$seo_keyword = (set_value("seo_keyword")) ? set_value("seo_keyword") : (!empty($event_data) ? $event_data['seo_keyword'] : '');
$seo_og_image = (set_value("seo_og_image")) ? set_value("seo_og_image") : (!empty($event_data) ? $event_data['seo_og_image'] : '');


if (isset($image_data) && $image_data != '') {
    $imageArr = json_decode($image_data);
}
$id = (set_value("id")) ? set_value("id") : (!empty($event_data) ? $event_data['id'] : 0);
?>

<input type="hidden" name="address_selection" id="address_selection" value="0">
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid">
            <section class="form-light px-2 sm-margin-b-20 ">
                <!-- Row -->
                <div class="row">
                    <div class="col-md-12 m-auto">
                        <?php $this->load->view('message'); ?>
                        <div class="header pt-3 bg-color-base">
                            <div class="d-flex">
                                <h3 class="white-text mb-3 font-bold">
                                    <?php echo isset($id) && $id > 0 ? translate('update') : translate('create'); ?> <?php echo translate('event'); ?>
                                </h3>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body mx-4 mt-4 resp_mx-0">
                                <?php
                                if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                    $form_url = 'vendor/save-event';
                                    $folder_name = 'vendor';
                                } else {
                                    $form_url = 'admin/save-event';
                                    $folder_name = 'admin';
                                }
                                ?>
                                <div class="steps-form-2">
                                    <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                                        <div class="steps-step-2">
                                            <a href="#step-1" type="button" class="btn btn-amber waves-effect ml-0" data-toggle="tooltip" data-placement="top" title=" <?php echo translate('basic'); ?> <?php echo translate('information'); ?>">
                                                <?php echo translate('basic'); ?> <?php echo translate('information'); ?>
                                            </a>
                                        </div>
                                        <div class="steps-step-2">
                                            <a href="#step-2" type="button" class="btn btn-blue-grey waves-effect" data-toggle="tooltip" data-placement="top" title="<?php echo translate('Price'); ?>">
                                                <?php echo translate('Price'); ?>
                                            </a>
                                        </div>
                                        <div class="steps-step-2">
                                            <a href="#step-3" type="button" class="btn btn-blue-grey waves-effect" data-toggle="tooltip" data-placement="top" title="<?php echo translate('media'); ?>">
                                                <?php echo translate('media'); ?>
                                            </a>
                                        </div>
                                        <div class="steps-step-2">
                                            <a href="#step-4" type="button" class="btn btn-blue-grey waves-effect" data-toggle="tooltip" data-placement="top" title="<?php echo translate('seo'); ?>">
                                                <?php echo translate('seo'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                echo form_open_multipart($form_url, array('name' => 'EventForm', 'id' => 'EventForm'));
                                echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                                echo form_input(array('type' => 'hidden', 'name' => 'hidden_image', 'id' => 'hidden_image', 'value' => isset($image_data) && $image_data != '' ? $image_data : ''));
                                echo form_input(array('type' => 'hidden', 'name' => 'folder_name', 'id' => 'folder_name', 'value' => isset($folder_name) && $folder_name != '' ? $folder_name : ''));
                                echo form_input(array('type' => 'hidden', 'name' => 'event_latitude', 'id' => 'business_latitude', 'value' => isset($latitude) && $latitude != '' ? $latitude : ''));
                                echo form_input(array('type' => 'hidden', 'name' => 'event_longitude', 'id' => 'business_longitude', 'value' => isset($longitude) && $longitude != '' ? $longitude : ''));
                                ?>
                                <input type="hidden" name="event_latitude" id="business_latitude">
                                <input type="hidden" name="event_longitude" id="business_longitude">
                                <div class="row setup-content-2" id="step-1">
                                    <div class="col-md-12">
                                        <h3 class="font-bold pl-0 my-4"><strong><?php echo translate('event'); ?> <?php echo translate('information'); ?></strong></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name"> <?php echo translate('title'); ?><small class="required">*</small></label>
                                                    <input type="text" tabindex="1" id="name" name="name" value="<?php echo $name; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">                                    
                                                    <?php echo form_error('name'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="description"> <?php echo translate('description'); ?><small class="required">*</small></label>
                                                    <textarea type="text" tabindex="2" id="description" name="description" class="form-control" placeholder="<?php echo translate('description'); ?>"><?php echo $description; ?></textarea>                              
                                                    <?php echo form_error('description'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="black-text"><?php echo translate('select'); ?> <?php echo translate('event_category'); ?><small class="required">*</small></p>
                                                    <select tabindex="3" class="kb-select initialized" id="days" name="category_id"> 
                                                        <option value=""><?php echo translate('select') . " " . translate('event_category'); ?></option>
                                                        <?php
                                                        if (isset($category_data) && count($category_data)) {
                                                            foreach ($category_data as $category_key => $category_value) {
                                                                ?>
                                                                <option value="<?php echo $category_value['id']; ?>" <?php echo isset($category_id) && $category_id == $category_value['id'] ? 'selected' : ''; ?>><?php echo $category_value['title']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php echo form_error('category_id'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="black-text"><?php echo translate('select'); ?> <?php echo translate('days'); ?><small class="required">*</small></p>
                                                    <select  tabindex="4" class="kb-select initialized" id="days" name="days[]" multiple> 
                                                        <option value="" disabled=""><?php echo translate('select') . " " . translate('days'); ?></option>
                                                        <option value="Mon" <?php echo isset($days) && in_array("Mon", $days) ? 'selected' : ''; ?>><?php echo translate('monday'); ?></option>
                                                        <option value="Tue" <?php echo isset($days) && in_array("Tue", $days) ? 'selected' : ''; ?>><?php echo translate('tuesday'); ?></option>
                                                        <option value="Wed" <?php echo isset($days) && in_array("Wed", $days) ? 'selected' : ''; ?>><?php echo translate('wednesday'); ?></option>
                                                        <option value="Thu" <?php echo isset($days) && in_array("Thu", $days) ? 'selected' : ''; ?>><?php echo translate('thursday'); ?></option>
                                                        <option value="Fri" <?php echo isset($days) && in_array("Fri", $days) ? 'selected' : ''; ?>><?php echo translate('friday'); ?></option>
                                                        <option value="Sat" <?php echo isset($days) && in_array("Sat", $days) ? 'selected' : ''; ?>><?php echo translate('saturday'); ?></option>
                                                        <option value="Sun" <?php echo isset($days) && in_array("Sun", $days) ? 'selected' : ''; ?>><?php echo translate('sunday'); ?></option>
                                                    </select>
                                                    <?php echo form_error('days[]'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                    <label for="start_time"> <?php echo translate('start_time'); ?> (In 24hr format)<small class="required">*</small></label>
                                                    <input tabindex="5" type="time" placeholder="<?php echo translate('start_time'); ?>" id="start_time" name="start_time" value="<?php echo $start_time; ?>" class="form-control">                                    
                                                    <?php echo form_error('start_time'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                    <label for="end_time"> <?php echo translate('end_time'); ?> (In 24hr format)<small class="required">*</small></label>
                                                    <input tabindex="6" type="time" placeholder="<?php echo translate('end_time'); ?>" id="end_time" name="end_time" value="<?php echo $end_time; ?>" class="form-control">                                    
                                                    <?php echo form_error('end_time'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                    <label for="slot_time"> <?php echo translate('slot_time'); ?> <small class="required">*</small> ( <?php echo translate('in_min'); ?> )</label>
                                                    <input tabindex="7" type="number" placeholder="<?php echo translate('slot_time'); ?>" id="slot_time" name="slot_time" value="<?php echo $slot_time; ?>" class="form-control" min="15">                                    
                                                    <?php echo form_error('slot_time'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                    <label for="per_allow"> <?php echo translate('per_allow'); ?> <small class="required">*</small></label>
                                                    <input tabindex="8" type="number" placeholder="<?php echo translate('per_allow'); ?>" id="per_allow" name="per_allow" value="<?php echo $per_allow; ?>" class="form-control" min="1">                                    
                                                    <?php echo form_error('per_allow'); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="black-text"><?php echo translate('select_city'); ?><small class="required">*</small></p>
                                                    <select tabindex="9" class="kb-select initialized" id="city" name="city" onchange="get_location(this.value);"> 
                                                        <option value=""><?php echo translate('select_city'); ?></option>
                                                        <?php
                                                        if (isset($city_data) && count($city_data) > 0) {
                                                            foreach ($city_data as $value) {
                                                                ?>
                                                                <option value="<?php echo $value['city_id']; ?>" <?php echo isset($city) && $city == $value['city_id'] ? 'selected' : ''; ?>><?php echo $value['city_title']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php echo form_error('city'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <p class="black-text"><?php echo translate('select_location'); ?><small class="required">*</small></p>
                                                    <select tabindex="10" class="kb-select initialized" id="location" name="location"> 
                                                        <?php if (isset($location_data) && count($location_data) > 0) { ?>
                                                            <option value=""><?php echo translate('select_location'); ?></option>
                                                            <?php foreach ($location_data as $value) {
                                                                ?>
                                                                <option value="<?php echo $value['loc_id']; ?>" <?php echo isset($location) && $location == $value['loc_id'] ? 'selected' : ''; ?>><?php echo $value['loc_title']; ?></option>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <option value=""><?php echo translate('select_city_first'); ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                    <?php echo form_error('location'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="color: #757575;" > <?php echo translate('is_display_address'); ?> <small class="required">*</small></label>
                                                <div class="form-group form-inline">
                                                    <?php
                                                    $active = $inactive = '';
                                                    if ($is_display_address == "Y") {
                                                        $active = "checked";
                                                    } else {
                                                        $inactive = "checked";
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <input tabindex="11" name='is_display_address' value="Y" type='radio' id='active'   <?php echo $active; ?>>
                                                        <label for="active"><?php echo translate('yes'); ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input tabindex="12" name='is_display_address' type='radio'  value='N' id='inactive'  <?php echo $inactive; ?>>
                                                        <label for='inactive'><?php echo translate('no'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="map_address" class="col-md-6 <?php echo isset($is_display_address) && $is_display_address == 'N' ? 'd-none' : ''; ?>">
                                                <div class="form-group">
                                                    <label for="address"> <?php echo translate('address'); ?><small class="required">*</small></label>
                                                    <input tabindex="13" type="text" id="autocomplete" name="address" class="form-control autocomplete" placeholder="<?php echo translate('address'); ?>" value="<?php echo $address; ?>"/>                     
                                                    <?php echo form_error('description'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="color: #757575;" > <?php echo translate('status'); ?> <small class="required">*</small></label>
                                                <div class="form-group form-inline">
                                                    <?php
                                                    $active = $inactive = '';
                                                    if ($status == "I") {
                                                        $inactive = "checked";
                                                    } else {
                                                        $active = "checked";
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <input tabindex="14" name='status' value="A" type='radio' id='active'   <?php echo $active; ?>>
                                                        <label for="active"><?php echo translate('active'); ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input tabindex="14" name='status' type='radio'  value='I' id='inactive'  <?php echo $inactive; ?>>
                                                        <label for='inactive'><?php echo translate('inactive'); ?></label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button class="btn btn-kb-color btn-rounded nextBtn-2 float-right" type="button"><?php echo translate('next'); ?></button>
                                    </div>
                                </div>

                                <div class="row setup-content-2" id="step-2">
                                    <div class="col-md-12">
                                        <h3 class="font-bold pl-0 my-4"><strong><?php echo translate('price'); ?> <?php echo translate('information'); ?></strong></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label style="color: #757575;" > <?php echo translate('status'); ?> <small class="required">*</small></label>
                                                <div class="form-group form-inline">
                                                    <?php
                                                    $free = $paid = '';
                                                    if ($payment_type == "P") {
                                                        $paid = "checked";
                                                    } else {
                                                        $free = "checked";
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <input tabindex="15" name='payment_type' value="F" type='radio' id='free'   <?php echo $free; ?>>
                                                        <label for="free"><?php echo translate('free'); ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input tabindex="16" name='payment_type' type='radio'  value='P' id='paid'  <?php echo $paid; ?>>
                                                        <label for='paid'><?php echo translate('paid'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;" id="price-box">
                                                    <label for="price"> <?php echo translate('price'); ?> <small class="required">*</small></label>
                                                    <input tabindex="17" onblur="calc_final_price(this);" type="number" placeholder="<?php echo translate('price'); ?>" id="price" name="price" value="<?php echo $price; ?>" class="form-control" <?php echo isset($payment_type) && $payment_type == 'F' ? 'min="0"' : 'min="1"'; ?>>                                    
                                                    <?php echo form_error('price'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="price-box form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                    <label  for="discount"> <?php echo translate('discount') . " " . translate('in') . " " . translate('percentage'); ?></label>
                                                    <input tabindex="18" onblur="calc_final_price(this);" type="number" placeholder="<?php echo translate('discount') . " " . translate('in') . " " . translate('percentage'); ?>" id="discount" name="discount" value="<?php echo $discount; ?>" class="form-control integers" <?php echo isset($payment_type) && $payment_type == 'F' ? 'min="0"' : 'min="1" max="100";'; ?>>                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;" id="price-box">
                                                    <label for="discounted_price"> <?php echo translate('discount') . " " . translate('price'); ?></label>
                                                    <input tabindex="19" readonly="" type="number" placeholder="<?php echo translate('discount') . " " . translate('price'); ?>" id="discounted_price" name="discounted_price" value="<?php echo $discounted_price; ?>" class="form-control">                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="price-box form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                    <label for="from_date"> <?php echo translate('from_date') ?></label>
                                                    <input tabindex="20" type="text" placeholder="<?php echo translate('from_date') ?>" id="from_date" name="from_date" value="<?php echo $from_date; ?>" class="form-control bdatepicker">                                    
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="price-box form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                    <label for="to_date"> <?php echo translate('to_date') ?></label>
                                                    <input tabindex="21" type="text" placeholder="<?php echo translate('to_date'); ?>" id="to_date" name="to_date" value="<?php echo $to_date; ?>" class="form-control bdatepicker">                                    
                                                </div>
                                            </div> 



                                        </div>
                                        <button class="btn btn-kb-color btn-rounded prevBtn-2 float-left" type="button"><?php echo translate('previous'); ?></button>
                                        <button class="btn btn-kb-color btn-rounded nextBtn-2 float-right" type="button"><?php echo translate('next'); ?></button>
                                    </div>
                                </div>
                                <div class="row setup-content-2" id="step-3">
                                    <div class="col-md-12">
                                        <h3 class="font-bold pl-0 my-4"><strong><?php echo translate('media'); ?> <?php echo translate('information'); ?></strong></h3>
                                        <div class="row">
                                            <?php if (isset($imageArr) && count($imageArr) > 0) { ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image"> <?php echo translate('event_image_preview'); ?></label><br>
                                                        <ul class="list-inline inline-ul" id="images_ul">
                                                            <?php
                                                            foreach ($imageArr as $value) {
                                                                ?>
                                                                <li class="hover-btn">
                                                                    <img src = "<?php echo check_admin_image(UPLOAD_PATH . "event/" . $value); ?>" class = "img-thumbnail mr-10 mb-10 height-100" width = "100px"/>
                                                                    <a class="btn-danger btn-floating btn-sm red-gradient waves-effect waves-light remove-btn" onclick="delete_event_image(this);" data-url="<?php echo UPLOAD_PATH . "event/" . $value; ?>" data-id="<?php echo $id; ?>"><i class="fa fa-trash"></i></a>
                                                                </li>
                                                            <?php }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-md-6">
                                                <div class="form-group" id="image-data">
                                                    <label for="image"> <?php echo translate('event_image'); ?> <small class="required">*</small></label><button type="button" class="btn blue-gradient waves-effect success-color btn-sm float-right" onclick="get_more_image(this);"><i class="fa fa-plus-square-o mr-10"></i><?php echo translate('more'); ?></button>
                                                    <input tabindex="22" type="file" id="image" name="image[]" class="form-control" <?php echo isset($image_data) && $image_data != '' ? '' : 'required'; ?>>                                    
                                                    <?php echo form_error('image'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-kb-color btn-rounded prevBtn-2 float-left" type="button"><?php echo translate('previous'); ?></button>
                                        <button class="btn btn-kb-color btn-rounded nextBtn-2 float-right" type="button"><?php echo translate('next'); ?></button>

                                    </div>
                                </div>
                                <div class="row setup-content-2" id="step-4">
                                    <div class="col-md-12">
                                        <h3 class="font-bold pl-0 my-4"><strong><?php echo translate('seo'); ?> <?php echo translate('information'); ?></strong></h3>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="seo_keyword"> <?php echo translate('seo_keyword') ?></label>
                                                    <input tabindex="23" type="text" placeholder="<?php echo translate('seo_keyword'); ?>" id="seo_keyword" name="seo_keyword" value="<?php echo $seo_keyword; ?>" class="form-control">                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="seo_description"> <?php echo translate('seo_description'); ?></label>
                                                    <textarea tabindex="24" type="text" id="seo_description" name="seo_description" class="form-control" placeholder="<?php echo translate('seo_description'); ?>"><?php echo $seo_description; ?></textarea>                              
                                                    <?php echo form_error('seo_description'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" id="image-data">
                                                    <label for="image"> <?php echo translate('seo_og_image'); ?></label>
                                                    <input tabindex="25" type="file" id="image" name="seo_og_image" class="form-control">                                    
                                                </div>
                                            </div>
                                            <?php if ($seo_og_image != '') { ?>
                                                <div class="col-md-6">
                                                    <ul class="list-inline inline-ul" id="images_ul">
                                                        <li class="hover-btn">
                                                            <img src = "<?php echo check_admin_image(UPLOAD_PATH . "event/seo_image/" . $seo_og_image); ?>" class = "img-thumbnail mr-10 mb-10 height-100" width = "100px"/>
                                                            <a class="btn-danger btn-floating btn-sm red-gradient waves-effect waves-light remove-btn" onclick="delete_event_seo_image(this);" data-url="<?php echo UPLOAD_PATH . "event/seo_image/" . $seo_og_image; ?>" data-id="<?php echo $id; ?>"><i class="fa fa-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <button class="btn btn-kb-color btn-rounded prevBtn-2 float-left" type="button"><?php echo translate('previous'); ?></button>
                                        <button class="btn btn-success btn-rounded float-right" type="submit"><?php echo translate('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <!--/Form with header-->
                        </div>
                        <!--Card-->
                    </div>
                    <!-- End Col -->
                </div>
                <!--Row-->
            </section>
            <!-- End Login-->
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo isset($location_api_key) ? $location_api_key : ''; ?>&libraries=places&callback=initAutocomplete" async></script>
<script src="<?php echo $this->config->item('admin_js_url'); ?>module/event.js" type="text/javascript"></script>
<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>
