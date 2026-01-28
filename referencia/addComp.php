<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/composicion.php';
    require_once __DIR__ . '/../bd/referenciapcb.php';
    require_once __DIR__ . '/../lib/funciones.php';
    session_start();
    
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
        if($usuario->admin == 0){
            $listaReferencias = ReferenciaPCB::listadoFilt($usuario->idusuario);           
        }
        else{
            $listaReferencias = ReferenciaPCB::listado(); 
        }
    }
    else {
        $usuario = null;
        header('Location: /TFG/login.php');
    }
   

    if (isset($_SESSION['errores'])) {
        $errores = $_SESSION['errores']; // si hay errores que los guarde y los muestre por pantalla
        $composicion = $_SESSION['datos']; //guardar los datos escritos por si hay errores en otros campos
        unset($_SESSION['errores']); // quitamos los errores y los datos de la sesión
        unset($_SESSION['datos']); // para que no aparezcan la próxima vez
    }
    else {
        $errores = []; // array vacío
        $composicion = new Composicion();  
    }
    
    $tituloPagina = "Referencias PCB";
    $pagina="ref";

    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ .'/../include/menu.php';   
    
?>

<h3>Añadir componente a la Referencia</h3>
<br>

<form action="guardarComposicion.php" method="POST" class="row g-4">   
    <div>
        <label class="form-label" for="referenciapcb">
            Seleccione una Referencia PCB:
        </label>
        <select id="referenciapcb" name="referenciapcb" class="form-select">
            <?php foreach ($listaReferencias as $lp): ?>
                <option value="<?= $lp->idreferenciapcb?>"
                    <?= ($lp->idreferenciapcb == $composicion->idreferenciapcb) ? "selected" : ""?>         
                >
                    <?= e($lp->nombre)?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>   

    <div class="col-6">
        <label class="form-label" for="referenciaFabricante">
            Referencia del Componente:
        </label>       
        <input type="text" id="referenciaFabricante" name="referenciaFabricante" autofocus 
            class="form-control 
            <?php if (isset($errores['referenciaFabricante'])) echo 'is-invalid'; ?>" 
            placeholder="Referencia del componente" 
            value="<?= e($composicion->referenciaFabricante) ?>" />
            <?php if (isset($errores['referenciaFabricante'])): ?>
                <div class="invalid-feedback">
                    <?= e($errores['referenciaFabricante']) ?>
                </div>
            <?php endif; ?>
    </div>

    <div class="col-6">
        <label class="form-label" for="posicion">
            Posicion:
        </label>
        <input type="text" id="posicion" name="posicion"
            class="form-control 
            <?php if (isset($errores['posicion'])) echo 'is-invalid'; ?>" 
            placeholder="Posicion" 
            value="<?= e($composicion->posicion) ?>" />
            <?php if (isset($errores['posicion'])): ?>
                <div class="invalid-feedback">
                    <?= e($errores['posicion']) ?>
                </div>
            <?php endif; ?>           
    </div>

    <div class="col-md-12 text-center"><br>
        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guadar</button>
        <a href="buscarRef.php" class="btn btn-success"><i class="bi bi-search"></i> Buscar</a>
        <a href="formRef.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Añadir nueva Referencia</a>
        <a href="webRef.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a>
    </div>

</form>
<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__.'/../include/pie.php'; ?>