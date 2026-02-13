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
                <div class="row align-items-end">
                    <div class="col-md-11 col-12">
                        <div class="form-group mb-1">
                            <label>Chọn page để thống kê</label>
                            <select class="select2 form-control" name="menu_id">
                                <option value=""></option>
                                <option value="123">Duxng</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1 col-12 text-md-right">
                        <div class="form-group mb-1">
                            <label class="d-block invisible">.</label>
                            <button type="button" class="btn btn-relief-light waves-effect waves-light">
                                Xoá lọc
                            </button>
                        </div>
                    </div>
                </div>
                <div class="alert alert-primary mb-2" role="alert">
                                            <strong>Lọc thành công:</strong> Đây là thống kê của pages [name].
                                        </div>
            </section>
            <!-- Statistics card section start -->
            <section id="statistics-card">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0">10</h2>
                                    <p>Bài đã đăng</p>
                                </div>
                                <div class="avatar bg-rgba-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-check-circle text-primary font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0">20</h2>
                                    <p>Đang lên lịch</p>
                                </div>
                                <div class="avatar bg-rgba-success p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-clock text-success font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0">Tình yêu</h2>
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
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0">2</h2>
                                    <p>Bài đăng hàng loạt</p>
                                </div>
                                <div class="avatar bg-rgba-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-list text-warning font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Statistics Card section end-->
        </div>
    </div>
</div>
<!-- END: Content-->

<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>