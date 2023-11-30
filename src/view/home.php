<?php
session_start();
include_once "src/controller/auth.php";

if (!Auth::isLoggedIn()) {
    header("Location: /index.php");
    exit();
}

echo "tela inicial";
