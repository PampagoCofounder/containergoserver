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
        SELECT id, empresa_id, nombre_distribuidor, razon_social, cuit, email,telefono,sitio_web,pais,ciudad,direccion,tipo_producto,zona_distribucion,capacidad_logistica,transporte_utilizado,tiempo_entrega,condiciones_pago,mercados_operacion,estado,score_confiabilidad,observaciones, created_at
        FROM distribuidores_comercializacion
        
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