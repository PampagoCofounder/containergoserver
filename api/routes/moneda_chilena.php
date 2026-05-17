<?php 
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../../vendor/autoload.php";


header("Content-Type: application/json");

// ------------------
// CONFIG
// ------------------
$cacheDir  = __DIR__ . '/cache';
$cacheFile = $cacheDir . '/usd_clp_cache.json';
$cacheTime = 180; // 3 minutos

if (!file_exists($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

// ------------------
// CACHE
// ------------------
$lastValue = 0;

if (file_exists($cacheFile)) {

    $cacheData = json_decode(
        file_get_contents($cacheFile),
        true
    );

    // cache válido
    if (
        $cacheData &&
        isset($cacheData['timestamp']) &&
        (time() - $cacheData['timestamp'] < $cacheTime)
    ) {

        echo json_encode([
            "compra" => $cacheData['compra'],
            "venta" => $cacheData['venta'],
            "arrow" => $cacheData['arrow'],
            "updated_at" => $cacheData['updated_at'],
            "cached" => true
        ]);

        exit;
    }

    $lastValue = $cacheData['venta'] ?? 0;
}

// ------------------
// API USD -> CLP
// ------------------
$ch = curl_init(
    "https://open.er-api.com/v6/latest/USD"
);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);

$response = curl_exec($ch);

if ($response === false) {

    echo json_encode([
        "compra" => $lastValue,
        "venta" => $lastValue,
        "arrow" => "→",
        "error" => curl_error($ch)
    ]);

    exit;
}

curl_close($ch);

// ------------------
// JSON
// ------------------
$data = json_decode($response, true);

if (
    !$data ||
    !isset($data['rates']) ||
    !isset($data['rates']['CLP'])
) {

    echo json_encode([
        "compra" => $lastValue,
        "venta" => $lastValue,
        "arrow" => "→",
        "error" => "No se pudo obtener CLP"
    ]);

    exit;
}

// ------------------
// VALORES
// ------------------
$currentValue = floatval(
    $data['rates']['CLP']
);

// spread ficticio
$compra = round($currentValue - 5, 2);
$venta  = round($currentValue + 5, 2);

// ------------------
// FLECHA
// ------------------
$arrow = "→";

if ($lastValue > 0) {

    if ($venta > $lastValue) {
        $arrow = "↑";
    }

    elseif ($venta < $lastValue) {
        $arrow = "↓";
    }
}

// ------------------
// GUARDAR CACHE
// ------------------
$saveData = [
    "compra" => $compra,
    "venta" => $venta,
    "arrow" => $arrow,
    "updated_at" => date("H:i:s"),
    "timestamp" => time()
];

file_put_contents(
    $cacheFile,
    json_encode($saveData)
);

// debug opcional
file_put_contents(
    __DIR__ . '/cache/debug_usd_clp.json',
    $response
);

// ------------------
// RESPUESTA
// ------------------
echo json_encode([
    "compra" => $compra,
    "venta" => $venta,
    "arrow" => $arrow,
    "updated_at" => date("H:i:s"),
    "cached" => false
]);

?>