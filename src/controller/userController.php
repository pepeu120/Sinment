<?php
require_once __DIR__ . "/../dao/userDAO.php";
require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/../model/inputSanitizer.php";
require_once __DIR__ . "/../model/auth.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);
$sanitizer = new InputSanitizer();

$session->start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $email = $sanitizer->sanitize($_POST["email"]);
        $password = $_POST["password"];

        $user = $auth->login($email, $password);

        if ($user) {
            $_SESSION['userId'] = $user->getId();
            header("Location: ../view/home.php");
            exit();
        } else {
            $_SESSION['message'] = "Usuário ou senhas invalidos. Verifique suas credenciais.";
            header("Location: /Sinment/index.php");
        }
    } elseif (isset($_POST["signup"])) {
        $firstname = $sanitizer->sanitize($_POST["firstname"]);
        $lastname = $sanitizer->sanitize($_POST["lastname"]);
        $email = $sanitizer->sanitize($_POST["email"]);
        $password = $_POST["password"];

        if ($userDAO->emailExists($email)) {
            $_SESSION['message'] = "Email já cadastrado.";
            header("Location: /Sinment/index.php");
            exit();
        } else {
            $user = new User();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

            if ($userDAO->insert($user)) {
                $_SESSION['message'] = "Usuário inserido com sucesso!";
            } else {
                $_SESSION['message'] = "Erro ao inserir usuário.";
            }
        }
        header("Location: /Sinment/index.php");
        exit();
    } elseif (isset($_POST["logout"])) {
        $auth->logout();
    } elseif (isset($_POST["update"])) {
        $oldPassword = $_POST["old_password"];
        $newPassword = $_POST["new_password"];

        $userDAO = new UserDAO(Connection::getConnection());
        $user = $userDAO->getUserById($_SESSION['userId']);

        if (password_verify($oldPassword, $user->getPassword())) {
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));

            $user->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));
            $userDAO->update($user);
            $_SESSION['message'] = "Perfil atualizado com sucesso!";
        } else {
            $_SESSION['message'] = "Senha incorreta";
        }

        header("Location: /Sinment/src/view/profile.php");
        exit();
    }
}
