<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Login Page - Vuexy - Bootstrap HTML admin template</title>
    <link rel="apple-touch-icon" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/views/duxng_theme/assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img src="<?= BASE_URL ?>/views/duxng_theme/app-assets/images/pages/login_2.png" width="500" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">ĐĂNG NHẬP</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">Chào mừng trở lại, vui lòng đăng nhập tài khoản của bạn.</p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                <form method="POST">
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="username" placeholder="Tài khoản" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <label for="user-name">Tài khoản</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="user-password">Mật khẩu</label>
                                                    </fieldset>
                                                    <?php if (!empty($error)): ?>
                                                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                                                    <?php endif; ?>
                                                    <?php
                                                        $msg = $_GET['msg'] ?? '';
                                                        if ($msg === 'logout') {
                                                            echo '<div class="alert alert-success">Đã đăng xuất.</div>';
                                                        } elseif ($msg === 'login_ok') {
                                                            echo '<div class="alert alert-success">Đăng nhập thành công.</div>';
                                                            echo '<script>
                                                                setTimeout(function () {
                                                                    window.location.href = "?act=/";
                                                                }, 1200);
                                                            </script>';
                                                        }
                                                    ?>
                                                    <button type="submit" class="btn bg-gradient-success mr-1 mb-1 waves-effect waves-light btn-block">Đăng nhập</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="login-footer">
                                            <div class="divider">
                                                <div class="divider-text"><b>@LOGIN PANEL</b></div>
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


    <!-- BEGIN: Vendor JS-->
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/core/app-menu.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/core/app.js"></script>
    <script src="<?= BASE_URL ?>/views/duxng_theme/app-assets/js/scripts/components.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>