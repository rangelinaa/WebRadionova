<?php
class FeedbackService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function doFeedbackAction(string $action, array $params): array
    {
        try {
            return match ($action) {
                'create' => $this->create($params),
                'read'   => $this->read((int)($params['id'] ?? 0)),
                'update' => $this->update($params),
                'delete' => $this->delete((int)($params['id'] ?? 0)),
                'list'   => $this->list((int)($params['product_id'] ?? 0)),
                default  => ['ok' => false, 'error' => "Unknown action: $action"],
            };
        } catch (Throwable $e) {
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    private function list(int $productId): array
    {
        if ($productId <= 0) return ['ok' => false, 'error' => 'Invalid product_id'];
        $stmt = $this->pdo->prepare(
            'SELECT id, product_id, author, rating, comment, created_at
             FROM feedback WHERE product_id = ? ORDER BY created_at DESC'
        );
        $stmt->execute([$productId]);
        return ['ok' => true, 'data' => $stmt->fetchAll()];
    }

    private function create(array $p): array
    {
        $productId = (int)($p['product_id'] ?? 0);
        $author    = trim((string)($p['author'] ?? ''));
        $rating    = (int)($p['rating'] ?? 0);
        $comment   = trim((string)($p['comment'] ?? ''));

        if ($productId <= 0 || $author === '' || $rating < 1 || $rating > 5 || $comment === '') {
            return ['ok' => false, 'error' => 'Invalid input'];
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO feedback (product_id, author, rating, comment) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$productId, $author, $rating, $comment]);
        return ['ok' => true, 'id' => (int)$this->pdo->lastInsertId()];
    }

    private function read(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM feedback WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? ['ok' => true, 'data' => $row] : ['ok' => false, 'error' => 'Not found'];
    }

    private function update(array $p): array
    {
        $id      = (int)($p['id'] ?? 0);
        $rating  = (int)($p['rating'] ?? 0);
        $comment = trim((string)($p['comment'] ?? ''));

        if ($id <= 0 || $rating < 1 || $rating > 5 || $comment === '') {
            return ['ok' => false, 'error' => 'Invalid input'];
        }

        $stmt = $this->pdo->prepare('UPDATE feedback SET rating = ?, comment = ? WHERE id = ?');
        $stmt->execute([$rating, $comment, $id]);
        return ['ok' => true, 'affected' => $stmt->rowCount()];
    }

    private function delete(int $id): array
    {
        if ($id <= 0) return ['ok' => false, 'error' => 'Invalid id'];
        $stmt = $this->pdo->prepare('DELETE FROM feedback WHERE id = ?');
        $stmt->execute([$id]);
        return ['ok' => true, 'affected' => $stmt->rowCount()];
    }
}