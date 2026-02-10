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
            </section>
            <section id="basic-examples">
                <div class="row match-height">
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <img class="card-img img-fluid mb-1 post-media" src="<?= BASE_URL ?>/views/duxng_theme/app-assets/images/pages/content-img-2.jpg" alt="Card image cap">
                                    <h5 class="mt-1">Nội dung bài viết</h5>
                                    <div class="card-btns d-flex justify-content-between mt-2">
                                        <button class="btn bg-gradient-success mr-1 mb-1 waves-effect waves-light btn-sm">Đã đăng</button>
                                        <button class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light btn-sm">Hình ảnh</button>
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
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <img class="card-img img-fluid mb-1 post-media" src="<?= BASE_URL ?>/views/duxng_theme/app-assets/images/pages/content-img-2.jpg" alt="Card image cap">
                                    <h5 class="mt-1">Nội dung bài viết</h5>
                                    <div class="card-btns d-flex justify-content-between mt-2">
                                        <button class="btn bg-gradient-success mr-1 mb-1 waves-effect waves-light btn-sm">Đã đăng</button>
                                        <button class="btn bg-gradient-danger mr-1 mb-1 waves-effect waves-light btn-sm">Video</button>
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
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <video class="card-img img-fluid mb-1 post-media" controls preload="metadata">
                                        <source src="<?= BASE_URL ?>/uploads/video1.mp4" type="video/mp4">
                                    </video>
                                    <h5 class="mt-1">Nội dung bài viết</h5>
                                    <div class="card-btns d-flex justify-content-between mt-2">
                                        <button class="btn bg-gradient-dark mr-1 mb-1 waves-effect waves-light btn-sm">10/02/2026 - 12:36</button>
                                        <button class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light btn-sm">Hình ảnh</button>
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
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->

<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>