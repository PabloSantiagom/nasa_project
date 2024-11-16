<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        echo "Debes introducir un password por favor.";
    } elseif ($username === 'pablo' && $password === 'pablo') {
        session_name('login');
        session_start();
        $_SESSION['username'] = $username;
        //echo "Bienvenido!!!";
        header("Location:index.php");
    } else {

        echo "Usuario o contraseña incorrecta";
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGUEATE</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <section id="hero">
        <canvas id="canvas"></canvas>
        <div class="content">
            <!-- Sección de cabecera con el tema del espacio -->
            <header class="hero">
                <h1>BIENVENIDO A LA NASA🚀</h1>

                <img src="./images/nasa2.png" alt="nasa" class="center">

                <p>Viaja a las estrellas y descubre los secretos del universo</p>
                <br>
                <!-- BOTON DE INICIO DE SESION-->
                <button onclick="document.getElementById('loginModal').style.display='block'" class="login-btn">Iniciar sesión</button>
            </header>


            <!-- Modal de login -->
            <div id="loginModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('loginModal').style.display='none'">&times;</span>
                    <br>
                    <h2>Iniciar sesión</h2>
                    <form action="#" method="post">
                        <label for="username">Usuario:</label>
                        <input class="form-control" type="text" id="username" name="username" required>
                        <label for="password">Contraseña:</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                        <button type="submit" class="submit-btn">Ingresar</button>
                    </form>
                    <br>
                    <h2>Crear Cuenta</h2>
                    <form action="#" method="post">
                        <label for="username">Usuario:</label>
                        <input class="form-control" type="text" id="username" name="username" required>
                        <label for="password">Contraseña:</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                        <label for="password">Repetir contraseña:</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                        <label for="password">Introduce tu API Key:</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                        <button type="submit" class="submit-btn">Crear tu cuenta</button>
                        <br>
                        <br>
                        <br>
                        <h4>¿No tienes API KEY?</h4>
                        <a href="https://api.nasa.gov/">Consiguela aquí.</a>
                        <br>
                    </form>
                </div>
            </div>

            <!-- Pie de página
            <footer class="footer" id="contact">
                <p>&copy; 2024 Exploración Espacial. Todos los derechos reservados.</p>
            </footer> -->

        </div>
    </section>
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