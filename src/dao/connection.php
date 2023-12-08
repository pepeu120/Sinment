<?php
require_once __DIR__ . "/../model/session.php";
$session = new Session();
$session->start();

class Connection
{
    private static $servername = "localhost";
    private static $username = "pepeu";
    private static $password = "pepeu";
    private static $dbName = "SinMent";
    private static $dataSourceName = "my";

    public static function getConnection()
    {
        try {
            $conn = new PDO(
                self::$dataSourceName . "sql:host=" . self::$servername . ";dbname=" .
                self::$dbName, self::$username, self::$password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            $_SESSION['message'] = "Erro ao conectar com o banco de dados. " . $e->getMessage();
            header("Location: /Sinment/index.php");
            exit();
        }
    }
}
