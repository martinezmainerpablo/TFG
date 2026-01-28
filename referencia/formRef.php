<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/referenciapcb.php';
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
        $refernciapcb = $_SESSION['datos']; //guardar los datos escritos por si hay errores en otros campos
        unset($_SESSION['errores']); // quitamos los errores y los datos de la sesión
        unset($_SESSION['datos']); // para que no aparezcan la próxima vez
    }
    else {
        $errores = []; // array vacío
        $refernciapcb = new ReferenciaPCB();  
    }
        
    $tituloPagina = "Referencias PCB";
    $pagina="ref";
    
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>
<h3>Añadir referencia PCB</h3><br>

<form action="guardarRef.php" method="POST" class="row g-3"enctype="multipart/form-data" >
    <div class="col">
        <div >
            <label class="form-label" for="nombre">
                Referencia PCB:
            </label>
            <input type="text" id="nombre" name="nombre" autofocus
                class="form-control 
                    <?php if (isset($errores['nombre'])) echo 'is-invalid'; ?>" 
                placeholder="Referencia PCB" 
                value="<?= e($refernciapcb->nombre) ?>" >
            <?php if (isset($errores['nombre'])): ?>
                <div class="invalid-feedback">
                    <?= e($errores['nombre']) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-12 text-center"><br>
            <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guadar</button>
            <a href="webRef.php" class="btn btn-success "><i class="bi bi-box-arrow-in-left"></i> Volver</a>
        </div>
    </div>    
</form>

<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__.'/../include/pie.php'; ?>