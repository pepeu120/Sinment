<?php
require_once "../model/post.php";

class PostDAO
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insert(Post $post): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO Post (user_id, caption, image_path)
        VALUES (:user_id, :caption, :imagePath)");

        $userId = $post->getUserId();
        $caption = $post->getCaption();
        $imagePath = $post->getimagePath();

        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':caption', $caption);
        $stmt->bindParam(':imagePath', $imagePath);

        Connection::closeConnection($this->conn);

        return $stmt->execute();
    }

    public function getPostById(int $postId): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Post WHERE id = :id");
        $stmt->bindParam(':id', $postId);
        $stmt->execute();

        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        Connection::closeConnection($this->conn);

        return $post;
    }

    public function update(Post $post): bool
    {
        $stmt = $this->conn->prepare("UPDATE Post SET caption = :caption, imagePath = :imagePath WHERE id = :id");

        $postId = $post->getId();
        $caption = $post->getCaption();
        $imagePath = $post->getimagePath();

        $stmt->bindParam(':id', $postId);
        $stmt->bindParam(':caption', $caption);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->execute();

        Connection::closeConnection($this->conn);

        return true;
    }

    public function delete(int $postId): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM Post WHERE id = :id");
        $stmt->bindParam(':id', $postId);
        $stmt->execute();

        Connection::closeConnection($this->conn);

        return true;
    }

    public function getAllPosts(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Post ORDER BY id DESC");
        $stmt->execute();

        $posts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post = new Post();
            $post->setId($row['id']);
            $post->setUserId($row['user_id']);
            $post->setCaption($row['caption']);
            $post->setImagePath($row['image_path']);
            $post->setPostingDate($row['posting_date']);
            $posts[] = $post;
        }
        Connection::closeConnection($this->conn);

        return $posts;
    }
}
