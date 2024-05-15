<?php
// Iniciar sesión
session_start();


// Verificar si el ID está definido en la sesión
if (!isset($_SESSION["id"])) {
    // Redirigir al usuario al formulario de inicio de sesión con un mensaje de error
    header("Location: index.html?error=" . urlencode("No se ha iniciado sesión correctamente."));
    exit();
}

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
        <style>
            .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"],
        select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007aff; /* Color de Apple */
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #f0ad4e;
        }

        nav {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
            margin-top: 40px;
            margin-right: 20px;
        }

        nav a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
            padding: 8px 12px;
            background-color: #007aff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 100px;
        }

        nav a:hover {
            background-color: #f0ad4e;
        }
        body {
            background-color: #f0f0f0;
            font-family: 'Sofia Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
        }

        .jumbotron {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .custom-title {
            color: #333333;
            font-size: 42px; 
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
            font-weight: bold; 
        }

        .lead {
            color: #666666; 
            font-size: 18px;
            text-align: center;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 10px;
            border-color: #d3d3d3;
        }

        .form-label {
            color: #666666;
            font-size: 16px;
            margin-bottom: 10px; 
        }

        .btn-primary {
            background-color: #f0ad4e;
            border-color: #f0ad4e;
            border-radius: 10px;
            margin-top: 20px;
            width: 100%; 
        }

        .btn-primary:hover {
            background-color: #ee9d2d; 
            border-color: #ee9d2d;
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(240, 173, 78, 0.5); 
        }
    </style>

        </style>
    </head>
   
    <body>
        <div class="container">
            <h1>Bienvenido</h1>
            <nav>
                <a href="logout.php">Cerrar Sesión</a>
            </nav>
        </div>
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
