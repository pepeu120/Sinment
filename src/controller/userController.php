<?php
require_once __DIR__ . "/../dao/userDAO.php";
require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/../model/inputSanitizer.php";
require_once "auth.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);
$sanitizer = new InputSanitizer();

$session->start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $email = $sanitizer->sanitize($_POST["email"]);
        $password = $sanitizer->sanitize($_POST["password"]);

        $user = $auth->login($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header("Location: ../view/home.php");
            exit();
        } else {
            $_SESSION['message'] = "Usuário não autenticado. Verifique suas credenciais.";
            header("Location: /Sinment/index.php");
        }
    } elseif (isset($_POST["signup"])) {
        $firstname = $sanitizer->sanitize($_POST["firstname"]);
        $lastname = $sanitizer->sanitize($_POST["lastname"]);
        $email = $sanitizer->sanitize($_POST["email"]);
        $password = $sanitizer->sanitize($_POST["password"]);

        $user = new User();
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword($password);

        if ($userDAO->insert($user)) {
            $_SESSION['message'] = "Usuário inserido com sucesso!";
        } else {
            $_SESSION['message'] = "Erro ao inserir usuário.";
        }

        header("Location: /Sinment/index.php");
        exit();
    } elseif (isset($_POST["logout"])) {
        $auth->logout();
    }
}
