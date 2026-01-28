<?php
require_once __DIR__ . '/../bd/proveedor.php';
require_once __DIR__ . '/../bd/usuario.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    if($usuario->admin == 0){
        http_response_code(403);
        die("Error no tienes permisos para acceder ahi");
    }
}
else {
    $usuario = null;
    header('Location: /TFG/login.php');
}

$id = $_GET['id'];

$proveedor = Proveedor::cargaProv($id);
unlink('../imagenes/proveedor/'.$proveedor->idproveedor.'_'.$proveedor->logo);
Proveedor::borrar($id);

header('Location: webProv.php')

?>