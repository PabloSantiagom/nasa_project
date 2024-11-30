<?php

$user = $_POST['name'];
$password = password_hash($_POST['password']);
$token = $_POST['token'];

global $con;
require 'database.php';
$stmnt = $con->prepare("insert into users (name, password, token) values(?, ?, ?)");
$stmnt -> execute(array($user,$password,$token));

password_verify($pass,$user->$password)

?>