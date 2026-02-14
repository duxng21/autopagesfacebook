<?php
class PostQueueModel extends BaseModel
{
    public function insertMany(array $rows): int
    {
        if (empty($rows)) return 0;

        $sql = "INSERT INTO post_queue
                (batch_id, source_no, page_id, menu_id, content, media_type, media_path, scheduled_at, status)
                VALUES
                (:batch_id, :source_no, :page_id, :menu_id, :content, :media_type, :media_path, :scheduled_at, :status)";
        $stmt = $this->conn->prepare($sql);

        $this->conn->beginTransaction();
        try {
            $count = 0;
            foreach ($rows as $row) {
                $stmt->execute($row);
                $count++;
            }
            $this->conn->commit();
            return $count;
        } catch (Throwable $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function getBatchSummaries(int $limit = 30): array
    {
        $limit = max(1, (int)$limit);

        $sql = "SELECT
                    batch_id,
                    COUNT(*) AS total_jobs,
                    SUM(CASE WHEN status = 'queued' THEN 1 ELSE 0 END) AS queued_jobs,
                    SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) AS processing_jobs,
                    SUM(CASE WHEN status = 'posted' THEN 1 ELSE 0 END) AS posted_jobs,
                    SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) AS failed_jobs,
                    MIN(scheduled_at) AS first_schedule,
                    MAX(scheduled_at) AS last_schedule,
                    MAX(created_at) AS created_at
                FROM post_queue
                GROUP BY batch_id
                ORDER BY created_at DESC
                LIMIT {$limit}";
        return $this->conn->query($sql)->fetchAll();
    }

    public function getItemsByBatchId(string $batchId): array
    {
        $sql = "SELECT *
                FROM post_queue
                WHERE batch_id = :batch_id
                ORDER BY scheduled_at ASC, id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':batch_id' => $batchId]);
        return $stmt->fetchAll();
    }

    public function getDueQueued(int $limit = 20): array
    {
        $limit = max(1, (int)$limit);
        $now = (new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh')))->format('Y-m-d H:i:s');

        $sql = "SELECT *
                FROM post_queue
                WHERE status = 'queued'
                  AND scheduled_at <= :now
                ORDER BY scheduled_at ASC, id ASC
                LIMIT {$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':now' => $now]);
        return $stmt->fetchAll();
    }

    public function markProcessing(int $id): bool
    {
        $sql = "UPDATE post_queue
                SET status = 'processing',
                    last_attempt_at = NOW()
                WHERE id = :id
                  AND status = 'queued'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function markPosted(int $id, ?string $fbPostId): bool
    {
        $sql = "UPDATE post_queue
                SET status = 'posted',
                    fb_post_id = :fb_post_id,
                    updated_at = NOW()
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':fb_post_id' => $fbPostId,
        ]);
    }

    public function markFailed(int $id, string $error): bool
    {
        $sql = "UPDATE post_queue
                SET status = 'failed',
                    retry_count = retry_count + 1,
                    last_error = :last_error,
                    updated_at = NOW()
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':last_error' => mb_substr($error, 0, 5000),
        ]);
    }
}