<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;800&family=Noto+Sans:wght@400;700&family=Red+Hat+Display:ital,wght@0,300;0,400;0,700;1,900&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/colors.css">
    <link rel="stylesheet" href="./css-recoverd-password/header.css">
    <link rel="stylesheet" href="./css-recoverd-password/box-login.css">
    <link rel="stylesheet" href="./css/recoverd-container.css">
    <link rel="stylesheet" href="./css-recoverd-password/main.css">
    <link rel="stylesheet" href="./css-recoverd-password/form-container.css">
    <link rel="stylesheet" href="./css-recoverd-password/form-input.css">
    <link rel="stylesheet" href="./css-recoverd-password/btn-login.css">
    <link rel="stylesheet" href="./css-recoverd-password/btn-login-cancel.css">
    <link rel="stylesheet" href="./css-recoverd-password/hr.css">
    <link rel="stylesheet" href="./css-recoverd-password/container-buttons.css">
    <link rel="stylesheet" href="./css-recoverd-password/separator.css">
</head>
<body>
    <header>
        <div class="logo"><img src="images/logo.svg"></div>
        <div class="box-login">
            <input type="email" placeholder="Email" class="form-input">
            <input type="password" placeholder="Senha" class="form-input">
            <button class="btn-login">Entrar</button>
        </div>
    </header>
    <main>
        <div class="recoverd-container">
            <div class="form-container">
                <h2>Redefina sua senha</h2>
                <hr class="separator">
                <p>Insira seu email para redefinir sua senha</p>
                <input type="email" placeholder="Email" class="form-input">
                <hr>
                <div class="container-buttons">
                    <a class="btn-login-cancel" href="index.php">Cancelar</a>
                    <button class="btn-login">Enviar</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>