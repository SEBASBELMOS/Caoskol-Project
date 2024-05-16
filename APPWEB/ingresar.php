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

// Cerrar la conexión cURL
curl_close($curl);

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
    // Verificar si el usuario es válido y si tiene un rol definido
    if (isset($resp->id) && $resp->id == $id && isset($resp->rol)) {
        session_start();
        $_SESSION["id"] = $id;
        $_SESSION["rol"] = $resp->rol;

        switch($resp->rol) {
            case "Profesor":
                header("Location: profesor.php");
                break;
            case "Administrador":
                header("Location: profesor.php");
                break;
            case "Estudiante":
                header("Location: estudiante.php");
                break;
            default:
                $error = urlencode("Rol no definido o no permitido");
                header("Location: index.php?error=$error");
                break;
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

// Limpiar y desactivar el búfer de salida
ob_end_clean();
?>
