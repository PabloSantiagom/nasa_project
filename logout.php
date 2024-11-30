<?php
session_start(); // Inicia la sesión
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirige a la página de login
header("Location: login.php");
exit(); // Termina el script
?>