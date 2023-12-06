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

    <form action="../controller/userController.php" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>

</html>