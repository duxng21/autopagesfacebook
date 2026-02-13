<?php require_once(PATH_ROOT . '/views/layouts/header.php') ?>
<?php require_once(PATH_ROOT . '/views/layouts/menu.php') ?>
<?php
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
$scheduledValue = '';
if (!empty($post['scheduled_at'])) {
    $scheduledValue = str_replace(' ', 'T', substr($post['scheduled_at'], 0, 16));
}
$isPosted = (($post['status'] ?? '') === 'posted');
?>
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
                                <h4 class="card-title">Sửa bài #<?= (int)$post['id'] ?></h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-vertical" method="POST" action="?act=post-edit">
                                        <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
                                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Nội dung bài viết</label>
                                                        <textarea class="form-control" name="content" rows="4" placeholder="Nhập nội dung..."><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Danh mục</label>
                                                        <select class="select2 form-control" name="menu_id">
                                                            <option value="">-- Chọn danh mục --</option>
                                                            <?php foreach ($menus as $m): ?>
                                                                <option value="<?= (int)$m['id'] ?>" <?= ((int)($post['menu_id'] ?? 0) === (int)$m['id']) ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($m['name']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="alert alert-warning">
                                                        API chỉ hỗ trợ đổi nội dung và danh mục, muốn thay ảnh/video vui lòng xoá và đăng lại.
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch custom-control-inline">
                                                            <input type="checkbox"
                                                                class="custom-control-input"
                                                                id="scheduleSwitch"
                                                                name="is_scheduled"
                                                                <?= ($post['status'] === 'scheduled') ? 'checked' : '' ?>
                                                                <?= $isPosted ? 'disabled' : '' ?>>
                                                            <label class="custom-control-label" for="scheduleSwitch"></label>
                                                            <span class="switch-label">Lên lịch đăng bài</span>
                                                        </div>
                                                        <?php if ($isPosted): ?>
                                                            <small class="text-muted d-block mt-25">
                                                                Bài đã đăng thì không lên lịch được, nếu muốn hãy xoá và lên lịch.
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="col-12" id="scheduleBox" style="<?= ($post['status'] === 'scheduled') ? '' : 'display:none;' ?>">
                                                    <div class="form-group">
                                                        <label>Thời gian đăng</label>
                                                        <input type="datetime-local" name="scheduled_at" class="form-control" value="<?= htmlspecialchars($scheduledValue) ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <?php show_status(); ?>
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Cập nhật</button>
                                                    <a href="?act=posts" class="btn btn-outline-secondary mr-1 mb-1">Quay lại</a>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const switchEl = document.getElementById('scheduleSwitch');
    const box = document.getElementById('scheduleBox');
    const isPosted = <?= $isPosted ? 'true' : 'false' ?>;

    if (!switchEl || !box || isPosted) return;

    switchEl.addEventListener('change', function () {
        box.style.display = this.checked ? 'block' : 'none';
    });
});
</script>
<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>