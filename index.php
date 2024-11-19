<!-- IMPLEMENTAMOS LA COOKIE-->
<?php
if (!isset($_COOKIE["accesos"])) {
    // Establecemos los valores iniciales para accesos y tokens
    $tokens = ($api_key == "DEMO_KEY") ? 50 : 2000;
    setcookie("tokens", $tokens, time() + 3600 * 24);
    setcookie("accesos", 1, time() + 3600 * 365 * 24);
} else {
    // Incrementamos accesos y decrementamos tokens
    $accesos = isset($_COOKIE["accesos"]) ? $_COOKIE["accesos"] : 0;
    $accesos++;
    setcookie("accesos", $accesos, time() + 3600 * 365 * 24);

    $tokens = isset($_COOKIE["tokens"]) ? $_COOKIE["tokens"] : 0;
    $tokens--;
    setcookie("tokens", $tokens, time() + 3600 * 24);
}
?>



<?php

require 'autenticator.php';
// Verificamos si la sesión no está ya activa para evitar errores al cambiar el nombre o iniciar una nueva sesión
if (session_status() == PHP_SESSION_NONE) {
    session_name('login');
    session_start();
}


?>

<?php




// Tu clave de API de la NASA (reemplázala con tu propia clave)
$api_key = "qyvBkVaphx9UBX9vrac97bx2PIKFn7Fvp4e7Wwie";
$data2="";
$fecha_calendario = date("Y-m-d"); // Usamos la fecha de hoy como default

// Añadimos al endpoint la fecha seleccionada en el formulario si es enviada
if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['date'])) {
    $fecha_calendario = $_POST['date'];
}

// URL de la API APOD con la fecha incluida
$url = "https://api.nasa.gov/planetary/apod?api_key=" . $api_key . "&date=" . $fecha_calendario;

// Inicia una sesión cURL
$ch = curl_init();

// Configura las opciones de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);

// Ejecuta la petición cURL
$response = curl_exec($ch);

// Maneja errores y decodifica la respuesta
if ($response === false) {
    $error = curl_error($ch);
    echo "Error en la petición cURL: $error";
} else {
    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
        $data = json_decode($response, true);
    } else {
        echo "Error al cargar los datos de la API.";
    }
}


//Creamos unos array del apartado headers 

$headers = explode("\r\n", $response);
foreach ($headers as $header) {
    if (stripos($header, 'X-RateLimit-Remaining:') === 0) {
        list(, $remaining) = explode(': ', $header);
        echo "Peticiones restantes: " . trim($remaining) . PHP_EOL;
    }
}



var_dump($data);

// Cierra la sesión cURL
curl_close($ch);

// URL de la API NEO WS con la fecha incluida
$url_asteroids = "https://api.nasa.gov/neo/rest/v1/feed?start_date=" . $fecha_calendario . "&end_date=" . $fecha_calendario . "&api_key=" . $api_key;

// Inicia una sesión cURL
$ch2 = curl_init();

// Configura las opciones de cURL
curl_setopt($ch2, CURLOPT_URL, $url_asteroids);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

