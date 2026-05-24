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
        UPDATE proveedores_comercializacion
        SET
            nombre_proveedor = :nombre_proveedor,
            razon_social = :razon_social,
            cuit = :cuit,
            email = :email,
            telefono = :telefono,
            sitio_web =: sitio_web,
            pais =:pais,
            ciudad =: ciudad,
            direccion =: direccion, 
            tipo_producto =: tipo_producto,
            capacidad_produccion =: capacidad_produccion, 
            incoterm_preferido =: incoterm_preferido, 
            puerto_salida =: puerto_salida, 
            moneda =: moneda, 
            tiempo_entrega =: tiempo_entrega,
            estado =: estado,
            certificaciones =: certificaciones, 
            condiciones_pago =: condiciones_pago, 
            score_confiabilidad =: score_confiabilidad, 
            observaciones =: observaciones
            
        WHERE id = :id
    ");

    $stmt->execute([

        ":id" => $id,

        ":nombre_proveedor" =>
            $data["nombre_proveedor"],

        ":razon_social" =>
            $data["razon_social"],

        ":cuit" =>
            $data["cuit"],

        ":email" =>
            $data["email"],

        ":telefono" =>
            $data["telefono"],

        ":sitio_web" =>
            $data["sitio_web"],

        ":pais" =>
            $data["pais"],

        ":ciudad" =>
            $data["ciudad"],
        
        ":direccion" => 
            $data["direccion"],
        
        ":tipo_producto" => 
            $data["tipo_producto"],

        ":capacidad_produccion" => 
            $data["capacidad_produccion"],
        
        ":incoterm_preferido" => 
            $data["incoterm_preferido"],

        ":puerto_salida" => 
            $data["puerto_salida"],
        
        ":moneda" => 
            $data["moneda"],
        
        ":tiempo_entrega" => 
            $data["tiempo_entrega"],
        
        ":estado" => 
            $data["estado"],
        
        ":certificaciones" => 
            $data["certificaciones"],
        
        ":condiciones_pago" => 
            $data["condiciones_pago"],
        
        ":score_confiabilidad" => 
            $data["score_confiabilidad"],

        ":observaciones" => 
            $data["observaciones"],

        
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Proveedor actualizado"
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}