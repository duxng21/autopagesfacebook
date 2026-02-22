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
                                    <form id="postCreateForm" class="form form-vertical" method="POST" enctype="multipart/form-data">
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

                                                <!-- Chọn pages (Select2 Multiple) -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Chọn Pages đăng bài</label>
                                                        <select class="select2 form-control" name="page_ids[]" multiple="multiple">
                                                            <?php foreach ($pages as $p): ?>
                                                                <option value="<?= htmlspecialchars($p['page_id']) ?>">
                                                                    <?= htmlspecialchars($p['page_name']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Danh mục</label>
                                                        <select class="select2 form-control" name="menu_id">
                                                            <option value="">-- Chọn danh mục --</option>
                                                            <?php foreach ($menus as $m): ?>
                                                                <option value="<?= (int)$m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Switch lưu nháp -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch custom-control-inline">
                                                            <input type="checkbox"
                                                                class="custom-control-input"
                                                                id="draftSwitch"
                                                                name="is_draft">
                                                            <label class="custom-control-label"
                                                                for="draftSwitch"></label>
                                                            <span class="switch-label text-warning font-weight-bold">
                                                                Lưu nháp (Không đăng lên FB)
                                                            </span>
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
                                                    <div id="postCreateProcessing" class="alert alert-info" style="display:none;">
                                                        Đang xử lý, vui lòng chờ và không reload lại trang...
                                                    </div>
                                                    <div id="postCreateResult" style="display:none;"></div>
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
document.addEventListener('DOMContentLoaded', function() {
    const switchEl = document.getElementById('scheduleSwitch');
    const draftSwitchEl = document.getElementById('draftSwitch');
    const box = document.getElementById('scheduleBox');

    if (switchEl && box) {
        switchEl.addEventListener('change', function() {
            box.style.display = this.checked ? 'block' : 'none';
            if (this.checked && draftSwitchEl) {
                draftSwitchEl.checked = false; // Tắt lưu nháp nếu bật lên lịch
            }
        });
    }

    if (draftSwitchEl) {
        draftSwitchEl.addEventListener('change', function() {
            if (this.checked && switchEl) {
                switchEl.checked = false; // Tắt lên lịch nếu lưu nháp
                box.style.display = 'none';
            }
        });
    }

    const fileInput = document.getElementById('mediaFile');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                this.nextElementSibling.innerText =
                    this.files.length === 1
                        ? this.files[0].name
                        : this.files.length + ' files được chọn';
            }
        });
    }

    const form = document.getElementById('postCreateForm');
    const processing = document.getElementById('postCreateProcessing');
    const result = document.getElementById('postCreateResult');
    const submitBtn = form ? form.querySelector('button[type="submit"]') : null;

    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (processing) processing.style.display = 'block';
        if (result) {
            result.style.display = 'none';
            result.className = '';
            result.innerHTML = '';
        }
        if (submitBtn) submitBtn.disabled = true;

        try {
            const formData = new FormData(form);
            const res = await fetch('?act=post-add', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await res.json();

            if (processing) processing.style.display = 'none';
            if (submitBtn) submitBtn.disabled = false;

            if (!result) return;
            result.style.display = 'block';
            result.className = 'alert ' + (data.ok ? 'alert-success' : 'alert-danger');
            result.innerHTML = data.message || (data.ok ? 'Thành công' : 'Thất bại');

            if (data.ok) {
                form.reset();
                if (box) box.style.display = 'none';
            }
        } catch (err) {
            if (processing) processing.style.display = 'none';
            if (submitBtn) submitBtn.disabled = false;

            if (result) {
                result.style.display = 'block';
                result.className = 'alert alert-danger';
                result.innerHTML = 'Có lỗi xảy ra, vui lòng thử lại.';
            }
        }
    });
});
</script>
<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>