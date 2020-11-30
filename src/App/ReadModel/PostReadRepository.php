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


    /**
     * @return PostView[]
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM posts ORDER BY id DESC');

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
