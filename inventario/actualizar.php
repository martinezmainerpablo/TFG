<?php

require_once __DIR__ . '/../bd/almacenaje.php';
require_once __DIR__ . '/../bd/usuario.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    if($usuario->admin == 1){
        http_response_code(403);
        die("Error no tienes permisos para acceder ahi");
    }
}
else {
    $usuario = null;
    header('Location: /TFG/login.php');
}


$idalmacenaje = $_GET['id'];
$almacenaje = Almacenaje::cargar($idalmacenaje);

$almacenaje->stock=$_POST['stock'];

$almacenaje->actualizar();

header('Location: webInventario.php');