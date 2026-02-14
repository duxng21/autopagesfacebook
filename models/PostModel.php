<?php
class PostModel extends BaseModel
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM posts ORDER BY id DESC";
        return $this->conn->query($sql)->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO posts
                (menu_id, page_id, fb_post_id, content, media_type, media_path, status, scheduled_at, posted_at)
                VALUES (:menu_id, :page_id, :fb_post_id, :content, :media_type, :media_path, :status, :scheduled_at, :posted_at)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM posts WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function deleteById(int $id): bool
    {
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function countByMenus(array $menuIds = []): int
    {
        if (empty($menuIds)) {
            $sql = "SELECT COUNT(*) AS total FROM posts";
            $row = $this->conn->query($sql)->fetch();
            return (int)($row['total'] ?? 0);
        }

        $ids = implode(',', array_map('intval', $menuIds));
        $sql = "SELECT COUNT(*) AS total FROM posts WHERE menu_id IN ($ids)";
        $row = $this->conn->query($sql)->fetch();
        return (int)($row['total'] ?? 0);
    }

    public function getPageByMenus(int $limit, int $offset, array $menuIds = []): array
    {
        $limit = max(1, (int)$limit);
        $offset = max(0, (int)$offset);

        if (empty($menuIds)) {
            $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $limit OFFSET $offset";
            return $this->conn->query($sql)->fetchAll();
        }

        $ids = implode(',', array_map('intval', $menuIds));
        $sql = "SELECT * FROM posts WHERE menu_id IN ($ids) ORDER BY id DESC LIMIT $limit OFFSET $offset";
        return $this->conn->query($sql)->fetchAll();
    }

    public function markScheduledToPosted(): void
    {
        $sql = "UPDATE posts
                SET status = 'posted',
                    posted_at = NOW()
                WHERE status = 'scheduled'
                AND scheduled_at IS NOT NULL
                AND scheduled_at <= NOW()";
        $this->conn->exec($sql);
    }

    public function updateById(int $id, array $data): bool
    {
        $sql = "UPDATE posts
                SET menu_id = :menu_id,
                    content = :content,
                    status = :status,
                    scheduled_at = :scheduled_at,
                    posted_at = :posted_at
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':menu_id' => $data['menu_id'],
            ':content' => $data['content'],
            ':status' => $data['status'],
            ':scheduled_at' => $data['scheduled_at'],
            ':posted_at' => $data['posted_at'],
        ]);
    }

    public function getByIdRange(int $fromId, int $toId): array
    {
        $sql = "SELECT *
                FROM posts
                WHERE id BETWEEN :from_id AND :to_id
                ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':from_id' => $fromId,
            ':to_id' => $toId,
        ]);
        return $stmt->fetchAll();
    }

}