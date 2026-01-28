<?php
require_once __DIR__ . '/../bd/composicion.php';
require_once __DIR__ . '/../bd/usuario.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    
}
else {
    $usuario = null;
    header('Location: /TFG/login.php');
}


$id = $_GET['id'];
$ref = $_GET['composicion'];

Composicion::borrar($ref);

header('Location: verComponentes.php?id='.$id)
?>