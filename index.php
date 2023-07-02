<?php

$DBuser = $_ENV['AZURE_MYSQL_USERNAME'];
$DBpass = $_ENV['AZURE_MYSQL_PASSWORD'];
$DBhost = $_ENV['AZURE_MYSQL_HOST'];
$DBport = $_ENV['AZURE_MYSQL_PORT'];
$pdo = null;

try{
    $database = "mysql:host=$DBhost:$DBport";
    $pdo = new PDO($database, $DBuser, $DBpass);
    echo "Success: A proper connection to MySQL was made! The docker database is great.";
} catch(PDOException $e) {
    echo "Error: Unable to connect to MySQL. Error:\n $e";
}

$pdo = null;