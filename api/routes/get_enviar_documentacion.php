<?php

require __DIR__ . '/../config/database.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

try {

    $db = (new Database())->connect();

    $stmt = $db->query("
        SELECT id, empresa_id, tipo_certificacion, url_pdf,create_at
        FROM certificaciones
     
    ");

    $data = $stmt->fetchAll();

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}