<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

//Variables conexion DB
$host = "db";
$user = "root";
$pass = "rootpassword";
$db = "mydb";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si la tabla personas existe y crearla si no existe
    $sql = "
        CREATE TABLE IF NOT EXISTS personas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(255) NOT NULL,
            apellido VARCHAR(255) NOT NULL,
            telefono VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL
        )
    ";
    $pdo->exec($sql);
} catch(PDOException $e) {
    throw new PDOException("Connection failed: " . $e->getMessage());
}



?>