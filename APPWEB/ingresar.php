<?php
// Iniciar buffering
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
    $error = "Error en la conexión cURL: " . curl_error($curl);
    // Redirigir al usuario a la página de inicio con un mensaje de error
    header("Location: index.html?error=" . urlencode($error));
    exit();
}

// Decodificar la respuesta JSON
$resp = json_decode($response);

// Verificar si se recibió una respuesta válida
if ($resp !== null) {
    // Verificar si el usuario es válido y si tiene un rol definido
    if (isset($resp->id) && $resp->id == $id && isset($resp->rol)) {
        session_start();
        $_SESSION["id"] = $id;
        // Redirigir al usuario a la página correspondiente según su rol
        $redirect = $resp->rol == "Profesor" ? "profesor.php" : "estudiante.php";
        header("Location: $redirect");
        exit();
    } else {
        $error = "Error: La ID de usuario no es correcta o el rol no está definido";
        header("Location: index.html?error=" . urlencode($error));
        exit();
    }
} else {
    $error = "Error: Respuesta nula del servicio de validación de usuarios";
    header("Location: index.html?error=" . urlencode($error));
    exit();
}

// Cerrar la conexión cURL
curl_close($curl);

// Limpiar el buffer y enviar la salida final
ob_end_flush();
?>
