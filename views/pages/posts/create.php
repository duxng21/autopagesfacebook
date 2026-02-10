<?php require_once(PATH_ROOT . '/views/layouts/header.php') ?>
<?php require_once(PATH_ROOT . '/views/layouts/menu.php') ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>

        <div class="content-body">
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Đăng bài mới</h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-vertical"
                                        method="POST"
                                        enctype="multipart/form-data">

                                        <div class="form-body">
                                            <div class="row">

                                                <!-- Nội dung -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Nội dung bài viết</label>
                                                        <textarea class="form-control"
                                                            name="content"
                                                            rows="3"
                                                            placeholder="Viết nội dung ở đây..."></textarea>
                                                    </div>
                                                </div>

                                                <!-- Upload media -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Upload ảnh / video</label>
                                                        <div class="custom-file">
                                                            <input type="file"
                                                                class="custom-file-input"
                                                                name="media[]"
                                                                id="mediaFile"
                                                                multiple>
                                                            <label class="custom-file-label"
                                                                for="mediaFile">Chọn file</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Switch lên lịch -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch custom-control-inline">
                                                            <input type="checkbox"
                                                                class="custom-control-input"
                                                                id="scheduleSwitch"
                                                                name="is_scheduled">
                                                            <label class="custom-control-label"
                                                                for="scheduleSwitch"></label>
                                                            <span class="switch-label">
                                                                Lên lịch đăng bài
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Thời gian lên lịch -->
                                                <div class="col-12" id="scheduleBox" style="display:none;">
                                                    <div class="form-group">
                                                        <label>Thời gian đăng</label>
                                                        <input type="datetime-local"
                                                            name="scheduled_at"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <!-- Alert -->
                                                <div class="col-12">
                                                    <?php show_status(); ?>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="col-12">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-1 mb-1 waves-effect waves-light">
                                                        Thực hiện
                                                    </button>
                                                    <button type="reset"
                                                        class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">
                                                        Đặt lại
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const switchEl = document.getElementById('scheduleSwitch');
    const box = document.getElementById('scheduleBox');

    switchEl.addEventListener('change', function () {
        box.style.display = this.checked ? 'block' : 'none';
    });

    const fileInput = document.getElementById('mediaFile');
    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            this.nextElementSibling.innerText =
                this.files.length === 1
                    ? this.files[0].name
                    : this.files.length + ' files được chọn';
        }
    });
});
</script>
<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>