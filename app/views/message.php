<?php
if ($this->session->flashdata('msg_class') == "success") {
    ?>
    <div class="alert alert-success alert-message">
        <?php echo $this->session->flashdata('msg'); ?>
    </div>

    <?php
} else if ($this->session->flashdata('msg_class') == "failure") {
    ?>
    <div class="alert alert-danger alert-message">
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
    <?php
}
?>
<script>
    window.setTimeout(function () {
        $(".alert-message").fadeTo(1500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);
</script>  