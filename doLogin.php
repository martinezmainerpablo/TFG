<?php
require_once __DIR__ . '/bd/usuario.php';
session_start();

$login = $_POST['login'];
$pwd = $_POST['pwd'];

$usuario = Usuario::cargaLogin($login);

if ($usuario) {
    if (password_verify($pwd, $usuario->pwd)) {
        $_SESSION['usuario'] = $usuario;
        if($usuario->admin==1){
            header('Location: index.php');
        }
        else{
            header('Location: /TFG/inventario/webInventario.php');
        }
        die();
    }
}

$_SESSION['error-login'] = "Nombre de usuario o contraseña incorrectos";
header('Location: login.php');
