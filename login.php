
<?php
// Incluir la conexión a la base de datos
require 'database.php';  // Verifica que la ruta sea correcta

// Ahora puedes usar la variable $con para ejecutar consultas


$bd = 'mysql:host=localhost;dbname=nasa';
$usuario = 'admin';
$clave = 'abc123.';

try {
    $con = new PDO($bd, $usuario, $clave);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    header('Location: index.php');
        exit;
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}


?>





<!-- IMPLEMENTAMOS LA SESIÓN-->

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar que los datos no estén vacíos
    if (empty($username) || empty($password)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    // Validar que el nombre de usuario no exista ya en la base de datos
    // Usaremos una consulta SQL para verificarlo
    try {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "Este nombre de usuario ya está en uso.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
        exit;
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    try {
        $stmt = $con->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashed_password
        ]);

        echo "Usuario registrado exitosamente.";
    } catch (PDOException $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>



<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar que los datos no estén vacíos
    if (empty($username) || empty($password)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    // Buscar al usuario en la base de datos
    try {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Usuario no encontrado.";
            exit;
        }

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            echo "Inicio de sesión exitoso.";
            // Aquí puedes iniciar sesión (crear sesión o cookies)
            // session_start();
            // $_SESSION['user_id'] = $user['id'];
        } else {
            echo "Contraseña incorrecta.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
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
                        <label for="token">Introduce tu API Key:</label>
                        <input class="form-control" type="token" id="token" name="token" required>
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