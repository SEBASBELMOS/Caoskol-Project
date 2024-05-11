<?php
// Iniciar sesión
session_start();


// Obtener el ID del usuario autenticado
$id = $_SESSION["id"];


// URL del microservicio de notas para obtener los datos del usuario
#$servurl = "http://localhost:3031/notas/$id";
$servurl = "http://192.168.100.2:3031/notas/$id";


// Iniciar la solicitud cURL para obtener los datos del usuario
$curl = curl_init($servurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);


// Decodificar la respuesta JSON
$user_data = json_decode($response);


// Verificar si se recibió una respuesta válida
if ($user_data) {
    // Mostrar la información del usuario en forma de dashboard
    ?>
    <!DOCTYPE html>
    <html lang="en">
   
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard del Usuario</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
            crossorigin="anonymous">
    </head>
   
    <body>
        <div class="container mt-5">
            <h1 class="mb-4"><?php echo $user_data->nombre; ?></h1>
            <h2 class="mb-4">Grado: <?php echo $user_data->grado; ?></h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Número de Premios</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $user_data->num_premios; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Puntaje de Matemáticas</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $user_data->puntaje_mat; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Puntaje de Inglés</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $user_data->puntaje_ing; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Puntaje de Ciencias</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $user_data->puntaje_ciencias; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
   
    </html>
    <?php
} else {
    // Si no se recibió una respuesta válida, mostrar un mensaje de error
    echo "Error al obtener los datos del usuario.";
}
?>
