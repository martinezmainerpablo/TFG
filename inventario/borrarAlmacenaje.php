<?php
require_once __DIR__ . '/../bd/almacenaje.php';
require_once __DIR__ . '/../bd/usuario.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    
}
else {
    $usuario = null;
    header('Location: /TFG/login.php');
}


$ref = $_GET['id'];

Almacenaje::borrar($ref);

header('Location: webInventario.php')
?>