<?php
require_once "../dao/connection.php";
require_once "../model/post.php";

class PostDAO
{

    public function insert(Post $post): bool
    {
        try {
            $conn = Connection::getConnection();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO Post (user_id, caption, image_path)
            VALUES (:user_id, :caption, :imagePath)");

            $userId = $post->getUserId();
            $caption = $post->getCaption();
            $imagePath = $post->getimagePath();

            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':caption', $caption);
            $stmt->bindParam(':imagePath', $imagePath);

            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function getPostById(int $postId): ?array
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT * FROM Post WHERE id = :id");
            $stmt->bindParam(':id', $postId);
            $stmt->execute();

            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            return $post;
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function update(Post $post): bool
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("UPDATE Post SET caption = :caption, imagePath = :imagePath WHERE id = :id");

            $postId = $post->getId();
            $caption = $post->getCaption();
            $imagePath = $post->getimagePath();

            $stmt->bindParam(':id', $postId);
            $stmt->bindParam(':caption', $caption);
            $stmt->bindParam(':imagePath', $imagePath);

            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        } finally {
            Connection::closeConnection($conn);
        }
    }

    public function delete(int $postId): bool
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("DELETE FROM Post WHERE id = :id");
            $stmt->bindParam(':id', $postId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        } finally {
            Connection::closeConnection($conn);
        }
    }

    public function getAllPosts(): array
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT * FROM Post ORDER BY id DESC");
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
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        } finally {
            Connection::closeConnection($conn);
        }
    }
}
