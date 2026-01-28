<?php
require_once __DIR__ . '/../bd/usuario.php';
require_once __DIR__ . '/../bd/sugerencia.php';

session_start();


if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
else {
    header('Location: /TFG/login.php');
}

$sugerencia = new Sugerencia();
$sugerencia->titulo= $_POST['titulo'];
$sugerencia->descripcion = $_POST['descripcion'];
$sugerencia->estado="P";
$sugerencia->idusuario= $usuario->idusuario;

$errores = [];
if ($sugerencia->titulo == '') {
    $errores['titulo'] = "Titulo de la sugerencia requerido";
}

if ($sugerencia->descripcion == '') {
    $errores['descripcion'] = "Descripción de la sugerencia requerida";
}

if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['datos']= $sugerencia;
    header('Location: formSugerencia.php');
}
else{
    $sugerencia->insertar();
    header('Location: /TFG/sugerencia/webSugerencia.php');
}
