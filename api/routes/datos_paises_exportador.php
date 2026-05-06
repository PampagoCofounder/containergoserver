
<?php
require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json");

$db = (new Database())->connect();

try {
    $stmt = $db->query("SELECT * FROM paises_exportadores");
    $stmt->execute();

    $paises = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $paises[] = [
            "id" => (int)$row["id"],
            "nombre_pais" => $row["nombre_pais"],
            "update_now" => $row["update_now"]
        ];
    }
    

    echo json_encode([
        "paises" => $paises
    ]);


} catch (PDOException $e) {
    echo json_encode([
        "error" => "Error en consulta"
    ]);
}

?>