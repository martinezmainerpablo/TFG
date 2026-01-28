<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/componente.php';
    require_once __DIR__ . '/../lib/funciones.php';
  
    session_start();
    require_once __DIR__ . '/../bd/usuario.php';
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    }
    else {
        $usuario = null;
        header('Location: /TFG/login.php');
    }
    
    $id=$_GET['id'];
    $comp=Componente::buscar($id);
  
    $tituloPagina = "Ver Componete";
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>
<h1><?=$comp->nombreComp?></h1>
<br>
<br>
<table class="mx-auto">
    <tbody>
        <tr>
            <td class="px-5">
                <img src="<?="/TFG/imagenes/componentes/".$comp->referencia.'_'.$comp->imagen?>" height=320px width=320px/>
            </td>
            <td class="px-5">
                <h5><strong>Proveedor:</strong> <?=e($comp->nombreProv)?>.</h5>
                <h5><strong>Referencia Fabricante:</strong> <?=e($comp->referencia)?>.</h5>
                <h5><strong>Tipo de componente:</strong> <?=e($comp->nombreTipo)?>.</h5>
                <h5><strong>Dimensiones/Tamaño:</strong> <?=e($comp->dimensiones)?>.</h5>
                <h5><strong>Caracteristicas:</strong></h5>
                <textarea rows="10" cols="80" style="font-size:18px;" disabled><?=e($comp->caracteristicas)?></textarea>
            </td>
        </tr>
    </tbody>
</table>

<div class="col-md-12 text-center">
    <a href="/TFG/index.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a>
</div>

<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__.'/../include/pie.php'; ?>