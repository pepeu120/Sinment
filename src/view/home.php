<?php
include_once __DIR__ . "/../controller/auth.php";
include_once __DIR__ . "/../dao/PostDAO.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);

$postDAO = new PostDAO(Connection::getConnection());

$session->start();

if (!$auth->isLoggedIn()) {
    header("Location: /Sinment/index.php");
    exit();
}

$user = $_SESSION['user'];
$posts = $postDAO->getAllPosts();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1>Bem-vindo,
        <?php
        echo $user->getFirstname() . " " . $user->getLastname();
        ?>
    </h1>

    <form action="../controller/userController.php" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>

    <form action="create_post.php" method="post">
        <button type="submit" name="create_post">Create Post</button>
    </form>

    <?php foreach ($posts as $post) : ?>
        <div class="post">
            <h2><?php echo $post->getCaption(); ?></h2>
            <img src="<?php echo $post->getImagePath(); ?>" alt="Post image">
            <p>Posted by <?php echo $user->getFirstname() . " " . $user->getLastname(); ?></p>
            <p>Posted on <?php echo $post->getPostingDate(); ?></p>
        </div>
    <?php endforeach; ?>
</body>

</html>