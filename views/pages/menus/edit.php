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
                                <h4 class="card-title">Sửa danh mục #<?= (int)$menu['id'] ?></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-vertical" method="POST" action="?act=menu-edit">
                                        <input type="hidden" name="id" value="<?= (int)$menu['id'] ?>">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Tên danh mục</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="name"
                                                            placeholder="Nhập tên danh mục..."
                                                            value="<?= htmlspecialchars($menu['name']) ?>"
                                                        >
                                                    </div>
                                                    <?php show_status(); ?>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Sửa</button>
                                                    <a href="?act=menus" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Quay lại</a>
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

<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>