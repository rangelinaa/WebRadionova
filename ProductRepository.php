<?php
class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchAll(): array
    {
        return $this->pdo
            ->query('SELECT id, name, image, price, description FROM products ORDER BY id DESC')
            ->fetchAll();
    }

    public function fetchById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, name, image, price, description FROM products WHERE id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}