<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/componente.php';
    require_once __DIR__ . '/../bd/almacenaje.php';
    require_once __DIR__ . '/../lib/funciones.php';
    session_start();

    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    }
    else {
        $usuario = null;
        header('Location: /TFG/login.php');
    }

    $idcomponente = $_GET['id']; //id del componente
    $componente= Almacenaje::cargar($idcomponente);
     
    $tituloPagina = "Inventario";
    $pagina="inv";
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>

<br>
<form action="actualizar.php?id=<?= $idcomponente?>" method="POST" class="row g-3">    
    <div class="col-4">
        <img src="/TFG/imagenes/componentes/<?=$componente->referencia?>_<?=$componente->imagen?>" />
    </div>
    <div class="col-8">
        <div >
            <label class="form-label" for="referencia">
                Referencia del Fabricante:
            </label>
            <input type="text" disabled
                class="form-control"
                value="<?=e($componente->referencia)?>"/>
        </div>
        <br>
        <div>
            <label class="form-label" for="nombre">
                Nombre:
            </label>
            <input type="text" disabled
                class="form-control"
                value="<?=e($componente->nombre)?>"/>
        </div>
        <br>
        <div>
            <label class="form-label" for="ubicacion">
                Ubicacion:
            </label>
            <input type="text" disabled
                class="form-control"
                value="<?=e($componente->ubicacion)?>"/>
        </div>
        <br>
        <div>
            <label class="form-label" for="stock">
                Cantidad:
            </label>
            <input type="number" id="stock" name="stock" min="0" autofocus 
                class="form-control"
                value="<?=e($componente->stock)?>"/>
        </div>
    </div>

    <div class="col-md-12 text-center">
        <br>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="webInventario.php" class="btn btn-success ">Volver</a>
    </div>

</form>

<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__.'/../include/pie.php'; ?>