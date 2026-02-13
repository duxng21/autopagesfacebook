<?php
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
    }

    public function Home()
    {
        $selectedPageId = trim($_GET['page_id'] ?? '');

        $pageModel = new FbPageModel();
        $pages = $pageModel->getAll();

        $selectedPageName = '';
        if ($selectedPageId !== '') {
            foreach ($pages as $p) {
                if (($p['page_id'] ?? '') === $selectedPageId) {
                    $selectedPageName = $p['page_name'] ?? '';
                    break;
                }
            }
        }

        $stats = $this->modelProduct->getDashboardStats($selectedPageId !== '' ? $selectedPageId : null);

        require_once './views/pages/home.php';
    }
}