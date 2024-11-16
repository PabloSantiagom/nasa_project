<?php
    session_name('pablo');
    session_start();
    session_destroy();

    header('location:login.php');

?>