// Ejecuta la petición cURL
$response2 = curl_exec($ch2);
$data2 = null;
if ($response2 === false) {
    $error = curl_error($ch2);
    echo "Error en la petición cURL: $error";
} else {
    if (curl_getinfo($ch2, CURLINFO_HTTP_CODE) == 200) {
        $data2 = json_decode($response2, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Error al decodificar la respuesta JSON: " . json_last_error_msg();
            $data2 = null;
        }
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


    <link rel="stylesheet" href="./styles.css">
</head>

<body>
        <div class="hero">
            <h2 class="hero"><?php echo "HOY PODRÁS ACCEDER A LAS IMAGENES DE LA NASA ".$tokens." VECES MÁS"
            ?></h2></div>


    <!-- Navegación principal -->
    <nav class="hero">
        <a href="https://www.nasa.gov/about/">Sobre el espacio</a>
        <a href="https://science.nasa.gov/universe/">Planetas</a>
        <a href="https://www.nasa.gov/images/">Galería</a>
        <a href="https://www.nasa.gov/contact/">Contacto</a>
    </nav>



    <section class="calendar">
        <h1>NASA PIC OF THE DAY</h1>
    <img src="./images/nasa2.png" alt="nasa" class="center">

        <canvas id="canvas"></canvas>
        <div class="content">
            <form method="post" action="index.php">
            <br>
                <label for="date">SELECCIONA UNA FOTO DE UN DÍA ANTERIOR:</label>
                <br>
                <br>
                <input class="login-btn" type="date" id="date" name="date" value="<?php echo $fecha_calendario; ?>">
                <input class="login-btn" type="submit" value="Submit">
            </form>
        </div>

        <div class=showApi>
            <br>
            <h1>Exploración Espacial</h1>
            <br>
            <h1>Viaja a las estrellas y descubre los secretos del universo <br>
                con las maravillosas fotos de la NASA🚀</h1>
            <?php
            // Muestra la respuesta (puedes personalizar esto)
            if (isset($data)) {
                echo "<br><div style='max-width: 800px; margin: 0 auto; text-align: center; font-size: 18px;'>";
                echo "Título: " . $data['title'] . "<br>";
                echo "<br>Fecha: " . $data['date'] . "<br>";
                $videoImg = $data['url'];
                if (str_contains($videoImg, 'image')) {
                    echo "<br><img src='" . $data['url'] . "' alt='APOD Image' width='800' style='border: 2px solid orange;'><br>";
                } else {
                    echo "<br><iframe alt='APOD Image' width='560' height='315' style='border: 2px solid orange;' src='" . $data['url'] . "'></iframe>";
                }
                echo "<br>";
                echo "<br><br>Descripción: " . $data['explanation'];
                echo "</div>";
            }

            ?>
            <!-- Botón de descarga de la imagen -->
            <?php
            if (isset($data) && str_contains($data['url'], 'image')) {
                echo "<div style='text-align: center; margin-top: 20px;'>";
                echo "<a  href='" . $data['url'] . "' download class='download-button'>Descargar Imagen</a>";
                echo "</div>";
            }
            ?>
        </div>

        <div class="hero">

        <h2>Viaja a las estrellas y descubre los asteroides cercanos detectados por la NASA 🚀</h2>
        <br>
    


        <?php
            // Muestra los asteroides detectados (puedes personalizar esto)
            if (isset($data2)) {
                echo "<br><div style='max-width: 800px; margin: 0 auto; text-align: center; font-size: 18px;'>";
                echo "ASTEROIDES Detectados: " . $data2['element_count'] . "🔭📣<br>";
                echo "<br>";

            }
        

            $asteroides_cercanos_fecha = $data2['near_earth_objects'][$fecha_calendario];
            $contador_asteroides = count($asteroides_cercanos_fecha);



        if ($data2 && isset($data2['near_earth_objects'][$fecha_calendario])): ?>
        <h2 text-align="center">ASTEROIDES PELIGROSOS: 🔭💥<br></h2>
        <p>Total de asteroides detectados: <?php echo $contador_asteroides; ?></p>
        <br>
            <div class="cuadricula">
            
                <?php foreach ($data2['near_earth_objects'][$fecha_calendario] as $obj): ?>
                    <div class="apartado">
                    <img src="./images/aste.png"  alt="Imagen 1" class="apartado-img">
                        <h3><?php echo htmlspecialchars($obj['name']); ?></h3>
                        <p>ID: <?php echo htmlspecialchars($obj['id']); ?></p>
                        <?php if (isset($obj['estimated_diameter']['kilometers'])): ?>
                            <p>Diámetro mínimo (km): <?php echo htmlspecialchars($obj['estimated_diameter']['kilometers']['estimated_diameter_min']); ?></p>
                            <p>Diámetro máximo (km): <?php echo htmlspecialchars($obj['estimated_diameter']['kilometers']['estimated_diameter_max']); ?></p>
                        <?php endif; ?>
                        <a href="<?php echo htmlspecialchars($obj['nasa_jpl_url']); ?>" style="login-btn" target="_blank">Más información</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p text-color="#f5a623">No hay datos disponibles para la fecha proporcionada: <?php echo htmlspecialchars($fecha_calendario); ?>.</p>
        <?php endif; ?>
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

<br>
<button onclick="document.getElementById('logoutModal').style.display='block'" class="logout-btn">Cerrar sesión</button>

<div id="logoutModal" class="modal" style="display:none;">
    <h2>Cerrar sesión</h2>
    <p>¿Estás seguro de que deseas cerrar sesión?</p>
    <button class="logout-btn" onclick="window.location.href='login.php'">Confirmar</button>
    <button class="logout-btn"onclick="document.getElementById('logoutModal').style.display='none'">Cancelar</button>
</div>



</body>

</html>