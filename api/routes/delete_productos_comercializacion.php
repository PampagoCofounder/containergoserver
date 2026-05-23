<?php

require_once __DIR__ . '/../config/database.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {

    http_response_code(405);

    echo json_encode([
        "error" => "Método no permitido"
    ]);

    exit;
}

try {

    $db = (new Database())->connect();

    // ID desde URL
    $id = $_GET["id"];

    $stmt = $db->prepare("
        DELETE FROM productos_comercializacion
        WHERE id = :id
    ");

    $stmt->execute([
        ":id" => $id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Producto eliminado"
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}