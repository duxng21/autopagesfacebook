    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <!-- Không chỉnh sửa phần này để tôn trọng quyền tác giả -->
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2026<a class="text-bold-800 grey darken-2" href="https://www.facebook.com/duxng0201" target="_blank">Hoàng Việt Dũng,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i class="feather icon-heart pink"></i></span>
        <!-- Không chỉnh sửa phần này để tôn trọng quyền tác giả -->
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/extensions/tether.min.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/extensions/dropzone.min.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/tables/datatable/dataTables.select.min.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/core/app-menu.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/core/app.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/scripts/components.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/scripts/pages/dashboard-analytics.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/scripts/ui/data-list-view.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- END: Page JS-->
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery && $('.select2').length) {
                $('.select2').select2({
                    placeholder: 'Lựa chọn pages ở đây...'
                });
            }
        });
    </script>

</body>
<!-- END: Body-->

</html>