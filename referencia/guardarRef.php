<?php
require_once __DIR__ . '/../bd/usuario.php';
require_once __DIR__ . '/../bd/referenciapcb.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
else {
    header('Location: /TFG/login.php');
}

$referencia= new ReferenciaPCB();

$referencia->nombre=$_POST['nombre'];
$referencia->idusuario= $usuario->idusuario;

$errores = [];
if ($referencia->nombre == '') {
    $errores['nombre'] = "Referencia del pcb requerida";
}
else {
    $existente = ReferenciaPCB::carga($referencia->nombre);
    if ($existente) {
        $errores['nombre'] = "Ya existe una referencia con ese nombre";        
    }
}

if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['datos']= $referencia;
    header('Location: formRef.php');
}
else{
    $referencia->insertar();
    header('Location: addComp.php');
}

