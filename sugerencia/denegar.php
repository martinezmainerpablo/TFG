<?php
    require_once __DIR__ . '/../bd/sugerencia.php';
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

$idsugerencia = $_GET['id'];
$sugerencia = Sugerencia::cargar($idsugerencia);

$sugerencia->estado="R";

$sugerencia->actualizar();

header('Location: webSugerencia.php');