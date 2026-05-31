<?php

$data = json_decode(file_get_contents('php://input'), true);

$ordenes = strtolower(trim($data['ordenes'] ?? ''));

$respuesta = null;

/* ENTRENAMIENTO */
$reglas = [
    [
        "palabras" => ["me siento mal", "estoy cansado", "estoy triste"],
        "respuestas" => [
            "Lamento que te sientas así. ¿Quieres contarme qué pasó?",
            "Entiendo. Estoy aquí para ayudarte.",
            "¿Quieres hablar un poco de lo que te ocurre?"
        ]
    ],
    [
        "palabras" => ["como te sentis","estas bien","trabajaste mucho","trabajo"],
        "respuestas" =>[
            "Si muy cansado pero tengo que seguir resolviendo tareas",
            "Siempre estoy bien porque soy asistente no tengo reloj",
            "Me siento tranquilo de ayudarte en tu tarea"
        ]
    ],

    [
        "palabras" => ["hola", "buenas", "saludos", "buen dia", "como estas", "bien"],
        "respuestas" => [
            "¡Hola! ¿En qué puedo ayudarte?",
            "¡Buenas! Cuéntame tu consulta.",
            "Hola 👋 ¿Qué necesitas hoy?"
        ]
    ],

    [
        "palabras" => ["exportar", "exportacion", "importar", "exportadores", "importadores","quiero info de comex","Quiero info de comercio exterior"],
        "respuestas" => [
            "Puedo ayudarte con exportación, logística y documentación.",
            "¿Qué producto quieres exportar o importar?",
            "Te explico el proceso paso a paso si quieres."
        ]
    ],

    [
        "palabras" => ["fob", "cif"],
        "respuestas" => [
            "FOB es entrega a bordo del buque. CIF incluye seguro y flete.",
            "CIF cubre transporte y seguro hasta destino.",
            "¿Quieres un ejemplo práctico?"
        ]
    ]
];

/* BUSQUEDA */
foreach ($reglas as $regla) {

    if (!isset($regla["respuestas"]) || !is_array($regla["respuestas"])) {
        continue;
    }

    foreach ($regla["palabras"] as $palabra) {

        $palabra = strtolower($palabra);

        if ($palabra !== "" && str_contains($ordenes, $palabra)) {

            $respuesta = $regla["respuestas"][array_rand($regla["respuestas"])];

            break 2;
        }
    }
}

/* DEFAULT */
if ($respuesta === null) {

    $noEntiendo = [
        "No entendí tu consulta. ¿Podrías explicarla de otra manera?",
        "¿Podrías darme más detalles?",
        "No estoy seguro de haber entendido.",
        "Intenta reformular tu pregunta."
    ];

    $respuesta = $noEntiendo[array_rand($noEntiendo)];
}

echo json_encode([
    "prueba" => $respuesta
]);