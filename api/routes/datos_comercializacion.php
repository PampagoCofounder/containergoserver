<?php
require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$db = (new Database())->connect();

try {
    $stmt = $db->query("SELECT * FROM estado_comercializacion");

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["error" => "Sin datos"]);
        exit;
    }

    echo json_encode([
        "estado" => $row["estado"],
        "fecha_actualizacion" => $row["fecha_actualizacion"]
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "error" => "Error en consulta"
    ]);
}





?>