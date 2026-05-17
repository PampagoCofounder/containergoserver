<?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$db = (new Database())->connect();

try {

    // Obtener JSON enviado desde React
    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    // Validar datos
    if (
        !isset($data["nombre"]) ||
        !isset($data["cuit"]) ||
        !isset($data["mensaje"])
    ) {

        http_response_code(400);

        echo json_encode([
            "error" => "Faltan datos"
        ]);

        exit;
    }

    $nombre = $data["nombre"];
    $cuit = $data["cuit"];
    $mensaje = $data["mensaje"];

    // Insertar en tabla solicitud
    $sql = "
        INSERT INTO solicitud_comex
        (nombre, cuit, mensaje)
        VALUES
        (:nombre, :cuit, :mensaje)
    ";

    $stmt = $db->prepare($sql);

    $stmt->execute([
        ":nombre" => $nombre,
        ":cuit" => $cuit,
        ":mensaje" => $mensaje
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Solicitud guardada"
    ]);
} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "error" => "Error en consulta"
    ]);
}
