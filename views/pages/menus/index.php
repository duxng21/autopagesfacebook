<?php require_once(PATH_ROOT . '/views/layouts/header.php') ?>
<?php require_once(PATH_ROOT . '/views/layouts/menu.php') ?>
<?php
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
?>
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
                                <h4 class="card-title">Thêm danh mục</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-vertical" method="POST" action="?act=menu-add">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Tên danh mục</label>
                                                        <input type="text" class="form-control" name="name" placeholder="Nhập tên danh mục..." value="">
                                                    </div>
                                                    <?php show_status(); ?>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Thêm</button>
                                                    <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">Đặt lại</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($menus)): ?>
                    <section id="data-list-view" class="data-list-view-header">
                        <div class="action-btns d-none">
                            <div class="btn-dropdown mr-1 mb-1"></div>
                        </div>

                        <div class="table-responsive">
                            <table class="table data-list-view">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>TÊN DANH MỤC</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($menus as $menu): ?>
                                        <tr>
                                            <td></td>
                                            <td class="product-name"><?= htmlspecialchars($menu['name']) ?></td>
                                            <td class="product-action">
                                                <a href="?act=menu-edit&id=<?= (int)$menu['id'] ?>" class="btn btn-link p-0 mr-1" title="Sửa">
                                                    <i class="feather icon-edit"></i>
                                                </a>
                                                <form method="POST" action="?act=menu-delete" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?= (int)$menu['id'] ?>">
                                                    <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
                                                    <button type="submit" onclick="return confirm('Xoá danh mục này?');" class="btn btn-link p-0">
                                                        <i class="feather icon-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->

<?php require_once(PATH_ROOT . '/views/layouts/footer.php') ?>