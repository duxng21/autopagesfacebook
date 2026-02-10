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
                (page_id, fb_post_id, content, media_type, media_path, status, scheduled_at, posted_at)
                VALUES (:page_id, :fb_post_id, :content, :media_type, :media_path, :status, :scheduled_at, :posted_at)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
}