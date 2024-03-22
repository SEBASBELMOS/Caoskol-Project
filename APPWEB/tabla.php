<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de registros de notas de estudiantes</title>
    <!-- Agrega tus etiquetas meta y enlaces a CSS y scripts aquí -->
</head>


<body>
    <h1>Estadísticas notas de estudiantes</h1>
    <button id="ocultarTabla" style="display: none;">Ocultar tabla</button>
    <table border="1" id="tablaEstudiantes">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Grado</th>
                <th>Nota de Matemáticas</th>
                <th>Nota de Inglés</th>
                <th>Nota de Ciencias</th>
                <th>Número de Premios</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Obtener el JSON y manejar los errores
            function obtenerDatos()
            {
                try {
                    #$response = file_get_contents('http://localhost:3008/notas/todas/.');
                    $response = file_get_contents('http://192.168.100.2:3008/notas/todas/.');
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


            // Llenar la tabla con los datos
            function llenarTabla()
            {
                $datos = obtenerDatos();
                foreach ($datos as $estudiante) {
                    echo '<tr>';
                    echo '<td>' . $estudiante->nombre . '</td>';
                    echo '<td>' . $estudiante->grado . '</td>';
                    echo '<td>' . $estudiante->puntaje_mat . '</td>';
                    echo '<td>' . $estudiante->puntaje_ing . '</td>';
                    echo '<td>' . $estudiante->puntaje_ciencias . '</td>';
                    echo '<td>' . $estudiante->num_premios . '</td>';
                    echo '</tr>';
                }
            }


            llenarTabla();
            ?>
        </tbody>
    </table>


    <script>
        var tablaEstudiantes = document.getElementById('tablaEstudiantes');
        var ocultarBoton = document.getElementById('ocultarTabla');


        ocultarBoton.addEventListener('click', function () {
            tablaEstudiantes.style.display = 'none';
        });
    </script>
</body>


</html>