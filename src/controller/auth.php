<?php
require_once "src/dao/connection.php";
require_once "src/model/user.php";

class Auth
{
    public static function login($email, $password)
    {
        $conn = Connection::getConnection();
        $stmt = $conn->prepare("SELECT * FROM User WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        } else {
            return null;
        }
    }

    public static function logout()
    {
        session_start();

        session_unset();

        session_destroy();

        header("Location: /index.php");
        exit();
    }

    public static function isLoggedIn()
    {
        session_start();

        return isset($_SESSION['user']);
    }
}
