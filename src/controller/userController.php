<?php
session_start();

require_once "../dao/userDAO.php";
require_once "../model/user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        echo "Usuário inserido com sucesso!";
    } else {
        echo "Erro ao inserir usuário.";
    }

    $_SESSION['message'] = "Usuário inserido com sucesso!";
}

header("Location: /Sinment/index.php");
exit();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
