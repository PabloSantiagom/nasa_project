<?php

session_name('login');
session_start();
if(!isset($_SESSION['username'])) {
    header('location: login.php');

}

?>

