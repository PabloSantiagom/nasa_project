<?php
$bd = 'mysql:host=localhost;dbname=nasa';  // Asegúrate de que hay un punto y coma entre 'localhost' y 'dbname'
$usuario = 'admin';  // Define correctamente el usuario
$clave = 'abc123.';  // Define correctamente la contraseña

try {
    $con = new PDO($bd, $usuario, $clave);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>