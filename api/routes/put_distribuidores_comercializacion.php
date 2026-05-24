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
        UPDATE distribuidores_comercializacion
        SET
            nombre_distribuidor = :nombre_distribuidor,
            razon_social = :razon_social,
            cuit = :cuit,
            email = :email,
            telefono = :telefono,
            sitio_web =: sitio_web,
            pais =:pais,
            ciudad =: ciudad,
            direccion =: direccion, 
            tipo_producto =: tipo_producto,
            capacidad_logistica =: capacidad_logistica, 
            transporte_utilizado =: transporte_utilizado, 
            tiempo_entrega =: tiempo_entrega, 
            condiciones_pago =: condiciones_pago, 
            mercados_operacion =: mercados_operacion,
            estado =: estado,
            score_confiabilidad =: score_confiabilidad, 
            observaciones =: observaciones
            
        WHERE id = :id
    ");

    $stmt->execute([

        ":id" => $id,

        ":nombre_distribuidor" =>
            $data["nombre_distribuidor"],

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

        ":capacidad_logistica" => 
            $data["capacidad_logistica"],
        
        ":transporte_utilizado " => 
            $data["transporte_utilizado"],

        ":tiempo_entrega" => 
            $data["tiempo_entrega"],
        
        ":condiciones_pago" => 
            $data["condiciones_pago"],
        
        ":mercados_operacion" => 
            $data["mercados_operacion"],
        
        ":estado" => 
            $data["estado"],
        
        ":score_confiabilidad" => 
            $data["score_confiabilidad"],

        ":observaciones" => 
            $data["observaciones"],

        
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Distribuidor actualizado"
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}