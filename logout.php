<?php
//Iniciar la sesión si no está iniciada
session_start();

// Verificar si la sesión está activa
if (session_status() == PHP_SESSION_ACTIVE) {
    echo "La sesión está activa. <br>";
    
    // Mostrar las variables de sesión usando var_dump
    echo "Estado de la sesión (variables almacenadas): <br>";
    var_dump($_SESSION);  // Muestra todas las variables de sesión
    
    // Opcional: Mostrar el ID de la sesión
    echo "ID de la sesión: " . session_id() . "<br>";
    
    // Destruir todas las variables de sesión
    session_unset();
    
    // Destruir la sesión
    session_destroy();
    echo "<br>Sesión destruida.<br>";

    // Verificar si la sesión ha sido destruida
    if (session_status() == PHP_SESSION_NONE) {
        echo "La sesión ha sido destruida correctamente. <br>";
    } else {
        echo "La sesión sigue activa. <br>";
    }
} else {
    echo "La sesión no está activa. <br>";
}

// Redirigir a la página principal o página de login después de cerrar la sesión
header("Location: login.php");  // Cambia esto a la página que desees
exit;
?>
