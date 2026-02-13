<?php
class ProductModel extends BaseModel
{
    private function buildPageFilterSql(?string $pageId, array &$params): string
    {
        if ($pageId !== null && $pageId !== '') {
            $params[':page_id'] = $pageId;
            return " WHERE p.page_id = :page_id ";
        }
        return "";
    }

    public function countPosted(?string $pageId = null): int
    {
        $params = [];
        $where = $this->buildPageFilterSql($pageId, $params);

        $sql = "SELECT COUNT(*) AS total
                FROM posts p
                {$where}
                " . ($where ? " AND p.status = 'posted'" : " WHERE p.status = 'posted'");

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function countScheduled(?string $pageId = null): int
    {
        $params = [];
        $where = $this->buildPageFilterSql($pageId, $params);

        $sql = "SELECT COUNT(*) AS total
                FROM posts p
                {$where}
                " . ($where ? " AND p.status = 'scheduled'" : " WHERE p.status = 'scheduled'");

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function getTopMenuName(?string $pageId = null): string
    {
        $params = [];
        $where = $this->buildPageFilterSql($pageId, $params);

        $sql = "SELECT
                    COALESCE(m.name, 'Chưa phân loại') AS menu_name,
                    COUNT(*) AS total
                FROM posts p
                LEFT JOIN menus m ON m.id = p.menu_id
                {$where}
                GROUP BY p.menu_id, m.name
                ORDER BY total DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();

        return $row['menu_name'] ?? 'Chưa có dữ liệu';
    }

    public function getDashboardStats(?string $pageId = null): array
    {
        return [
            'posted' => $this->countPosted($pageId),
            'scheduled' => $this->countScheduled($pageId),
            'top_menu' => $this->getTopMenuName($pageId),
            'batch_posts' => 0, // Tạm giữ 0, phần batch xử lý sau
        ];
    }
}