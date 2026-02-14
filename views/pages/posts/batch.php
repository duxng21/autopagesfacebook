<?php require_once(PATH_ROOT . '/views/layouts/header.php') ?>
<?php require_once(PATH_ROOT . '/views/layouts/menu.php') ?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Đăng bài hàng loạt</h4>
                    </div>
                    <div class="card-body">
                        <?php show_status(); ?>

                        <form method="POST" action="?act=posts-batch">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Chọn pages đăng</label>
                                        <select class="select2 form-control" name="page_ids[]" multiple="multiple" required>
                                            <?php foreach ($pages as $p): ?>
                                                <option value="<?= htmlspecialchars($p['page_id']) ?>">
                                                    <?= htmlspecialchars($p['page_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Từ số bài (id posts)</label>
                                        <input type="number" class="form-control" name="from_no" min="1" required>
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>Đến số bài (id posts)</label>
                                        <input type="number" class="form-control" name="to_no" min="1" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu</label>
                                        <input type="date" class="form-control" name="start_date" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Khung giờ đăng</label>
                                        <input type="text" class="form-control" name="time_slots" placeholder="08:45,12:00,18:00,21:00" required>
                                        <small class="text-muted">Nhập dạng: 8,12,18 hoặc 8:45,12:00...</small>
                                    </div>
                                </div>

                                <div class="col-12 mt-1">
                                    <button type="submit" class="btn btn-primary">Lên lịch</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <section class="mt-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Danh sách batch gần đây</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Batch ID</th>
                                    <th>Tổng</th>
                                    <th>Queued</th>
                                    <th>Processing</th>
                                    <th>Posted</th>
                                    <th>Failed</th>
                                    <th>Khoảng lịch</th>
                                    <th>Tạo lúc</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($batchList)): ?>
                                    <?php foreach ($batchList as $b): ?>
                                        <tr>
                                            <td><code><?= htmlspecialchars($b['batch_id']) ?></code></td>
                                            <td><?= (int)$b['total_jobs'] ?></td>
                                            <td><?= (int)$b['queued_jobs'] ?></td>
                                            <td><?= (int)$b['processing_jobs'] ?></td>
                                            <td><?= (int)$b['posted_jobs'] ?></td>
                                            <td><?= (int)$b['failed_jobs'] ?></td>
                                            <td><?= htmlspecialchars($b['first_schedule'] . ' -> ' . $b['last_schedule']) ?></td>
                                            <td><?= htmlspecialchars($b['created_at']) ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary"
                                                   href="?act=posts-batch&view_batch_id=<?= urlencode($b['batch_id']) ?>">
                                                    Xem
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Chưa có batch nào.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <?php if (!empty($viewBatchId)): ?>
                <section class="mt-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Chi tiết batch: <code><?= htmlspecialchars($viewBatchId) ?></code></h4>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Source No</th>
                                        <th>Page</th>
                                        <th>Lịch đăng</th>
                                        <th>Trạng thái</th>
                                        <th>FB Post ID</th>
                                        <th>Lỗi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($batchItems)): ?>
                                        <?php foreach ($batchItems as $it): ?>
                                            <tr>
                                                <td><?= (int)$it['id'] ?></td>
                                                <td><?= (int)$it['source_no'] ?></td>
                                                <td><?= htmlspecialchars($it['page_id']) ?></td>
                                                <td><?= htmlspecialchars($it['scheduled_at']) ?></td>

                                                <?php
                                                $status = $it['status'] ?? '';
                                                $badgeClass = match ($status) {
                                                    'posted' => 'badge-success',
                                                    'queued' => 'badge-primary',
                                                    'processing' => 'badge-warning',
                                                    'failed' => 'badge-danger',
                                                    'cancelled' => 'badge-secondary',
                                                    default => 'badge-light'
                                                };
                                                ?>
                                                <td>
                                                    <span class="badge badge-glow <?= $badgeClass ?>">
                                                        <?= htmlspecialchars($status) ?>
                                                    </span>
                                                </td>

                                                <td><?= htmlspecialchars($it['fb_post_id'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($it['last_error'] ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Batch này chưa có dữ liệu.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>