<?php
include_once __DIR__ . "/../dao/connection.php";
include_once __DIR__ . "/../controller/auth.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);

$session->start();

if (!$auth->isLoggedIn()) {
    header("Location: /Sinment/index.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post</title>
</head>

<body>
    <h1>Criar Post</h1>

    <form action="../controller/postController.php" method="post" enctype="multipart/form-data">
        <label for="postCaption">Legenda:</label>
        <textarea name="postCaption" id="postCaption" rows="4" cols="50" required aria-label="Legenda"></textarea>

        <label for="postImage">Imagem:</label>
        <input type="file" name="postImage" id="postImage" accept="image/*" required aria-label="Imagem">

        <button type="submit" name="submitPost">Publicar</button>
    </form>

    <a href="home.php">Voltar para a Home</a>
</body>

</html>