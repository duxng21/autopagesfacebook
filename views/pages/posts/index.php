<?php require_once(PATH_ROOT . '/views/layouts/header.php') ?>
<?php require_once(PATH_ROOT . '/views/layouts/menu.php') ?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section>
                <a href="?act=post-add" class="btn btn-relief-primary mr-1 mb-1 waves-effect waves-light"><i class="feather icon-plus-square"></i> Thêm</a>
                <?php show_status(); ?>
            </section>
            <section id="basic-examples">
                <div class="row match-height">
                    <?php foreach ($posts as $post): ?>
                        <div class="col-xl-3 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <?php
                                        $mediaPath = $post['media_path'];
                                        $mediaType = $post['media_type'];
                                        $imgDefault = BASE_URL . '/views/duxng_theme/app-assets/images/pages/content-img-2.jpg';

                                        // Nếu media_path là JSON (nhiều ảnh)
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

                                        <h5 class="mt-1"><?= htmlspecialchars($post['content']) ?></h5>
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
                                            <a href="#" class="btn gradient-light-primary text-white waves-effect waves-light">Đăng lại</a>
                                            <a href="#" class="btn btn-outline-primary waves-effect waves-light">Xoá bài</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>