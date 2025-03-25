<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    $login_id = $this->session->userdata('Vendor_ID');
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    $login_id = $this->session->userdata('ADMIN_ID');
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
?>
<link href="<?php echo $this->config->item('admin_css_url'); ?>module/chat-box.css" rel="stylesheet" type="text/css"/>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container-fluid ">
            <section class="form-light px-2 sm-margin-b-20">
                <!-- Row -->
                <div class="row">
                    <?php $this->load->view('message'); ?>
                    <div class="col-md-4 msg-list">
                        <div class="table-responsive" style="height: 500px;border: 1px solid #ccc;">
                            <table class="table mdl-data-table">
                                <?php
                                if (isset($customer_list) && count($customer_list) > 0) {
                                    foreach ($customer_list as $clist_value) {
                                        $unread = get_unread_msg($clist_value['id'], $login_id, $clist_value['customer_id']);
                                        ?>
                                        <tr>
                                            <th class="text-left font-bold dark-grey-text <?php echo isset($msg_customer_data) && $clist_value['vendor_id'] == $msg_customer_data[0]['id'] ? 'active' : ''; ?>"> 
                                                <a href="<?php echo base_url($folder_name . '/message/' . $clist_value['customer_id']); ?>" style="display: inline-block;width: 100%;">
                                                    <img class="rounded-circle position-r" style="width:40px; height: 40px; margin-top: 5px;border: 1px solid #ccc;padding: 4px;" src="<?php echo check_admin_image(UPLOAD_PATH . "profiles/" . $clist_value['profile_image']); ?>">
                                                    <span class="user-list-text"><?php echo ucfirst($clist_value['first_name']) . " " . $clist_value['last_name']; ?></span>   
                                                    <?php if ($unread > 0) { ?>
                                                        <div class="un-read"><?php echo $unread; ?></div>
                                                    <?php } ?>
                                                </a>
                                            </th>
                                        </tr>
                                    <?php }
                                    ?>
                                <?php } else { ?>
                                    <h2 class="no-found"><?php echo translate('no_found'); ?></h2>
                                <?php }
                                ?>
                            </table>
                        </div>
                    </div>
                    <?php if (isset($msg_customer_data) && count($msg_customer_data) > 0) { ?>
                        <div class="col-md-8">
                            <div class="header pt-3 bg-color-base">
                                <div class="d-flex">
                                    <h3 class="white-text mb-3 font-bold pull-left pl-10"> 
                                        <img class="rounded-circle" style="width:40px; height: 40px;" src="<?php echo check_admin_image(UPLOAD_PATH . "profiles/" . $msg_customer_data[0]['profile_image']); ?>">
                                        <span class="user-text"><?php echo ucfirst($msg_customer_data[0]['first_name']) . " " . ucfirst($msg_customer_data[0]['last_name']); ?></span>                               
                                    </h3>
                                </div>
                            </div>
                            <div class="frame" style="border:1px solid #ccc;height: 426px;">
                                <form action="<?php echo base_url($folder_name . '/message-action'); ?>" name="chat_form" id="chat_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                    <ul class="list-inline px-3" style="height: 338px;overflow-x: auto;" id="scroll-auto">
                                        <?php
                                        if (isset($msg_group_list) && count($msg_group_list) > 0) {
                                            foreach ($msg_group_list as $group_value) {
                                                $get_message = get_message($group_value['date'], $group_value['chat_id']);
                                                if (isset($get_message) && count($get_message) > 0) {
                                                    ?>
                                                    <li class="text-center"><small class="alert alert-info chat-date"><?php echo date('F d ,Y', strtotime($group_value['date'])); ?></small></li>
                                                    <?php
                                                    foreach ($get_message as $msg_value) {
                                                        if ($msg_customer_data[0]['id'] == $msg_value['to_id'] && $msg_value['chat_type'] == 'NC') {
                                                            ?>
                                                            <li class="text-right">
                                                                <div class="msg-reply">
                                                                    <div><?php echo $msg_value['message']; ?></div>
                                                                    <div style="font-size: 12px;" class="text-right"><?php echo date('h:i a', strtotime($msg_value['created_on'])); ?><i class="fa pl-10 <?php echo isset($msg_value['created_on']) && $msg_value['msg_read'] == 'Y' ? 'fa-check-circle text-info' : "fa-check"; ?>"></i></div>
                                                                </div>
                                                            </li>
                                                        <?php } else { ?>
                                                            <li class="text-left">
                                                                <div class="msg-reply">
                                                                    <div><?php echo $msg_value['message']; ?></div>
                                                                    <div style="font-size: 12px;" class="text-right"><?php echo date('h:i a', strtotime($msg_value['created_on'])); ?></div>
                                                                </div>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <hr>
                                    <input name="msg_to_id" value="<?php echo $msg_customer_data[0]['id']; ?>" id="msg_to_id" type="hidden">
                                    <div class="macro pl-20 chat-box">                        
                                        <div class="form-group">
                                            <input class="form-control pull-left w-86" name="message" required="true" placeholder="Type a message.." style="background:whitesmoke !important;" autofocus/>
                                            <button type="submit" class="btn purple-gradient btn-rounded waves-light btn-sm pull-right waves-effect waves-light"><i class="fa fa-paper-plane-o" ></i></button>
                                        </div>
                                    </div>
                                </form>                            
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!--Row-->
            </section>
        </div>
    </div>   
</div>
<script>
    $('#chat_form').submit(function () {
        if ($('#chat_form').valid()) {
            $('.loadingmessage').show();
        }
    });
    window.onload = function () {
        var objDiv = document.getElementById("scroll-auto");
        objDiv.scrollTop = objDiv.scrollHeight;
    }
</script>
<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>