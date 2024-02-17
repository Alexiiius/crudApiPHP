<?php

include_once 'CORS.php';

//No se puede acceder a este archivo sin POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(400);
    echo json_encode(['message' => 'Metodo invalido']);
    die();
}

try {
    require_once 'conexion.php';
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
    die();
}

//Reconocer el tipo de contenido y desglosarlo
$contentType = $_SERVER["CONTENT_TYPE"] ?? '';

if ($contentType === 'application/json') {
    $data = json_decode(file_get_contents('php://input'), true);
} elseif ($contentType === 'application/x-www-form-urlencoded' || $contentType === 'multipart/form-data') {
    $data = $_POST;
} else {
    http_response_code(400);
    echo json_encode(['message' => 'La peticion debe ser JSON, urlencoded o multipart']);
    die();
}

$nombre = $data["nombre"] ?? "";
$apellido = $data["apellido"] ?? "";
$telefono = $data["telefono"] ?? "";
$email = $data["email"] ?? "";

if ($nombre == "" || $apellido == "" || $telefono == "" || $email == "") {
    http_response_code(400);
    echo json_encode(['message' => 'Faltan datos por enviar']);
    die();
}

//Se ignorara la validacion de los datos por simplicidad de la practica
//Preparar la sentencia
$sql = $pdo->prepare("INSERT INTO personas (nombre, apellido, telefono, email) VALUES (:nombre, :apellido, :telefono, :email)");
//Binding
$sql->bindParam(':nombre', $nombre);
$sql->bindParam(':apellido', $apellido);
$sql->bindParam(':telefono', $telefono);
$sql->bindParam(':email', $email);
//Ejecutar
$sql->execute();

//Respuesta
if ($sql->rowCount() > 0) {
    http_response_code(201);
    echo json_encode(['message' => 'Registro exitoso']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error en el registro']);
}

//Cerrar la conexion
$pdo = null;

?>