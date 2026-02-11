<?php
class MenuModel extends BaseModel
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM menus ORDER BY id DESC";
        return $this->conn->query($sql)->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM menus WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $name): bool
    {
        $sql = "INSERT INTO menus(name) VALUES(:name)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':name' => $name]);
    }

    public function update(int $id, string $name): bool
    {
        $sql = "UPDATE menus SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM menus WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}