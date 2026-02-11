<!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="?act=/">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0">DUXNG</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="<?= menu_active('/') ?> nav-item"><a href="?act=/"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                </li>
                <li class=" navigation-header"><span>TIỆN ÍCH</span>
                </li>
                <li class="<?= menu_active('menus') ?> nav-item"><a href="?act=menus"><i class="feather icon-box"></i><span class="menu-title" data-i18n="Cloud">Danh mục</span></a>
                </li>
                <li class="<?= menu_active('posts') ?> nav-item"><a href="?act=posts"><i class="feather icon-list"></i><span class="menu-title" data-i18n="Post">Danh sách POST</span></a>
                </li>
                <li class=" navigation-header"><span>KHÁC</span>
                </li>
                <li class="<?= menu_active('pages') ?> nav-item"><a href="?act=pages"><i class="feather icon-users"></i><span class="menu-title" data-i18n="Pages">Cấu hình</span></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->