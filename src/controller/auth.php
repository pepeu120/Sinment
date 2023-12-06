<?php
require_once __DIR__ . "/../dao/connection.php";
require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/../dao/userDAO.php";
require_once __DIR__ . "/../model/session.php";

class Auth
{
    private $userDAO;
    private $session;

    public function __construct(UserDAO $userDAO, Session $session)
    {
        $this->userDAO = $userDAO;
        $this->session = $session;
    }

    public function login($email, $password)
    {
        $user = $this->userDAO->authenticate($email, $password);

        if ($user) {
            $this->session->start();
            return $user;
        }
    }

    public function logout()
    {
        $this->session->end();
        header("Location: /Sinment/index.php");
        exit();
    }

    public function isLoggedIn()
    {
        return $this->session->isStarted();
    }
}
