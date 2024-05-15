<?php
// Iniciar buffering
ob_start();

// Obtener los datos del formulario de inicio de sesión
$id = $_POST["id"] ?? '';  // Utilizar el operador de fusión de null para evitar errores si no se envían datos
$clave = $_POST["clave"] ?? '';

// URL del servicio de validación de usuarios
$servurl = "http://192.168.100.2:3030/login/$id/$clave";

// Iniciar la solicitud cURL
$curl = curl_init($servurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

if ($response === false) {
    $error = curl_error($curl);
    curl_close($curl);
    // Usar el buffer para manejar la salida y los encabezados
    ob_end_clean(); // Limpiar el buffer y desactivarlo
    header("Location: index.html?error=" . urlencode("Error en la conexión cURL: " . $error));
    exit();
}

$resp = json_decode($response);
curl_close($curl);

if ($resp !== null && isset($resp->id, $resp->rol)) {
    session_start();
    $_SESSION["id"] = $id;
    $destination = $resp->rol === "Profesor" ? "profesor.php" : "estudiante.php";
    ob_end_clean(); // Limpiar el buffer y desactivarlo
    header("Location: $destination");
    exit();
} else {
    ob_end_clean(); // Limpiar el buffer y desactivarlo
    header("Location: index.html?error=" . urlencode("La ID de usuario no es correcta o el rol no está definido"));
    exit();
}

// Si llega aquí, limpiar y desactivar el buffer también
ob_end_flush();
?>
