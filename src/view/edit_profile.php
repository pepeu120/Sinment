<?php
include_once __DIR__ . "/../dao/userDAO.php";
include_once __DIR__ . "/../dao/connection.php";
include_once __DIR__ . "/../model/session.php";
include_once __DIR__ . "/../model/auth.php";
include_once __DIR__ . "/../model/user.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);



if (!$auth->isLoggedIn()) {
    header("Location: /Sinment/index.php");
    exit();
}
$session->start();
$user = $userDAO->getUserById($_SESSION['userId']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel='stylesheet' href='../../public/css/create-post.css'>
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

    <h1>Editar Perfil</h1>

    <div class="form-input">
        <form action="/Sinment/src/controller/router.php" method="post">
            <input type="text" name="firstname" class="form-input" placeholder="Nome" value="<?php echo $user->getFirstname(); ?>" required>

            <input type="text" name="lastname" class="form-input" placeholder="Sobrenome" value="<?php echo $user->getLastname(); ?>" required>

            <input type="email" name="email" class="form-input" placeholder="Email" value="<?php echo $user->getEmail(); ?>" required>

            <input type="password" name="old_password" class="form-input" placeholder="Old Password" required>

            <input type="password" name="new_password" class="form-input" placeholder="New Password" required>
            <button name="update">update</button>
        </form>
    </div>
</body>

</html>