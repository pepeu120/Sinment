<?php
require_once __DIR__ . "/../dao/postDAO.php";

class PostService
{
    private $postDAO;

    public function __construct(PostDAO $postDAO)
    {
        $this->postDAO = $postDAO;
    }

    public function deletePost(int $postId): bool
    {
        $post = $this->postDAO->getPostById($postId);

        $imagePath = $post->getImagePath();
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return $this->postDAO->delete($postId);
    }
}
