<?php
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
                self::$dbName,self::$username, self::$password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }

    public static function closeConnection($conn)
    {
        try {
            $conn = null;
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}