<?php
include_once __DIR__ . "/../dao/connection.php";
include_once __DIR__ . "/../model/auth.php";
include_once __DIR__ . "/../model/user.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);

$session->start();

if (!$auth->isLoggedIn()) {
    header("Location: /Sinment/index.php");
    exit();
}

$user = $userDAO->getUserById($_SESSION['userId']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post</title>
    <link rel='stylesheet' href='../../public/css/create-post.css'>
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

    <h1>Criar Post</h1>

    <div class="form-input">
        <form action="../controller/router.php" method="post" enctype="multipart/form-data">
            <label for="postCaption">Legenda:</label>
            <textarea name="postCaption" id="postCaption" rows="4" cols="50" required aria-label="Legenda"></textarea>

            <label for="postImage">Imagem:</label>
            <input type="file" name="postImage" id="postImage" accept="image/*" required aria-label="Imagem">

            <button type="submit" name="submitPost">Publicar</button>
        </form>
    </div>
</body>

</html>