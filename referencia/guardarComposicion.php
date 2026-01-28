<?php
require_once __DIR__ . '/../bd/composicion.php';
require_once __DIR__ . '/../bd/componente.php';

session_start();

$composicion= new Composicion();

$composicion->idreferenciapcb= $_POST['referenciapcb'];
$composicion->referenciaFabricante= $_POST['referenciaFabricante'];
$composicion->posicion= $_POST['posicion'];

$errores = [];
if ($composicion->referenciaFabricante == '') {
    $errores['referenciaFabricante'] = "Referencia del fabricante requerida";
}
else {
    $existente = Componente::carga($composicion->referenciaFabricante);
    if (!$existente) {
        $errores['referenciaFabricante'] = "No existe un componente con esa referencia";        
    }
}


if ($composicion->posicion == '') {
    $errores['posicion'] = "Posicion requerida";
}
else{
    $esta = Composicion::esta($composicion->idreferenciapcb,$composicion->posicion);
    if ($esta==1) {
        $errores['posicion'] = "Ya hay un componente en esa posicion";
    }
}

if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['datos']= $composicion;
    header('Location: addComp.php');
}
else{
    $composicion->insertar();
    header('Location: addComp.php');
}
