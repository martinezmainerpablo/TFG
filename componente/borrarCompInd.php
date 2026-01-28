<?php
require_once __DIR__ . '/../bd/componente.php';
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

$ref = $_GET['referencia'];

$componente=Componente::cargarComp($ref);
unlink('../imagenes/componentes/'.$componente->referenciaFabricante.'_'.$componente->imagen);
Componente::borrar($ref);

header('Location: /TFG/index.php')
?>