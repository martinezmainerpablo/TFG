<?php
require_once __DIR__ . '/../bd/componente.php';
session_start();

$componente= new Componente();

$componente->referenciaFabricante=$_POST['referencia'];
$componente->idtipocomponente=$_POST['tipocomponente'];
$componente->nombre=$_POST['nombre'];
$componente->caracteristicas=$_POST['caracteristicas'];
$componente->dimensiones=$_POST['dimension'];
$componente->idproveedor=$_POST['proveedor'];

$errores = [];
if ($componente->referenciaFabricante == '') {
    $errores['referencia'] = "Referencia del fabricante requerida";
}
else {
    $existente = Componente::carga($componente->referenciaFabricante);
    if ($existente) {
        $errores['referencia'] = "Ya existe un componente con esa referencia";        
    }
}

if ($componente->nombre == '') {
    $errores['nombre'] = "Nombre requerido";
}

if ($componente->caracteristicas == '') {
    $errores['caracteristicas'] = "Caracteristicas requeridas";
}

if ($componente->dimensiones == '') {
    $errores['dimension'] = "Dimensiones o tamaño requerido";
}


$foto = $_FILES['foto'];
//esto es para comrpobar si ha sido fichero, si lo ha echo lo introducimos a la base de datos si se ha subido bien
//nos la guardara en la base y en la carpeta que le hemos indicado
if ($foto['error'] == UPLOAD_ERR_OK) {
    if (str_starts_with($foto['type'], 'image/')) {
        $componente->imagen=$foto['name'];
        $dest = '../imagenes/componentes/' . $foto['name'];
        move_uploaded_file($foto['tmp_name'], $dest);            
    }
    else {
        $errores['foto'] = "El archivo no es una imagen válida";
    }
}
else if ($foto['error'] == UPLOAD_ERR_NO_FILE) {
    $errores['foto'] = "Selecciona una foto";
}
else {
    $errores['foto'] = "Error subiendo foto";
}

if(count($errores) > 0){
    $_SESSION['errores'] = $errores;
    $_SESSION['datos']= $componente;
    unlink('../imagenes/componentes/'.$componente->imagen);
    header('Location: formComp.php');
}

else{
    $componente->insertar();
    rename('../imagenes/componentes/'.$foto['name'], '../imagenes/componentes/'.$componente->referenciaFabricante.'_'.$foto['name'] );
    header('Location: webComponente.php?id='.$componente->idtipocomponente);
}

