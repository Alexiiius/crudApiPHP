<?php

//No se puede acceder a este archivo sin DELETE
if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
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

$id = $data["id"] ?? "";

if ($id == "") {
    http_response_code(400);
    echo json_encode(['message' => 'Falta el id por enviar']);
    die();
}

// Se ignorara la validacion de los datos por simplicidad de la practica
// Del mismo modo se ignorara la autenticacion por simplicidad de la practica
// Preparar la sentencia
$sql = $pdo->prepare("DELETE FROM personas WHERE id = :id");
// Binding
$sql->bindParam(':id', $id);
// Ejecutar
$sql->execute();

// Respuesta
if ($sql->rowCount() > 0) {
    http_response_code(200);
    echo json_encode(['message' => 'Eliminacion exitosa']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error en la eliminacion']);
}

// Cerrar la conexion
$pdo = null;

?>