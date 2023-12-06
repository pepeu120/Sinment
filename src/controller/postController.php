<?php
require_once __DIR__ . "/../dao/postDAO.php";
require_once __DIR__ . "/../model/post.php";
require_once __DIR__ . "/../model/fileUpload.php";
require_once __DIR__ . "/../model/session.php";
require_once "auth.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);

$session->start();

if (!$auth->isLoggedIn()) {
    header("Location: /Sinment/index.php");
    exit();
}

$user = $_SESSION['user'];
$targetDirectory = "../../uploads/";

$fileUpload = new FileUpload($targetDirectory);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitPost"])) {
    $postCaption = htmlspecialchars($_POST["postCaption"]);

    $targetFile = $fileUpload->upload($_FILES["postImage"]);

    $post = new Post();
    $post->setUserId($user->getId());
    $post->setCaption($postCaption);
    $post->setimagePath($targetFile);

    $postDAO = new PostDAO(Connection::getConnection());

    if ($postDAO->insert($post)) {
        $_SESSION['message'] = "Post created successfully.";
    } else {
        $_SESSION['message'] = "Failed to create post.";
    }
}
