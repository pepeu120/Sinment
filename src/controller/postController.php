<?php
require_once __DIR__ . "/../dao/postDAO.php";
require_once __DIR__ . "/../model/post.php";
require_once __DIR__ . "/../model/fileUpload.php";
require_once __DIR__ . "/../model/session.php";
require_once __DIR__ . "/../model/inputSanitizer.php";
require_once __DIR__ . "/../model/auth.php";
require_once __DIR__ . "/../view/profile.php";
require_once __DIR__ . "/../model/postService.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);

$session->start();

if (!$auth->isLoggedIn()) {
    header("Location: /Sinment/index.php");
    exit();
}

$user = $userDAO->getUserById($_SESSION['userId']);

$fileUpload = new FileUpload("../../public/images/uploads/");

if ($_SERVER["REQUEST_METHOD"]) {
    if ("POST" && isset($_POST["submitPost"])) {
        $postCaption = InputSanitizer::sanitize($_POST["postCaption"]);

        $targetFile = $fileUpload->upload($_FILES["postImage"]);

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
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
        $postId = $_POST["postId"];
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
