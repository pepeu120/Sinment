<?php
require_once __DIR__ . "/../dao/connection.php";
require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/../dao/userDAO.php";

class Auth
{
    public static function login($email, $password)
    {
        $userDAO = new UserDAO();
        $user = $userDAO->authenticate($email, $password);

        if ($user) {
            session_start();
            return $user;
        } else {
            return null;
        }
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /Sinment/index.php");
        exit();
    }

    public static function isLoggedIn()
    {
        session_start();

        return isset($_SESSION['user']);
    }
}
