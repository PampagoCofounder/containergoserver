<?php

require_once __DIR__ . '/../config/database.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {

    http_response_code(405);

    echo json_encode([
        "error" => "Método no permitido"
    ]);

    exit;
}

try {

    $db = (new Database())->connect();

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $id = $data["id"];

    $stmt = $db->prepare("
        UPDATE productos_comercializacion
        SET
            tipo_producto = :tipo_producto,
            nombre_marca = :nombre_marca,
            tipo_medida = :tipo_medida,
            unidades_disponibles = :unidades_disponibles,
            logistica = :logistica,
            distribuidor = :distribuidor
        WHERE id = :id
    ");

    $stmt->execute([

        ":id" => $id,

        ":tipo_producto" =>
            $data["tipo_producto"],

        ":nombre_marca" =>
            $data["nombre_marca"],

        ":tipo_medida" =>
            $data["tipo_medida"],

        ":unidades_disponibles" =>
            $data["unidades_disponibles"],

        ":logistica" =>
            $data["logistica"],

        ":distribuidor" =>
            $data["distribuidor"]
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Producto actualizado"
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}