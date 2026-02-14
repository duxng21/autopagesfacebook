<?php require_once(PATH_ROOT . '/views/layouts/header.php') ?>
<?php require_once(PATH_ROOT . '/views/layouts/menu.php') ?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>

        <div class="content-body">
            <section>
                <form method="GET">
                    <input type="hidden" name="act" value="/">

                    <div class="row align-items-end">
                        <div class="col-md-11 col-12">
                            <div class="form-group mb-1">
                                <label>Chọn page để thống kê</label>
                                <select class="select2 form-control" name="page_id" onchange="this.form.submit()">
                                    <option value="">Tất cả pages</option>
                                    <?php foreach (($pages ?? []) as $p): ?>
                                        <option value="<?= htmlspecialchars($p['page_id']) ?>"
                                            <?= (($selectedPageId ?? '') === ($p['page_id'] ?? '')) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['page_name'] ?? '') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1 col-12 text-md-right">
                            <div class="form-group mb-1">
                                <label class="d-block invisible">.</label>
                                <a href="?act=/" class="btn btn-relief-light waves-effect waves-light">Xoá lọc</a>
                            </div>
                        </div>
                    </div>
                </form>
                <?php if (!empty($selectedPageId)): ?>
                    <div class="alert alert-primary mb-2" role="alert">
                        <strong>Lọc thành công:</strong> Đây là thống kê của page
                        [<?= htmlspecialchars($selectedPageName !== '' ? $selectedPageName : $selectedPageId) ?>].
                    </div>
                <?php endif; ?>
            </section>

            <section id="statistics-card">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?= (int)($stats['posted'] ?? 0) ?></h2>
                                    <p>Bài đã đăng</p>
                                </div>
                                <div class="avatar bg-rgba-success p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-check-circle text-success font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?= (int)($stats['scheduled'] ?? 0) ?></h2>
                                    <p>Đang lên lịch</p>
                                </div>
                                <div class="avatar bg-rgba-dark p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-clock text-dark font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?= htmlspecialchars($stats['top_menu'] ?? 'Chưa có dữ liệu') ?></h2>
                                    <p>Chủ đề được đăng nhiều</p>
                                </div>
                                <div class="avatar bg-rgba-danger p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-trending-up text-danger font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-1">

                <div class="alert alert-dark mb-2" role="alert">
                    <?php if (!empty($selectedPageId)): ?>
                        <strong>Đăng hàng loạt:</strong> Thống kê theo page
                        [<?= htmlspecialchars($selectedPageName !== '' ? $selectedPageName : $selectedPageId) ?>].
                    <?php else: ?>
                        <strong>Đăng hàng loạt:</strong> Thống kê toàn bộ hệ thống.
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?= (int)($stats['batch_total'] ?? 0) ?></h2>
                                    <p>Tổng bài hàng loạt</p>
                                </div>
                                <div class="avatar bg-rgba-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-list text-warning font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?= (int)($stats['batch_posted'] ?? 0) ?></h2>
                                    <p>Đã đăng (batch)</p>
                                </div>
                                <div class="avatar bg-rgba-success p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-check-circle text-success font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?= (int)($stats['batch_queued'] ?? 0) ?></h2>
                                    <p>Đang lên lịch (batch)</p>
                                </div>
                                <div class="avatar bg-rgba-dark p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-clock text-dark font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0"><?= (int)($stats['batch_failed'] ?? 0) ?></h2>
                                    <p>Đăng thất bại (batch)</p>
                                </div>
                                <div class="avatar bg-rgba-danger p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-alert-triangle text-danger font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($selectedPageId)): ?>
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0"><?= htmlspecialchars($stats['batch_top_menu'] ?? 'Chưa có dữ liệu') ?></h2>
                                        <p>Chủ đề batch được đăng nhiều</p>
                                    </div>
                                    <div class="avatar bg-rgba-info p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-trending-up text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0"><?= htmlspecialchars($stats['batch_source_range'] ?? 'Chưa có dữ liệu') ?></h2>
                                        <p>Số thứ tự đã đăng (batch)</p>
                                    </div>
                                    <div class="avatar bg-rgba-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-hash text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </section>
        </div>
    </div>
</div>

<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>