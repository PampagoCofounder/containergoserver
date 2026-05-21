<?php

require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");
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
        !isset($data["razon_social"]) ||
        !isset($data["nombre_comercial"]) ||
        !isset($data["cuit"]) ||
        !isset($data["condicion_iva"]) ||
        !isset($data["domicilio_fiscal"]) ||
        !isset($data["telefono"]) ||
        !isset($data["email"]) ||
        !isset($data["observacion"])
    ) {

        http_response_code(400);

        echo json_encode([
            "error" => "Faltan datos"
        ]);

        exit;
    }

    $razon_social = $data["razon_social"];
    $nombre_comercial = $data["nombre_comercial"];
    $cuit = $data["cuit"];
    $condicion_iva = $data["condicion_iva"];
    $domicilio_fiscal = $data["domicilio_fiscal"];
    $telefono = $data["telefono"];
    $email = $data["email"];
    $observacion = $data["observacion"];

    // Insertar en tabla solicitud
    $sql = "
        INSERT INTO solicitud_comex
        (razon_social, nombre_comercial, cuit, condicion_iva, domicilio_fiscal, telefono,email, observacion)
        VALUES
        (:razon_social, :nombre_comercial, :cuit, :condicion_iva, :domicilio_fiscal, :telefono, :email, :observacion)
    ";

    $stmt = $db->prepare($sql);

    $stmt->execute([
        ":razon_social" => $razon_social,
        ":nombre_comercial" => $nombre_comercial,
        ":cuit" => $cuit,
        ":condicion_iva" => $condicion_iva,
        ":domicilio_fiscal" => $domicilio_fiscal,
        ":telefono"=> $telefono,
        ":email" => $email,
        ":observacion" => $observacion
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
