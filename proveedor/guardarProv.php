<?php
require_once __DIR__ . '/../bd/proveedor.php';
session_start();

$proveedor= new Proveedor();

$proveedor->nombre=$_POST['nombre'];
$proveedor->email=$_POST['email'];
$proveedor->telefono=$_POST['telefono'];
$proveedor->direccion=$_POST['direccion'];

$errores = [];
if ($proveedor->nombre == '') {
    $errores['nombre'] = "Nombre requerido";
}
else {
    $existente = Proveedor::cargaNom($proveedor->nombre);
    if ($existente) {
        $errores['nombre'] = "Ya existe un proveedor con este nombre";        
    }
}


if ($proveedor->email == '') {
    $errores['email'] = "Correo electronico requerido";
}
else{
    if(filter_var($proveedor->email,FILTER_VALIDATE_EMAIL)== false ){
        $errores['email'] = "Correo electronico erroneo";
    }
    else{
        $existente = Proveedor::cargaEm($proveedor->email);
        if ($existente) {
            $errores['email'] = "Ya existe un proveedor con este correo electronico";        
        }  
    }
}

if ($proveedor->telefono == '') {
    $errores['telefono'] = "Telefono requerido";
}
else{
    if(!is_numeric($proveedor->telefono)){
        $errores['telefono'] = "Has introducido letras en el telefono";
    }
    else{
        $existente = Proveedor::cargaTel($proveedor->telefono);
        if ($existente) {
            $errores['telefono'] = "Ya existe un proveedor con este telefono";        
        }
    }    
}

if ($proveedor->direccion == '') {
    $errores['direccion'] = "Direccion requerida";
}
else {
    $existente = Proveedor::cargaDir($proveedor->direccion);
    if ($existente) {
        $errores['direccion'] = "Ya existe un proveedor con esta direccion";        
    }
}

$foto = $_FILES['foto'];
//esto es para comrpobar si ha sido fichero, si lo ha echo lo introducimos a la base de datos si se ha subido bien
//nos la guardara en la base y en la carpeta que le hemos indicado
if ($foto['error'] == UPLOAD_ERR_NO_FILE) {
    $errores['foto'] = "Selecciona una foto";
}
else if ($foto['error'] == UPLOAD_ERR_OK) {
    if (str_starts_with($foto['type'], 'image/')) {
        $proveedor->logo=$foto['name'];
        $dest = '../imagenes/proveedor/' . $foto['name'];
        move_uploaded_file($foto['tmp_name'], $dest);            
    }
    else {
        $errores['foto'] = "El archivo no es una imagen válida";
    }
}
else {
    $errores['foto'] = "Error subiendo foto";
}

if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['datos']= $proveedor;
    unlink('../imagenes/proveedor/'.$proveedor->logo);
    header('Location: formProv.php');
}
else{
    $proveedor->insertar();
    rename('../imagenes/proveedor/'.$foto['name'],'../imagenes/proveedor/'.$proveedor->idproveedor.'_'.$foto['name'] );
    header('Location: webProv.php');
}
