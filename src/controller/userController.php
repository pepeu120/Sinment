<?php
require_once __DIR__ . "/../dao/userDAO.php";
require_once __DIR__ . "/../model/user.php";
require_once __DIR__ . "/../dao/connection.php";
require_once __DIR__ . "/../model/session.php";
require_once __DIR__ . "/../model/inputSanitizer.php";
require_once __DIR__ . "/../model/auth.php";

class UserController {
    private $userDAO;
    private $session;
    private $auth;
    private $sanitizer;

    public function __construct()
    {
        $this->userDAO = new UserDAO(Connection::getConnection());
        $this->session = new Session();
        $this->auth = new Auth($this->userDAO, $this->session);
        $this->sanitizer = new InputSanitizer();

        $this->session->start();
    }

    public function login($email, $password) {
        $email = $this->sanitizer->sanitize($email);

        $user = $this->auth->login($email, $password);

        if ($user) {
            $_SESSION['userId'] = $user->getId();
            header("Location: ../view/home.php");
            exit();
        } else {
            $_SESSION['message'] = "Usuário ou senhas invalidos. Verifique suas credenciais.";
            header("Location: /Sinment/index.php");
        }
    }

    public function signup($firstname, $lastname, $email, $password) {
        $firstname = $this->sanitizer->sanitize($firstname);
        $lastname = $this->sanitizer->sanitize($lastname);
        $email = $this->sanitizer->sanitize($email);

        if ($this->userDAO->emailExists($email)) {
            $_SESSION['message'] = "Email já cadastrado.";
            header("Location: /Sinment/index.php");
            exit();
        } else {
            $user = new User();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

            if ($this->userDAO->insert($user)) {
                $_SESSION['message'] = "Usuário inserido com sucesso!";
            } else {
                $_SESSION['message'] = "Erro ao inserir usuário.";
            }
        }
        header("Location: /Sinment/index.php");
        exit();
    }

    public function logout() {
        $this->auth->logout();
    }

    public function update($oldPassword, $newPassword, $firstname, $lastname, $email) {
        $user = $this->userDAO->getUserById($_SESSION['userId']);

        if (password_verify($oldPassword, $user->getPassword())) {
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));

            $this->userDAO->update($user);
            $_SESSION['message'] = "Perfil atualizado com sucesso!";
        } else {
            $_SESSION['message'] = "Senha incorreta";
        }

        header("Location: /Sinment/src/view/profile.php");
        exit();
    }
}
