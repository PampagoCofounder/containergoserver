<?php

require_once __DIR__ . '/../config/database.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

try {

    $db = (new Database())->connect();

    $stmt = $db->query("
        SELECT id, nombre_empresa_importador, ciudad, pais, email,telefono,caracteristicas,producto,capitulo,posicion_arancelaria,reglamento_barreras,condiciones_acceso, anio_actualizacion
        FROM cartera_clientes
        
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
?>