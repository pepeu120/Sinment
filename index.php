<!DOCTYPE html>
<html lang="pt-br">

<?php
include_once __DIR__ . "/src/controller/auth.php";
include_once __DIR__ . "/src/dao/connection.php";
include_once __DIR__ . "/src/dao/userDAO.php";

$userDAO = new UserDAO(Connection::getConnection());
$session = new Session();
$auth = new Auth($userDAO, $session);

$session->start();

if (isset($_SESSION['message'])) {
    echo "<div class='message'>{$_SESSION['message']}</div>";
    unset($_SESSION['message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $user = $auth->login($email, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: src/view/home.php");
        exit();
    } else {
        echo "Login falhou. Verifique suas credenciais.";
    }
}

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;800&family=Noto+Sans:wght@400;700&family=Red+Hat+Display:ital,wght@0,300;0,400;0,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/colors.css">
    <link rel="stylesheet" href="./css/login-container.css">
    <link rel="stylesheet" href="./css/info-container.css">
    <link rel="stylesheet" href="./css/text-info.css">
    <link rel="stylesheet" href="./css/form-container.css">
    <link rel="stylesheet" href="./css/box-form.css">
    <link rel="stylesheet" href="./css/form-input-container.css">
    <link rel="stylesheet" href="./css/form-input.css">
    <link rel="stylesheet" href="./css/form-button.css">
    <link rel="stylesheet" href="./css/form-element.css">
    <link rel="stylesheet" href="./css/form-link-sign-up.css">
    <link rel="stylesheet" href="./css/modal-window.css">
    <link rel="stylesheet" href="./css/modal.css">
    <link rel="stylesheet" href="./css/form-button-gender.css">
    <link rel="stylesheet" href="./css/radio-button.css">
    <link rel="stylesheet" href="./css/terms-text.css">
    <link rel="stylesheet" href="./css/close-modal.css">
    <title>Sinment-login</title>
</head>

<body>
    <main>
        <div class="login-container">
            <div class="info-container">
                <img class="logo-img" src="images/logo.svg" alt="logo">
                <p class="text-info">Conecte-se de forma autêntica e compartilhe experiências genuínas em nossa rede social dedicada a relacionamentos verdadeiros.</p>
            </div>
            <div class="form-container">
                <div class="box-form">
                    <form action="/Sinment/src/controller/userController.php" method="post">
                        <div class="form-input-container">
                            <input type="email" name="email" class="form-input" placeholder="Email" required>
                            <input type="password" name="password" class="form-input" placeholder="Senha" required>
                        </div>
                        <button class="form-button" name="login">Entrar</button>
                    </form>
                    <a href="/Sinment/src/view/recorverd-password.php" class="form-link">Esqueceu a senha?</a>
                    <div class="form-element">
                        <div class="text-element">Ou</div>
                    </div>
                    <p class="text-form">Ainda não tem uma conta? <a href="#" class="form-link-sign-up" onclick="openModal()">Cadastre-se</a></p>
                </div>
            </div>
        </div>

        <div class="modal-window" contenteditable="false" id="modal-window">
            <div class="modal">
                <button class="close-modal" id="close-modal">X</button>
                <h1>Cadastre-se</h1>
                <form action="/Sinment/src/controller/userController.php" method="post">
                    <div class="form-input-container">
                        <input type="text" name="firstname" class="form-input" placeholder="Nome" required>

                        <input type="text" name="lastname" class="form-input" placeholder="Sobrenome" required>

                        <input type="email" name="email" class="form-input" placeholder="Email" required>

                        <input type="password" name="password" class="form-input" placeholder="Senha" required>
                    </div>
                    <p class="terms-text">Ao se cadastrar, você concorda com nossos <a href="#">Termos, Política de Privacidade</a> e <a href="#">Política de Cookies.</a></p>
                    <button class="form-button" name="signup">Cadastrar</button>
                </form>
            </div>
        </div>

        <script src="script.js"></script>
    </main>

    <div></div>

</body>

</html>