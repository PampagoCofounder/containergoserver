<?php

require_once __DIR__ . '/../config/database.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        "error" => "Método no permitido"
    ]);

    exit;
}

try {

    $db = (new Database())->connect();

    $data = json_decode(file_get_contents("php://input"), true);

    $empresa_id = $data["empresa_id"];
    $tipo_producto = $data["tipo_producto"];
    $nombre_marca = $data["nombre_marca"];
    $tipo_medida = $data["tipo_medida"];
    $unidades_disponibles = $data["unidades_disponibles"];
    $logistica = $data["logistica"];
    $distribuidor = $data["distribuidor"];

    $stmt = $db->prepare("
        INSERT INTO productos_comercializacion
        (
            empresa_id,
            tipo_producto,
            nombre_marca,
            tipo_medida,
            unidades_disponibles,
            logistica,
            distribuidor
        )
        VALUES
        (
            :empresa_id,
            :tipo_producto,
            :nombre_marca,
            :tipo_medida,
            :unidades_disponibles,
            :logistica,
            :distribuidor
        )
    ");

    $stmt->execute([
        ":empresa_id" => $empresa_id,
        ":tipo_producto" => $tipo_producto,
        ":nombre_marca" => $nombre_marca,
        ":tipo_medida" => $tipo_medida,
        ":unidades_disponibles" => $unidades_disponibles,
        ":logistica" => $logistica,
        ":distribuidor" => $distribuidor
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Producto creado correctamente"
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}