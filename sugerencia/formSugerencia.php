<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/sugerencia.php';
    require_once __DIR__ . '/../lib/funciones.php';

    session_start();

    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
        if($usuario->admin==1){
            http_response_code(403);
            die("Error no tienes permisos para acceder ahi");
        }
    }
    else {
        $usuario = null;
        header('Location: /TFG/login.php');
    }

    if (isset($_SESSION['errores'])) {
        $errores = $_SESSION['errores']; // si hay errores que los guarde y los muestre por pantalla
        $sugerencia = $_SESSION['datos']; //guardar los datos escritos por si hay errores en otros campos
        unset($_SESSION['errores']); // quitamos los errores y los datos de la sesión
        unset($_SESSION['datos']); // para que no aparezcan la próxima vez
    }
    else {
        $errores = []; 
        $sugerencia = new sugerencia();  
    }

    $tituloPagina="Sugerencias";
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>

<h1>Nueva sugerencia:</h1>

<br>
<form action="guardarSug.php" method="POST" class="row g-3"enctype="multipart/form-data" >
    <d  iv class="col">
        <div>
            <label class="form-label" for="titulo">
                Titulo:
            </label>
            <input type="text" id="titulo" name="titulo"
                class="form-control 
                <?php if (isset($errores['titulo'])) echo 'is-invalid'; ?>"
                placeholder="Titulo de la sugerencia"
                value="<?= e($sugerencia->titulo) ?>"/>
                    <?php if (isset($errores['titulo'])): ?>
                        <div class="invalid-feedback">
                            <?= e($errores['titulo']) ?>
                        </div>
                    <?php endif; ?>
        </div>
        <br>
        <div>
            <label class="form-label" for="descripcion">
                Descripcion:
            </label>
            <textarea id="descripcion" name="descripcion"
                class="form-control 
                <?php if (isset($errores['descripcion'])) echo 'is-invalid'; ?>" 
                placeholder="Descripcion de la sugerencia" rows="10"
                ><?= e($sugerencia->descripcion) ?></textarea>
                    <?php if (isset($errores['descripcion'])): ?>
                        <div class="invalid-feedback">
                            <?= e($errores['descripcion']) ?>
                        </div>
                    <?php endif; ?>
        </div>
        <div class="col-md-12 text-center">
            <br>
            <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guadar</button>
            <a href="/TFG/sugerencia/webSugerencia.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a>
        </div>
    </div>
</form>

<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__ . '/../include/pie.php' ;?>

