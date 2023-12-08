<?php
require_once __DIR__ . "/../dao/postDAO.php";
require_once __DIR__ . "/../model/post.php";
require_once __DIR__ . "/../dao/connection.php";
require_once __DIR__ . "/../model/fileUpload.php";
require_once __DIR__ . "/../model/inputSanitizer.php";
require_once __DIR__ . "/../model/postService.php";

class PostController
{
    private $fileUpload;

    public function __construct()
    {
        $this->fileUpload = new FileUpload("../../public/images/uploads/");
    }

    public function submitPost($user, $postCaption, $postImage)
    {
        $postCaption = InputSanitizer::sanitize($postCaption);

        $targetFile = $this->fileUpload->upload($postImage);

        $post = new Post();
        $post->setUserId($user->getId());
        $post->setCaption($postCaption);
        $post->setimagePath($targetFile);

        $postDAO = new PostDAO(Connection::getConnection());

        if ($postDAO->insert($post)) {
            $_SESSION['message'] = "Post criado com sucesso";
            header("Location: /Sinment/src/view/home.php");
            exit();
        } else {
            $_SESSION['message'] = "Falha ao criar post";
        }
    }

    public function deletePost($postId)
    {
        $postDAO = new PostDAO(Connection::getConnection());
        $postService = new PostService($postDAO);

        if ($postService->deletePost($postId)) {
            $_SESSION['message'] = "Post deletado com sucesso.";
            header("Location: /Sinment/src/view/profile.php");
            exit();
        } else {
            $_SESSION['message'] = "Falha ao deletar post.";
        }
    }
}
