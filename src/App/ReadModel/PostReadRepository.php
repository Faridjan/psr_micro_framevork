<?php

namespace Farid\App\ReadModel;

use Farid\App\ReadModel\Views\PostView;

class PostReadRepository
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(int $offset, int $limit): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM posts ORDER BY id ASC LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map([$this, 'hydratePost'], $rows);
    }

    public function find($id): ?PostView
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id = :id ');
        $stmt->bindValue(':id', $id, \PDO::FETCH_ASSOC);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? $this->hydratePost($row) : null;
    }

    public function countAll()
    {
        $stmt = $this->pdo->query('SELECT COUNT(id) FROM posts');
        return $stmt->fetchColumn();
    }

    public function hydratePost(array $row): PostView
    {
        $view = new PostView();

        $view->id = (int)$row['id'];
        $view->date = new \DateTimeImmutable($row['date']);
        $view->title = $row['title'];
        $view->content = $row['content'];

        return $view;
    }
}
