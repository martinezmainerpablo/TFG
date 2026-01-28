<?php
require_once __DIR__ . '/../bd/usuario.php';
require_once __DIR__ . '/../bd/almacenaje.php';
require_once __DIR__ . '/../bd/inventario.php';
require_once __DIR__ . '/../bd/componente.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
else {
    header('Location: /TFG/login.php');
}

$almacenaje= new Almacenaje();

$almacenaje->referenciaFabricante= $_POST['referencia'];
$almacenaje->stock= $_POST['stock'];
$almacenaje->ubicacion= $_POST['ubicacion'];

if($usuario->admin==1){
    $almacenaje->idinventario=$_POST['inventario'];
}
else{
    $inv=Inventario::buscarInv($usuario->idusuario);
    $almacenaje->idinventario= $inv;
}

$errores = [];
if ($almacenaje->referenciaFabricante == '') {
    $errores['referencia'] = "Referencia del fabricante requerida";
}
else {
    $existente = Componente::carga($almacenaje->referenciaFabricante);
    if (!$existente) {
        $errores['referencia'] = "No existe un componente con esa referencia";        
    }
}

if ($almacenaje->stock == '') {
    $errores['stock'] = "Cantidad requerido";
}

if ($almacenaje->ubicacion == '') {
    $errores['ubicacion'] = "Ubicacion del componente requerida";
}
else{
    $esta = Almacenaje::ocupado($almacenaje->idinventario,$almacenaje->ubicacion);
    if($esta==1){
        $errores['ubicacion'] = "Esta ubicacion ya la tiene otro componente";  
    }
}


if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['datos']= $almacenaje;
    header('Location: addComponente.php');
}
else{
    $almacenaje->insertar();
    
    if($usuario->admin==1){
        header('Location: webInicioInv.php');
    }
    else{
        header('Location:  webInventario.php');
    }
}
