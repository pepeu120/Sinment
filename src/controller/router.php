<?php
require_once __DIR__ . "/userController.php";
require_once __DIR__ . "/postController.php";


$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);
$userController = new UserController();
$postController = new PostController();

$session->start();

$user = $userDAO->getUserById($_SESSION['userId']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $userController->login($_POST["email"], $_POST["password"]);
    } elseif (isset($_POST["signup"])) {
        $userController->signup($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"]);
    } elseif (isset($_POST["logout"])) {
        $userController->logout();
    } elseif (isset($_POST["update"])) {
        $userController->update($_POST["old_password"], $_POST["new_password"], $_POST["firstname"], $_POST["lastname"], $_POST["email"]);
    } elseif (isset($_POST["submitPost"])) {
        $postController->submitPost($user, $_POST["postCaption"], $_FILES["postImage"]);
    } elseif (isset($_POST["delete"])) {
        $postController->deletePost($_POST["postId"]);
    }
}
