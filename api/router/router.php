<?php

require_once __DIR__ . "/../config/cors.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];



//limpiar ruta correctamente
$path = trim($uri,"/");
$segments = explode("/",$path);

//validar que empiece con /api
if(isset($segments[0]) && $segments[0] === "api"){
    $route = $segments[1] ?? "";
}else{
    $route = "";
}

if ($route === "login" && $method === "GET") {
    http_response_code(405);
    echo json_encode([
        "error" => "Método no permitido",
        "hint" => "Usar POST"
    ]);
    exit;
}



$routes = [

    "POST" => [
        "login" => "routes/login.php",
        "upload-clientes"=> "routes/upload_clientes.php",
        "solicitud_comex" => "routes/solicitud_comex.php",
        "enviar_productos" => "routes/post_productos_comercializacion.php",
        "enviar_proveedores" => "routes/post_proveedores_comercializacion.php",
        "enviar_distribuidores" => "routes/post_distribuidores_comercializacion.php",
        "chatbot"=> "routes/post_chatbot.php",
        "enviar_documentacion" => "routes/post_enviar_documentacion.php"

    ],
    "GET" => [
        "clientes" => "routes/get_clientes.php",
        "dolar" => "routes/dolar.php",
        "riesgo" => "routes/riesgopais.php",
        "datoscomex" => "routes/datos_comex.php",
        "empresa" => "routes/get_empresa.php",
        "empresa_comercio" => "routes/get_empresa_comercio.php",
        "paises_exportadores" => "routes/datos_paises_exportador.php",
        "dolar_clp" => "routes/moneda_chilena.php",
        "estado_comercializacion" => "routes/datos_comercializacion.php",
        "obtener_productos" => "routes/get_productos_comercializacion.php",
        "obtener_proveedor" => "routes/get_proveedores_comercializacion.php",
        "obtener_distribuidor" => "routes/get_distribuidores_comercializacion.php",
        "obtener_cartera_clientes" => "routes/get_cartera_clientes.php",
        "obtener_documentacion" => "routes/get_enviar_documentacion.php",

    ],
    "DELETE" => [
        "eliminar_productos" => "routes/delete_productos_comercializacion.php",
        "eliminar_proveedores" => "routes/delete_proveedores_comercializacion.php",
        "eliminar_distribuidores" => "routes/delete_distribuidores_comercializacion.php"
    ],
    "PUT" => [
        "actualizar_productos" => "routes/put_productos_comercializacion.php",
        "actualizar_proveedores" => "routes/put_proveedores_comercializacion.php",
        "actualizar_distribuidores" => "routes/put_distribuidores_comercializacion.php",
    ]
    
];

if (isset($routes[$method][$route])) {
    require_once __DIR__ . "/../" . $routes[$method][$route];
    exit();
}

http_response_code(404);
echo json_encode([
    "error" => "Ruta no encontrada",
    "route" => $route,
    "method"=>$method,
    "uri" => $uri
]);

?>