<footer class="page-footer pt-0 lr-page">
    <!-- Copyright -->
    <div class="footer-copyright">
        <div class="dashboard-body pt-0 text-center">
            <div class="container-fluid">
                <strong>&copy;</strong> <?php echo get_CompanyName() . " " . date("Y"); ?>
            </div>
        </div>
    </div>
    <!-- Copyright -->
</footer>
<?php include VIEWPATH . 'admin/js.php'; ?>
<?php
$file = dirname(BASEPATH) . "/install/";
if (is_dir($file)) {
    ?>
    <script>
        toastr.error('<?php echo translate('delete_install'); ?>');
    </script>
<?php } ?>
<script>
    $(document).ready(function () {
         $(".bdatepicker").datepicker({
        autoclose: true
    });
        $('#example').DataTable({
            columnDefs: [
                {
                    targets: [0, 1, 2],
                    className: 'mdl-data-table__cell--non-numeric'
                }
            ]
        });
    });
</script>
</body>
</html>