<?php
include_once __DIR__ . "/../model/user.php";
include_once __DIR__ . "/../model/auth.php";
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

$user = $userDAO->getUserById($_SESSION['userId']);
$posts = $postDAO->getAllPostsByUserId($user->getId());
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel='stylesheet' href='../../public/css/home.css'>
</head>

<body>
    <header>
        <div class="logo">
            <a href="home.php"><img src="../../public/images/logo/logo.svg" alt="Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="edit_profile.php">Editar Perfil </a></li>
                <li><a href="create_post.php">New Post</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li>
                    <form action="../controller/router.php" method="post">
                        <button class="logout-button" type="submit" name="logout">Exit</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <h1>Perfil</h1>
    <?php if (isset($_SESSION['message'])) {
        echo "<div class='message'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
    } ?>

    <?php foreach ($posts as $post) : ?>
        <div class="post">
            <?php $postingUser = $userDAO->getUserById($post->getUserId()); ?>
            <h2><?php echo $post->getCaption(); ?></h2>
            <img src="<?php echo $post->getImagePath(); ?>" alt="Post image">
            <p>Posted by <?php echo $postingUser->getFirstname() . " " . $postingUser->getLastname(); ?></p>
            <p>Posted on <?php echo $post->getPostingDate(); ?></p>
            <form action="../controller/router.php" method="post">
                <input type="hidden" name="postId" value="<?php echo $post->getId(); ?>">
                <button class="delete-button" type="submit" name="delete">delete</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>

</html>