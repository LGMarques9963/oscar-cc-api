<?php

class DB
{
    public PDO $conn;
    private static array $instance = [];

    public function __construct()
    {
        $this->connect();
    }


    public static function getInstance($dbName)
    {

        if (!isset(self::$instance[$dbName])) {
            self::$instance[$dbName] = new static();
        }

        return self::$instance[$dbName];
    }


    public function connect()
    {
        $dbUser = $_ENV['AZURE_MYSQL_USERNAME'];
        $dbPass = $_ENV['AZURE_MYSQL_PASSWORD'];
        $dbHost = $_ENV['AZURE_MYSQL_HOST'];
        $dbPort = $_ENV['AZURE_MYSQL_PORT'];
        $database = "mysql:host=$dbHost:$dbPort";
        try {
            $this->conn = new PDO(
                $database,
                $dbUser,
                $dbPass,
                [
                    PDO::ATTR_TIMEOUT => 10,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}