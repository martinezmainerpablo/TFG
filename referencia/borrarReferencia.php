<?php
require_once __DIR__ . '/../bd/referenciapcb.php';
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

ReferenciaPCB::borrar($id);

header('Location: buscarRef.php')
?>