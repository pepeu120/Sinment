<?php
include_once __DIR__ . "/../model/user.php";
include_once __DIR__ . "/../model/auth.php";
include_once __DIR__ . "/../dao/PostDAO.php";


$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);

$session->start();

if (!$auth->isLoggedIn()) {
    header("Location: /Sinment/index.php");
    exit();
}
$postDAO = new PostDAO(Connection::getConnection());

$user = $userDAO->getUserById($_SESSION['userId']);


$posts = $postDAO->getAllPosts();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel='stylesheet' href='../../public/css/home.css'>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../../public/images/logo/logo.svg" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="create_post.php">Novo Post</a></li>
                <li><a href="profile.php">Perfil</a></li>
                <li>
                    <form action="../controller/router.php" method="post">
                        <button type="submit" name="logout">Sair</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <h1>Bem-vindo,
        <?php
        echo $user->getFirstname();
        echo $user->getLastname();
        ?>
    </h1>

    <?php foreach ($posts as $post) : ?>
        <div class="post">
            <?php $postingUser = $userDAO->getUserById($post->getUserId()); ?>
            <h2><?php echo $post->getCaption(); ?></h2>
            <img src="<?php echo $post->getImagePath(); ?>" alt="Post image">
            <p>Postado por <?php echo $postingUser->getFirstname() . " " . $postingUser->getLastname(); ?></p>
            <p> <?php echo $post->getPostingDate(); ?></p>
        </div>
    <?php endforeach; ?>
</body>

</html>