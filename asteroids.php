<?php
// Tu clave de API de la NASA (reemplázala con tu propia clave)
$api_key = "qyvBkVaphx9UBX9vrac97bx2PIKFn7Fvp4e7Wwie";
$fecha_calendario = date("Y-m-d"); // Usamos la fecha de hoy como default



// Añadimos al endpoint la fecha seleccionada en el formulario si es enviada
if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['date'])) {
    $fecha_calendario = $_POST['date'];
}


// URL de la API NEO WS con la fecha incluida
$url_asteroids = "https://api.nasa.gov/neo/rest/v1/feed?start_date=" . $fecha_calendario . "&end_date=" . $fecha_calendario . "&api_key=" . $api_key;

// Inicia una sesión cURL

$ch2 = curl_init();

// Configura las opciones de cURL
curl_setopt($ch2, CURLOPT_URL, $url_asteroids);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, false);

// Ejecuta la petición cURL
$response2 = curl_exec($ch2);

// Maneja errores y decodifica la respuesta
if ($response2 === false) {
    $error = curl_error($ch2);
    echo "Error en la petición cURL: $error";
} else {
    if (curl_getinfo($ch2, CURLINFO_HTTP_CODE) == 200) {
        $data2 = json_decode($response2, true);
    } else {
        echo "Error al cargar los datos de la API.";
    }
}

// Cierra la sesión cURL
curl_close($ch2);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NASA PIC OF THE DAY</title>


    <link rel="stylesheet" href="styles.css">
</head>



        <div class=showApi>
            <h1>Exploración Espacial</h1>
            <br>
            <h1>Viaja a las estrellas y descubre los secretos del universo <br>
                con las maravillosas fotos de la NASA🚀</h1>
            <?php
            // Muestra los asteroides detectados (puedes personalizar esto)
            if (isset($data2)) {
                echo "<br><div style='max-width: 800px; margin: 0 auto; text-align: center; font-size: 18px;'>";
                echo "ASTEROIDES Detectados: " . $data2['element_count'] . "🔭📣<br>";
            
                // Acceso correcto a near_earth_objects
                $asteroides_cercanos_fecha = $data2['near_earth_objects'][$fecha_calendario];
            
                foreach ($asteroides_cercanos_fecha as $obj) {
                    // Acceso como array asociativo
                    echo "Nombre: " . $obj['name'] . "<br>";
                    echo "ID: " . $obj['id'] . "<br>";
                }
            }

                // $asteroides_peligrosos = count($data2['near_earth_objects']['id']);
                // var_dump($asteroides_peligrosos);


                // Diferencia clave:
                //     Para acceder a las propiedades de un objeto, usas -> en lugar de [].
                //     Para acceder a las claves que tienen caracteres especiales, como fechas ('2015-09-07'), puedes usar la notación ->{'clave'}.

                //     Ejemplo Resumido:
                //     Array Asociativo: $data['near_earth_objects']['2015-09-07'][0]['name']

                //     Array de Objetos: $data->near_earth_objects->{'2015-09-07'}[0]->name

                //     Esto te permite acceder a los elementos de manera clara y consistente cuando trabajas con objetos en PHP.
                //$data['near_earth_objects']['2015-09-07'][0]['name']


                
                // if($asteroides_peligrosos >0 ){
                //     echo "ASTEROIDES Peligrosos: " . $asteroides_peligrosos . "🔭💥<br>";
                    
                    

                // }else{


                //     echo "ASTEROIDES Peligrosos: " . $asteroides_peligrosos . "🔭💥<br>";
                //     echo "No hay por que preocuparse , fiu";





                // }



            

            ?>
           
          
        </div>


                    <!-- Pie de página -->
            <footer class="footer" id="contact">
                <p>&copy; 2024 Exploración Espacial. Todos los derechos reservados.</p>
            </footer>


        <script src="js/starback.js"></script>
        <script>
            const canvas = document.getElementById('canvas');
            const starback = new Starback(canvas, {
                width: document.body.clientWidth,
                height: document.body.clientHeight,
                type: 'dot',
                quantity: 100,
                direction: 225,
                backgroundColor: ['#0e1118', '#232b3e'],
                randomOpacity: true,
            });

            let mountain = new Image();
            mountain.src = 'images/mountain2.png';
            mountain.onload = () => {
                starback.addToFront((ctx) => {
                    ctx.drawImage(
                        mountain,
                        0,
                        0,
                        mountain.width,
                        mountain.height,
                        0,
                        canvas.height - mountain.height,
                        canvas.width,
                        mountain.height
                    );
                });
            }
        </script>
</body>

</html>