<?php
class FbPageModel extends BaseModel
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM fb_pages ORDER BY id DESC";
        return $this->conn->query($sql)->fetchAll();
    }

    public function upsertFromGraph(string $userToken, array $page): void
    {
        $pageId = $page['id'] ?? '';
        if ($pageId === '') {
            return;
        }

        $pageName = $page['name'] ?? '';
        $pageToken = $page['access_token'] ?? '';
        $pageAvatar = "https://graph.facebook.com/{$pageId}/picture?type=square";

        $sql = "INSERT INTO fb_pages (page_id, page_name, page_avatar, access_token, token_page)
                VALUES (:page_id, :page_name, :page_avatar, :user_token, :page_token)
                ON DUPLICATE KEY UPDATE
                    page_name = VALUES(page_name),
                    page_avatar = VALUES(page_avatar),
                    access_token = VALUES(access_token),
                    token_page = VALUES(token_page)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':page_id' => $pageId,
            ':page_name' => $pageName,
            ':page_avatar' => $pageAvatar,
            ':user_token' => $userToken,
            ':page_token' => $pageToken,
        ]);
    }

    public function deleteByPageId(string $pageId): bool
    {
        $sql = "DELETE FROM fb_pages WHERE page_id = :page_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':page_id' => $pageId]);
    }

    public function updatePageInfo(string $pageId, string $name, string $avatar, string $pageToken): bool
    {
        $sql = "UPDATE fb_pages
                SET page_name = :page_name,
                    page_avatar = :page_avatar,
                    token_page = :token_page
                WHERE page_id = :page_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':page_id' => $pageId,
            ':page_name' => $name,
            ':page_avatar' => $avatar,
            ':token_page' => $pageToken,
        ]);
    }

}