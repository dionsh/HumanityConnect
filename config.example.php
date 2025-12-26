<?php
$user="DB_USER";
$pass="DB_PASSWORD";
$server="DB_HOST";
$dbname="DB_NAME";

try {
    $conn = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
    die("Database connection error");
}
