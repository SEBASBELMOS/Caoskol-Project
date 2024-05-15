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
    echo "Error en la conexión cURL: " . curl_error($curl);
    ob_end_flush(); // Limpiar y enviar el búfer, evita redirecciones para ver el error
    exit();
}

// Decodificar la respuesta JSON
$resp = json_decode($response);

// Imprimir la respuesta cruda y la decodificada para depuración
echo "<pre>Respuesta del servicio: ";
print_r($response);
echo "</pre>";

echo "<pre>Decoded JSON: ";
print_r($resp);
echo "</pre>";

// Aquí puedes pausar la depuración comentando el resto del flujo
// y verificando los datos impresos. Luego de resolver los errores, puedes continuar con el flujo normal.
?>
