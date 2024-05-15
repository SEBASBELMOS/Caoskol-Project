<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de notas de estudiantes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        h1 {
            font-size: 24px;
        }


        h2 {
            font-size: 20px;
        }
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
    <div style="max-width: 600px; margin: 0 auto;">
        <h1>Estadísticas de notas de estudiantes</h1>
        <h2>Histograma de promedio de puntaje por prueba</h2>
        <canvas id="histogramaPromedioPuntaje"></canvas>
    </div>



    <?php
    // Obtener los datos de puntajes de los estudiantes
    function obtenerDatosPuntajes()
    {
        try {
            #$response = file_get_contents('http://localhost:3031/notas/todas/.');
            $response = file_get_contents('http://192.168.100.2:3031/notas/todas/.');
            if (!$response) {
                throw new Exception('Error al obtener los datos');
            }
            $datos = json_decode($response);
            return $datos;
        } catch (Exception $error) {
            echo '<p>Error: ' . $error->getMessage() . '</p>';
            throw $error; // Relanzar el error para que pueda ser capturado externamente si es necesario
        }
    }


    // Calcular el promedio de puntajes para cada prueba
    function calcularPromedioPuntajes($datos)
    {
        $promedioMatematicas = 0;
        $promedioIngles = 0;
        $promedioCiencias = 0;
        $totalEstudiantes = count($datos);


        foreach ($datos as $estudiante) {
            $promedioMatematicas += $estudiante->puntaje_mat;
            $promedioIngles += $estudiante->puntaje_ing;
            $promedioCiencias += $estudiante->puntaje_ciencias;
        }


        $promedioMatematicas /= $totalEstudiantes;
        $promedioIngles /= $totalEstudiantes;
        $promedioCiencias /= $totalEstudiantes;


        return [
            'Matemáticas' => $promedioMatematicas,
            'Inglés' => $promedioIngles,
            'Ciencias' => $promedioCiencias
        ];
    }


    $datosPuntajes = obtenerDatosPuntajes();
    $promedios = calcularPromedioPuntajes($datosPuntajes);


    // Convertir los promedios a un formato compatible con Chart.js
    $etiquetas = array_keys($promedios);
    $valores = array_values($promedios);
    ?>


    <script>
        var etiquetas = <?php echo json_encode($etiquetas); ?>;
        var valores = <?php echo json_encode($valores); ?>;


        var ctx = document.getElementById('histogramaPromedioPuntaje').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: etiquetas,
                datasets: [{
                    label: 'Promedio de puntaje por prueba',
                    data: valores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


       
    <div style="width: 400px; height: 400px; margin: 0 auto;">
        <h1>Porcentaje de estudiantes con y sin premios</h1>
        <canvas id="graficoPastelPremios"></canvas>
    </div>


    <script>
        // Cálculo de porcentaje de premios
        var premios = <?php echo json_encode($datosPuntajes); ?>;
        var premiosTotales = 0;
        var premiosObtenidos = {
            'Sin premios': 0,
            'Con premios': 0
        };


        for (var i = 0; i < premios.length; i++) {
            if (premios[i].num_premios === 0) {
                premiosObtenidos['Sin premios']++;
            } else {
                premiosObtenidos['Con premios']++;
            }
            premiosTotales++;
        }


        var porcentajeSinPremios = (premiosObtenidos['Sin premios'] / premiosTotales) * 100;
        var porcentajeConPremios = (premiosObtenidos['Con premios'] / premiosTotales) * 100;


        var ctxPie = document.getElementById('graficoPastelPremios').getContext('2d');
        var myPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Sin premios', 'Con premios'],
                datasets: [{
                    data: [porcentajeSinPremios, porcentajeConPremios],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>


    <div style="text-align: center; margin-top: 50px;">
        <button style="padding: 15px 30px; font-size: 18px; background-color: yellow; border: none; border-radius: 5px;" onclick="window.location.href = 'tabla.php';">Ver tabla</button>
    </div>


</body>


</html>
