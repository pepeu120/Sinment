<?php
require_once __DIR__ . "/../dao/connection.php";
require_once __DIR__ . "/user.php";
require_once __DIR__ . "/../dao/userDAO.php";
require_once __DIR__ . "/session.php";

class Auth
{
    private $userDAO;
    private $session;

    public function __construct(UserDAO $userDAO, Session $session)
    {
        $this->userDAO = $userDAO;
        $this->session = $session;
    }

    public function login($email, $password): ?User
    {
        $user = $this->userDAO->authenticate($email);

        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $this->session->start();
                return $user;
            }
        }

        return null;
    }

    public function logout(): void
    {
        $this->session->end();
        header("Location: /Sinment/index.php");
        exit();
    }

    public function isLoggedIn(): bool
    {
        $this->session->start();
        if (isset($_SESSION['userId'])) {
            return true;
        } else {
            return false;
        }
    }
}
