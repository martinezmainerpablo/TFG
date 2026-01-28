<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/inventario.php';
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
    
    if (isset($_SESSION['errores'])) {
        $errores = $_SESSION['errores']; // si hay errores que los guarde y los muestre por pantalla
        $almacenaje = $_SESSION['datos']; //guardar los datos escritos por si hay errores en otros campos
        unset($_SESSION['errores']); // quitamos los errores y los datos de la sesión
        unset($_SESSION['datos']); // para que no aparezcan la próxima vez
    }
    else {
        $errores = []; // array vacío
        $almacenaje = new Almacenaje();
    }
    
    $listaInv = Inventario::listadoSelect();
    
    $tituloPagina = "Inventario";
    $pagina="inv";
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ .'/../include/menu.php';
    
?>

<form action="guardarComp.php" method="POST" class="row g-3"enctype="multipart/form-data">
    <div>
        <h2>Añadir componente al inventario:</h2>
    </div>
    
    <div class="col">
        <?php if($usuario->admin==1) :?>
            <label  class="form-label" for="inventario">
            Selecciona un inventario:
            </label>
            <select id="inventario" name="inventario" class="form-select" autofocus>
            <?php foreach ($listaInv as $li): ?>
                <option value="<?= $li->idinventario?>"
                    <?= ($li->idinventario == $almacenaje->idinventario) ? "selected" : "" ?>         
                >
                    <?= e($li->nombre)?>
                </option>
            <?php endforeach; ?>
            </select>
        <?php endif;?>  

        <br>
        <div >
            <label class="form-label" for="nombre">
                Referencia Fabricante:
            </label>
            <input type="text" id="referencia" name="referencia" 
                class="form-control 
                <?php if (isset($errores['referencia'])) echo 'is-invalid'; ?>" 
                    placeholder="Referencia del fabricante" 
                    value="<?= e($almacenaje->referenciaFabricante) ?>" >
                <?php if (isset($errores['referencia'])): ?>
                    <div class="invalid-feedback">
                        <?= e($errores['referencia']) ?>
                    </div>
                <?php endif; ?>
        </div>
        <br>
        <div>
            <label class="form-label" for="stock">
                Cantidad:
            </label>
            <input type="number" id="stock" name="stock" min="0" 
                class="form-control 
                <?php if (isset($errores['stock'])) echo 'is-invalid'; ?>" 
                    placeholder="Stock disponible"
                    value="<?= e($almacenaje->stock) ?>"/>
                <?php if (isset($errores['stock'])): ?>
                    <div class="invalid-feedback">
                        <?= e($errores['stock']) ?>
                    </div>
                <?php endif; ?>
        </div>
        <br>
        <div>
            <label class="form-label" for="ubicacion">
                Ubicacion:
            </label>
            <input type="text" id="ubicacion" name="ubicacion"
                class="form-control 
                <?php if (isset($errores['ubicacion'])) echo 'is-invalid'; ?>" 
                    placeholder="Ubicacion del componente"
                    value="<?= e($almacenaje->ubicacion) ?>"/>
                <?php if (isset($errores['ubicacion'])): ?>
                    <div class="invalid-feedback">
                        <?= e($errores['ubicacion']) ?>
                    </div>
                <?php endif; ?>
        </div>
    </div>
    <div class="col-md-12 text-center">
        <br><br>
        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guadar</button>
        <?php if($usuario->admin==1) :?>
            <a href="webInicioInv.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a>
        <?php else :?>
            <a href="webInventario.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a>
        <?php endif ;?>    
    </div> 
</form>

<?php include __DIR__. '/../include/scripts.php';?>


<?php include __DIR__.'/../include/pie.php'; ?>