<?php
include_once __DIR__ . "/../controller/auth.php";

if (!Auth::isLoggedIn()) {
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
        <textarea name="postCaption" id="postCaption" rows="4" cols="50" required></textarea>

        <label for="postImage">Imagem:</label>
        <input type="file" name="postImage" id="postImage" accept="image/*" required>

        <button type="submit" name="submitPost">Publicar</button>
    </form>

    <a href="home.php">Voltar para a Home</a>
</body>

</html>