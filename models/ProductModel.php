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

    private function buildQueuePageFilterSql(?string $pageId, array &$params): string
    {
        if ($pageId !== null && $pageId !== '') {
            $params[':page_id'] = $pageId;
            return " WHERE q.page_id = :page_id ";
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

    public function countQueueAll(?string $pageId = null): int
    {
        $params = [];
        $where = $this->buildQueuePageFilterSql($pageId, $params);

        $sql = "SELECT COUNT(*) AS total FROM post_queue q {$where}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function countQueueByStatuses(array $statuses, ?string $pageId = null): int
    {
        if (empty($statuses)) return 0;

        $params = [];
        $where = $this->buildQueuePageFilterSql($pageId, $params);

        $statusPlaceholders = [];
        foreach (array_values($statuses) as $i => $st) {
            $key = ":st{$i}";
            $statusPlaceholders[] = $key;
            $params[$key] = $st;
        }

        $sql = "SELECT COUNT(*) AS total
                FROM post_queue q
                {$where}
                " . ($where ? " AND " : " WHERE ")
              . "q.status IN (" . implode(',', $statusPlaceholders) . ")";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function getQueueTopMenuName(?string $pageId = null): string
    {
        $params = [];
        $where = $this->buildQueuePageFilterSql($pageId, $params);

        $sql = "SELECT
                    COALESCE(m.name, 'Chưa phân loại') AS menu_name,
                    COUNT(*) AS total
                FROM post_queue q
                LEFT JOIN menus m ON m.id = q.menu_id
                {$where}
                GROUP BY q.menu_id, m.name
                ORDER BY total DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();

        return $row['menu_name'] ?? 'Chưa có dữ liệu';
    }

    public function getQueueSourceRange(?string $pageId = null): string
    {
        $params = [];
        $where = $this->buildQueuePageFilterSql($pageId, $params);

        $sql = "SELECT MIN(q.source_no) AS min_no, MAX(q.source_no) AS max_no
                FROM post_queue q
                {$where}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();

        $minNo = isset($row['min_no']) ? (int)$row['min_no'] : 0;
        $maxNo = isset($row['max_no']) ? (int)$row['max_no'] : 0;

        if ($minNo <= 0 || $maxNo <= 0) return 'Chưa có dữ liệu';
        return "{$minNo} - {$maxNo}";
    }

    public function getDashboardStats(?string $pageId = null): array
    {
        return [
            'posted' => $this->countPosted($pageId),
            'scheduled' => $this->countScheduled($pageId),
            'top_menu' => $this->getTopMenuName($pageId),

            'batch_total' => $this->countQueueAll($pageId),
            'batch_queued' => $this->countQueueByStatuses(['queued', 'processing'], $pageId),
            'batch_posted' => $this->countQueueByStatuses(['posted'], $pageId),
            'batch_failed' => $this->countQueueByStatuses(['failed'], $pageId),
            'batch_top_menu' => $this->getQueueTopMenuName($pageId),
            'batch_source_range' => $this->getQueueSourceRange($pageId),
        ];
    }
}