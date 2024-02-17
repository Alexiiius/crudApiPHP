<?php

include_once 'CORS.php';

//No se puede acceder a este archivo sin GET
if ($_SERVER["REQUEST_METHOD"] != "GET") {
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

//Preparar la sentencia
$sql = $pdo->prepare("SELECT * FROM personas");
//Ejecutar
$sql->execute();

//Respuesta
if ($sql->rowCount() > 0) {
    $personas = $sql->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode(['message' => 'Consulta exitosa', 'data' => $personas]);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'No se encontraron personas']);
}

//Cerrar la conexion
$pdo = null;

?>