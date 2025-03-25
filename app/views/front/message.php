<?php include VIEWPATH . 'front/header.php'; ?>
<link href="<?php echo $this->config->item('admin_css_url'); ?>module/chat-box.css" rel="stylesheet" type="text/css"/>
<div class="dashboard-body">
    <!-- Start Content -->
    <div class="content">
        <!-- Start Container -->
        <div class="container">
            <section class="form-light px-2 sm-margin-b-20">
                <!-- Row -->
                <div class="row">
                    <?php $this->load->view('message'); ?>
                    <div class="col-md-4 msg-list">
                        <div class="table-responsive" style="height: 500px;border: 1px solid #ccc;">
                            <table class="table mdl-data-table">
                                <?php
                                if (isset($vendor_list) && count($vendor_list) > 0) {
                                    foreach ($vendor_list as $vlist_key => $vlist_value) {
                                        $unread = check_unread_msg($vlist_value['id'], $vlist_value['vendor_id'], $vlist_value['customer_id']);
                                        ?>
                                        <tr>
                                            <th class="text-left font-bold dark-grey-text <?php echo isset($msg_vendor_data) && $vlist_value['vendor_id'] == $msg_vendor_data[0]['id'] ? 'active' : ''; ?>"> 
                                                <a href="<?php echo base_url('message/' . $vlist_value['vendor_id']); ?>" style="display: inline-block;width: 100%;">
                                                    <img class="rounded-circle position-r" style="width:40px; height: 40px; margin-top: 5px;border: 1px solid #ccc;padding: 4px;" src="<?php echo check_admin_image(UPLOAD_PATH . "profiles/" . $vlist_value['profile_image']); ?>">
                                                    <span class="user-list-text"><?php echo ucfirst($vlist_value['first_name']) . " " . $vlist_value['last_name']; ?></span>   
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
                    <?php if (isset($msg_vendor_data) && count($msg_vendor_data) > 0) { ?>
                        <div class="col-md-8">
                            <div class="header pt-3 bg-color-base">
                                <div class="d-flex">
                                    <h3 class="white-text mb-3 font-bold pull-left pl-10"> 
                                        <img class="rounded-circle" style="width:40px; height: 40px;" src="<?php echo check_admin_image(UPLOAD_PATH . "profiles/" . $msg_vendor_data[0]['profile_image']); ?>">
                                        <span class="user-text"><?php echo ucfirst($msg_vendor_data[0]['first_name']) . " " . ucfirst($msg_vendor_data[0]['last_name']); ?></span>                               
                                    </h3>
                                </div>
                            </div>
                            <div class="frame" style="border:1px solid #ccc;height: 426px;">
                                <form action="<?php echo base_url('message-action'); ?>" name="chat_form" id="chat_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
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
                                                        if ($msg_vendor_data[0]['id'] == $msg_value['to_id'] && $msg_value['chat_type'] == 'C') {
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
                                    <input name="msg_to_id" value="<?php echo $msg_vendor_data[0]['id']; ?>" id="msg_to_id" type="hidden">
                                    <div class="macro pl-20 chat-box">                        
                                        <div class="form-group">
                                            <input class="form-control pull-left w-89" name="message" required="true" placeholder="Type a message.." style="background:whitesmoke !important;" autofocus/>
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
<?php include VIEWPATH . 'front/footer.php'; ?>