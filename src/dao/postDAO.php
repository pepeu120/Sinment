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

        return $stmt->execute();
    }

    public function delete(int $postId): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM Post WHERE id = :id");
        $stmt->bindParam(':id', $postId);
        $stmt->execute();


        return true;
    }

    public function getPostById(int $postId): ?Post
    {
        $stmt = $this->conn->prepare("SELECT * FROM Post WHERE id = :id");
        $stmt->bindParam(':id', $postId);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $post = new Post();
            $post->setId($row['id']);
            $post->setUserId($row['user_id']);
            $post->setCaption($row['caption']);
            $post->setImagePath($row['image_path']);
            $post->setPostingDate($row['posting_date']);
            return $post;
        }

        return null;
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

        return $posts;
    }

    public function getAllPostsByUserId(int $userId): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Post WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->bindParam(':user_id', $userId);
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

        return $posts;
    }
}
