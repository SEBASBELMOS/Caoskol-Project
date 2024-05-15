<?php
// Iniciar almacenamiento en búfer
ob_start();

// Obtener los datos del formulario de inicio de sesión
$id = $_POST["id"] ?? '';
$clave = $_POST["clave"] ?? '';

// URL del servicio de validación de usuarios
$servurl = "http://192.168.100.2:3030/login/$id/$clave";

// Iniciar la solicitud cURL
$curl = curl_init($servurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud cURL y obtener la respuesta
$response = curl_exec($curl);

// Verificar si hubo un error en la conexión cURL
if ($response === false) {
    $error = urlencode("Error en la conexión cURL: " . curl_error($curl));
    header("Location: index.php?error=$error");
    exit();
}

// Decodificar la respuesta JSON
$resp = json_decode($response);

// Verificar si se recibió una respuesta válida
if ($resp !== null) {
    if (isset($resp->id) && $resp->id == $id && isset($resp->rol)) {
        session_start();
        $_SESSION["id"] = $id;
        $_SESSION["rol"] = $resp->rol;

        if ($resp->rol == "Profesor") {
            header("Location: profesor.php");
        } else {
            header("Location: estudiante.php");
        }
        exit();
    } else {
        $error = urlencode("ID de usuario incorrecta o el rol no está definido");
        header("Location: index.php?error=$error");
        exit();
    }
} else {
    $error = urlencode("Respuesta nula del servicio de validación de usuarios");
    header("Location: index.php?error=$error");
    exit();
}

// Cerrar la conexión cURL
curl_close($curl);

// Limpiar y desactivar el búfer de salida
ob_end_clean();
?>
