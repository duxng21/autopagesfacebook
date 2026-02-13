<?php 
require_once(PATH_ROOT . '/views/layouts/header.php');
require_once(PATH_ROOT . '/views/layouts/menu.php');
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
$pageModel = new FbPageModel();
$allPages = $pageModel->getAll();
$menuNameById = [];
foreach (($menus ?? []) as $m) {
    $menuNameById[(int)$m['id']] = $m['name'];
}
?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="mb-1">
                <div class="d-flex align-items-end justify-content-between flex-wrap">
                    <a href="?act=post-add" class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light">
                        <i class="feather icon-plus-square"></i> Thêm
                    </a>

                    <form method="GET" id="postFilterForm" class="d-flex align-items-end mb-1">
                        <input type="hidden" name="act" value="posts">

                        <div class="form-group mb-0 mr-1" style="min-width: 260px;">
                            <label class="mb-25">Lọc danh mục</label>
                            <select class="select2 form-control" id="menuFilterSelect" name="menu_ids[]" multiple="multiple">
                                <?php foreach ($menus as $m): ?>
                                    <option value="<?= (int)$m['id'] ?>"
                                        <?= in_array((int)$m['id'], $selectedMenuIds ?? [], true) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($m['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <?php show_status(); ?>
            </section>

            <section id="basic-examples">
                <div class="row match-height">
                    <?php foreach ($posts as $post): ?>
                        <div class="col-xl-3 col-md-6 col-sm-12">
                            <div class="card post-card-wrap">
                                <span class="post-id-badge">#<?= (int)$post['id'] ?></span>
                                <a href="?act=post-edit&id=<?= (int)$post['id'] ?>" class="post-edit-btn" title="Sửa bài">
                                    <i class="feather icon-edit"></i>
                                </a>
                                <div class="card-content">
                                    <div class="card-body">
                                        <?php
                                        $mediaPath = $post['media_path'];
                                        $mediaType = $post['media_type'];
                                        $imgDefault = BASE_URL . '/views/duxng_theme/app-assets/images/pages/content-img-2.jpg';

                                        $paths = null;
                                        if ($mediaPath && is_string($mediaPath) && $mediaPath[0] === '[') {
                                            $paths = json_decode($mediaPath, true);
                                        }

                                        if ($mediaType === 'video' && !empty($mediaPath)):
                                        ?>
                                            <video class="card-img img-fluid mb-1 post-media" controls preload="metadata">
                                                <source src="<?= BASE_URL ?>/<?= htmlspecialchars($mediaPath) ?>" type="video/mp4">
                                            </video>
                                        <?php elseif ($mediaType === 'image' && !empty($mediaPath)): ?>
                                            <img class="card-img img-fluid mb-1 post-media"
                                                src="<?= BASE_URL ?>/<?= htmlspecialchars($paths ? $paths[0] : $mediaPath) ?>" alt="Media">
                                        <?php else: ?>
                                            <img class="card-img img-fluid mb-1 post-media" src="<?= $imgDefault ?>" alt="Default">
                                        <?php endif; ?>

                                        <?php
                                        $text = $post['content'];
                                        if (mb_strlen($text) > 120) $text = mb_substr($text, 0, 38) . '...';
                                        ?>
                                        <h5 class="mt-1"><?= htmlspecialchars($text) ?></h5>

                                        <div class="card-btns d-flex justify-content-between mt-2">
                                            <?php if ($post['status'] === 'posted'): ?>
                                                <button class="btn bg-gradient-success mr-1 mb-1 waves-effect waves-light btn-sm">Đã đăng</button>
                                            <?php elseif ($post['status'] === 'scheduled'): ?>
                                                <button class="btn bg-gradient-dark mr-1 mb-1 waves-effect waves-light btn-sm">
                                                    <?= htmlspecialchars($post['scheduled_at']) ?>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn bg-gradient-warning mr-1 mb-1 waves-effect waves-light btn-sm">Nháp</button>
                                            <?php endif; ?>
                                            <?php $menuLabel = $menuNameById[(int)($post['menu_id'] ?? 0)] ?? 'Chưa phân loại'; ?>
                                                <button class="btn bg-gradient-warning mr-1 mb-1 waves-effect waves-light btn-sm">
                                                    <?= htmlspecialchars($menuLabel) ?>
                                                </button>
                                            <?php if ($post['media_type'] === 'video'): ?>
                                                <button class="btn bg-gradient-danger mr-1 mb-1 waves-effect waves-light btn-sm">Video</button>
                                            <?php elseif ($post['media_type'] === 'image'): ?>
                                                <button class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light btn-sm">Hình ảnh</button>
                                            <?php else: ?>
                                                <button class="btn bg-gradient-secondary mr-1 mb-1 waves-effect waves-light btn-sm">Text</button>
                                            <?php endif; ?>
                                        </div>

                                        <hr class="my-1">

                                        <div class="card-btns d-flex justify-content-between mt-2">
                                            <button type="button"
                                                class="btn gradient-light-primary text-white waves-effect waves-light"
                                                data-toggle="modal"
                                                data-target="#repostModal<?= (int)$post['id'] ?>">
                                                Đăng lại
                                            </button>

                                            <form method="POST" action="?act=post-delete" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
                                                <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
                                                <button type="submit" class="btn btn-outline-primary waves-effect waves-light"
                                                    onclick="return confirm('Xoá bài này trên Facebook?');">
                                                    Xoá bài
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal ngay sau card -->
                            <div class="modal fade" id="repostModal<?= (int)$post['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="?act=post-repost">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Chọn pages để đăng lại</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
                                                <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
                                                <div class="form-group">
                                                    <label>Pages</label>
                                                    <select class="select2 form-control" name="page_ids[]" multiple="multiple">
                                                        <?php foreach ($allPages as $pg): ?>
                                                            <option value="<?= htmlspecialchars($pg['page_id']) ?>">
                                                                <?= htmlspecialchars($pg['page_name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-primary">Đăng lại</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End modal -->

                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (!empty($totalPages) && $totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-2">
                            <?php
                            $baseQuery = ['act' => 'posts'];
                            if (!empty($selectedMenuIds)) {
                                $baseQuery['menu_ids'] = $selectedMenuIds;
                            }
                            ?>
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($baseQuery, ['page' => max(1, $page - 1)])) ?>">«</a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($baseQuery, ['page' => $i])) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($baseQuery, ['page' => min($totalPages, $page + 1)])) ?>">»</a>
                            </li>

                        </ul>
                    </nav>
                <?php endif; ?>

            </section>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>