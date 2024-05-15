<?php
// Iniciar almacenamiento en búfer
ob_start();

// Obtener los datos del formulario de inicio de sesión
$id = $_POST["id"];
$clave = $_POST["clave"];

// URL del servicio de validación de usuarios
$servurl = "http://192.168.100.2:3030/login/$id/$clave";

// Iniciar la solicitud cURL
$curl = curl_init($servurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud cURL y obtener la respuesta
$response = curl_exec($curl);

// Verificar si hubo un error en la conexión cURL
if ($response === false) {
    // Guardar mensaje de error para mostrar después
    $error_msg = "Error en la conexión cURL: " . curl_error($curl);
    header("Location: index.html");
    exit();
}

// Decodificar la respuesta JSON
$resp = json_decode($response);

// Verificar si se recibió una respuesta válida
if ($resp !== null) {
    // Verificar si el usuario es válido y si tiene un rol definido
    if (isset($resp->id) && $resp->id == $id && isset($resp->rol)) {
        // Iniciar sesión y redirigirlo a la página correspondiente
        session_start();
        $_SESSION["id"] = $id;
        $_SESSION["rol"] = $resp->rol; // Guardar el rol en la sesión también

        if ($resp->rol == "Profesor") {
            header("Location: profesor.php");
        } else {
            header("Location: estudiante.php");
        }
        exit();
    } else {
        // Guardar mensaje de error para mostrar después
        $error_msg = "Error: La ID de usuario no es correcta o el rol no está definido";
        header("Location: index.html");
        exit();
    }
} else {
    // Guardar mensaje de error para mostrar después
    $error_msg = "Error: Respuesta nula del servicio de validación de usuarios";
    header("Location: index.html");
    exit();
}

// Cerrar la conexión cURL
curl_close($curl);

// Limpiar y desactivar el búfer de salida
ob_end_clean();

// Si hay un mensaje de error, se puede manejar aquí después de todo el proceso
if (isset($error_msg)) {
    echo $error_msg;
}
?>
