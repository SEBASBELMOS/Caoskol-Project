<?php
// Obtener los datos del formulario de inicio de sesión
$id = $_POST["id"];
$clave = $_POST["clave"];


// URL del servicio de validación de usuarios
#$servurl = "http://localhost:3030/login/$id/$clave";
$servurl = "http://192.168.100.2:3030/login/$id/$clave";


// Iniciar la solicitud cURL
$curl = curl_init($servurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


// Ejecutar la solicitud cURL y obtener la respuesta
$response = curl_exec($curl);


// Verificar si hubo un error en la conexión cURL
if ($response === false) {
    // Si hubo un error, redirigir al usuario a la página de inicio y mostrar un mensaje de error (opcional)
    //echo "Error en la conexión cURL: " . curl_error($curl);
    header("Location:index.html");
    exit();
}


// Decodificar la respuesta JSON
$resp = json_decode($response);


// Verificar si se recibió una respuesta válida
if ($resp !== null) {
    // Verificar si el usuario es válido y si tiene un rol definido
    if (isset($resp->id) && $resp->id == $id && isset($resp->rol)) {
        // Si el usuario es válido y tiene un rol definido, iniciar sesión y redirigirlo a la página correspondiente
        session_start();
        $_SESSION["id"] = $id;
        if ($resp->rol == "Profesor") {
            // Si el usuario es un profesor, redirigirlo a la página de profesor
            header("Location:profesor.php");
        } else {
            // Si el usuario es un estudiante, redirigirlo a la página de estudiante
            header("Location:estudiante.php");
        }
        exit();
    } else {
        // Si la ID no es correcta o el rol no está definido, mostrar un mensaje de error (opcional)
        //echo "Error: La ID de usuario no es correcta o el rol no está definido";
        // Redirigir al usuario a la página de inicio
        header("Location:index.html");
        exit();
    }
} else {
    // Si la respuesta es nula, mostrar un mensaje de error (opcional)
    //echo "Error: Respuesta nula del servicio de validación de usuarios";
    // Redirigir al usuario a la página de inicio
    header("Location:index.html");
    exit();
}


// Cerrar la conexión cURL
curl_close($curl);
?>
