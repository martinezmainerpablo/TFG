<?php
require_once __DIR__ . '/../bd/usuario.php';
require_once __DIR__ . '/../bd/inventario.php';
session_start();

$inventario= new Inventario();
$usuario= new Usuario();

$inventario->nombre=$_POST['nombre'];
$inventario->telefono=$_POST['telefono'];

$usuario->nombre=$_POST['nombre'];
$usuario->login=$_POST['email'];
$usuario->pwd = $_POST['pwd'];
$usuario->admin=0;

$errores = [];

if ($inventario->nombre == '') {
    $errores['nombre'] = "Nombre requerido";
}
else {
    $existente = Inventario::cargaNom($inventario->nombre);
    if ($existente) {
        $errores['nombre'] = "Ya existe un inventario con este nombre";        
    }
}

if ($inventario->telefono == '') {
    $errores['telefono'] = "Telefono requerido";
}
else{
    if(!is_numeric($inventario->telefono)){
        $errores['telefono'] = "Has introducido letras en el telefono";
    }
    else{
        $existente = Inventario::cargaTel($inventario->telefono);
        if ($existente) {
            $errores['telefono'] = "Ya existe un inventario con este telefono";        
        }
    }
}


if ($usuario->login == '') {
    $errores['email'] = "Correo electronico requerido";
}
else{
    if(filter_var($usuario->login,FILTER_VALIDATE_EMAIL)== false ){
        $errores['email'] = "Correo electronico erroneo";
    }
    else{
        $existente = Usuario::cargaEm($usuario->login);
        if ($existente) {
            $errores['email'] = "Ya existe un usuario con este correo electronico";        
        }  
    }
}

if ($usuario->pwd == '') {
    $errores['pwd'] = "Contraseña requerida";
}

if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['datos']= $inventario;
    $_SESSION['datosU']= $usuario;
    header('Location: formInventario.php');
}
else{  
    $usuario->pwd = password_hash($usuario->pwd, PASSWORD_DEFAULT);
    $usuario->insertar();
    $inventario->idusuario=$usuario->idusuario;
    $inventario->insertar();
    header('Location: webInicioInv.php');
}