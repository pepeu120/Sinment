<?php

session_start();

require_once __DIR__ . "/../dao/userDAO.php";
require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/auth.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);

        $user = Auth::login($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header("Location: ../view/home.php");
            exit();
        } else {
            echo "Usuário não autenticado. Verifique suas credenciais.";
            exit();
        }

    } elseif (isset($_POST["signup"])) {
        $firstname = test_input($_POST["firstname"]);
        $lastname = test_input($_POST["lastname"]);
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);

        $user = new User();
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword($password);

        $userDAO = new UserDAO();

        if ($userDAO->insert($user)) {
            $_SESSION['message'] = "Usuário inserido com sucesso!";
        } else {
            $_SESSION['message'] = "Erro ao inserir usuário.";
        }

        header("Location: /Sinment/index.php");
        exit();

    } elseif (isset($_POST["logout"])) {
        Auth::logout();
    }

}

header("Location: /Sinment/src/view/home.php");
exit();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
