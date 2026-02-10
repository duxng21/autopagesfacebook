<?php
class AdminModel extends BaseModel
{
    public function findByUsername(string $username): ?array
    {
        $sql = "SELECT * FROM admins WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
