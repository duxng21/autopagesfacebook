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
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cấu hình</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-vertical" method="POST">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>User Access Token:</label>
                                                        <input type="text" class="form-control" name="user_token"
                                                            placeholder="Nhập token dạng EAA..." value="">
                                                    </div>
                                                    <?php show_status(); ?>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Lưu</button>
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
                <?php if (!empty($pages)): ?>
                    <section id="data-list-view" class="data-list-view-header">
                        <div class="action-btns d-none">
                            <div class="btn-dropdown mr-1 mb-1">
                                <!-- BUTTON -->
                            </div>
                        </div>

                        <!-- DataTable starts -->
                        <div class="table-responsive">
                            <table class="table data-list-view">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID PAGES</th>
                                        <th>NAME PAGES</th>
                                        <th>AVATAR</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pages as $p): ?>
                                        <tr>
                                            <td></td>
                                            <td class="product-name"><?= htmlspecialchars($p['page_id']) ?></td>
                                            <td class="product-category"><?= htmlspecialchars($p['page_name']) ?></td>
                                            <td><img src="<?= htmlspecialchars($p['page_avatar']) ?>" width="35" alt=""></td>
                                            <?php
                                                if (empty($_SESSION['csrf'])) {
                                                    $_SESSION['csrf'] = bin2hex(random_bytes(16));
                                                }
                                            ?>
                                            <td class="product-action">
                                                <form method="POST" action="?act=pages-delete" style="display:inline;">
                                                    <input type="hidden" name="page_id" value="<?= htmlspecialchars($p['page_id']) ?>">
                                                    <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
                                                    <button type="submit" onclick="return confirm('Xoá page này?');" class="btn btn-link p-0">
                                                        <i class="feather icon-trash"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- DataTable ends -->
                    </section>
                <?php endif; ?>
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Hướng dẫn sử dụng</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="accordion" id="accordionExample" data-toggle-hover="true">
                                        <div class="collapse-margin">
                                            <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <span class="lead collapse-title collapsed">
                                                    Bước 1
                                                </span>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    Pastry pudding cookie toffee bonbon jujubes jujubes powder topping. Jelly beans gummi bears sweet roll
                                                    bonbon muffin liquorice. Wafer lollipop sesame snaps.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse-margin">
                                            <div class="card-header" id="headingTwo" data-toggle="collapse" role="button" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <span class="lead collapse-title collapsed">
                                                    Bước 2
                                                </span>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    Sweet pie candy jelly. Sesame snaps biscuit sugar plum. Sweet roll topping fruitcake. Caramels
                                                    liquorice biscuit ice cream fruitcake cotton candy tart.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse-margin">
                                            <div class="card-header" id="headingThree" data-toggle="collapse" role="button" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <span class="lead collapse-title">
                                                    Bước 3
                                                </span>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    Tart gummies dragée lollipop fruitcake pastry oat cake. Cookie jelly jelly macaroon icing jelly beans
                                                    soufflé cake sweet. Macaroon sesame snaps cheesecake tart cake sugar plum.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse-margin">
                                            <div class="card-header collapsed" id="headingFour" data-toggle="collapse" role="button" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                <span class="lead collapse-title">
                                                    Bước 4
                                                </span>
                                            </div>
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    Cheesecake muffin cupcake dragée lemon drops tiramisu cake gummies chocolate cake. Marshmallow tart
                                                    croissant. Tart dessert tiramisu marzipan lollipop lemon drops.
                                                </div>
                                            </div>
                                        </div>
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