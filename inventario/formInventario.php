<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/inventario.php';
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
        $inventario = $_SESSION['datos']; //guardar los datos escritos por si hay errores en otros campos
        $usuarioN = $_SESSION['datosU']; //guardar los datos escritos por si hay errores en otros campos
        unset($_SESSION['errores']); // quitamos los errores y los datos de la sesión
        unset($_SESSION['datos']); // para que no aparezcan la próxima vez
    }
    else {
        $errores = []; // array vacío
        $inventario = new Inventario();  
        $usuarioN = new Usuario();
    }

    $tituloPagina = "Inventario";
    $pagina="inv";
    
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ .'/../include/menu.php';

?>

<h1>Añadir nuevo Inventario</h1>

<form action="guardarInventario.php" method="POST" class="row g-3">
    <div class="col">
        <div >
            <label class="form-label" for="nombre">
                Nombre
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="bi bi-shop-window"></i>                   
                    </span>
                </div>
                <input type="text" id="nombre" name="nombre"
                    class="form-control  
                        <?php if (isset($errores['nombre'])) echo 'is-invalid'; ?> " 
                    placeholder="Nombre" 
                    value="<?=e($inventario->nombre) ?>" >
                    <?php if (isset($errores['nombre'])): ?>
                        <div class="invalid-feedback">
                            <?= e($errores['nombre']) ?>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
        <br>
        <div>
            <label class="form-label" for="telefono">
                Telefono:
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="bi bi-telephone-fill"></i>
                    </span>
                </div>
                <input type="text" id="telefono" name="telefono"
                    class="form-control 
                    <?php if (isset($errores['telefono'])) echo 'is-invalid'; ?>" 
                    placeholder="Telefono"
                    value="<?=e($inventario->telefono) ?>"/>
                    <?php if (isset($errores['telefono'])): ?>
                        <div class="invalid-feedback">
                            <?= e($errores['telefono']) ?>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
        <br>
        <h1>Creación del Usuario</h1>
        <div>
            <label class="form-label" for="email">
                Correo electronico:
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="bi bi-person-fill"></i>
                    </span>
                </div>
                <input type="text" id="email" name="email"
                    class="form-control 
                    <?php if (isset($errores['email'])) echo 'is-invalid'; ?>" 
                    placeholder="Nombre del usuario"
                    value="<?=e($usuarioN->login) ?>"/>
                    <?php if (isset($errores['email'])): ?>
                        <div class="invalid-feedback">
                            <?= e($errores['email']) ?>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
        <br>
        <div>
            <label class="form-label" for="pwd">
                Contraseña:
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="bi bi-key-fill"></i>
                    </span>
                </div>
                <input type="password" name="pwd" id="pwd"
                class="form-control
                <?php if(isset($errores['pwd'])) echo 'is-invalid'; ?>"
                placeholder="Contraseña" 
                value="<?=e($usuarioN->pwd) ?>"/>
                <?php if (isset($errores['pwd'])): ?>
                    <div class="invalid-feedback">
                        <?=e($errores['pwd']) ?>
                    </div>
                <?php endif;?>
                <span class="input-group-text btn" >
                    <i class="bi bi-eye-fill" id="check"></i>
                </span>
            </div>
        </div>               
    </div>

    <div class="col-md-12 text-center">
        <br>
        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guardar</button>
        <a href="webInicioInv.php" class="btn btn-success "><i class="bi bi-box-arrow-in-left"></i> Volver</a>
    </div>
</form>

<?php include __DIR__.'/../include/scripts.php'; ?>

<script>

    //esta funcion es para cuando pulsas en el ojo poder ver la contraseña que hay escrita
    var pwd = document.getElementById("pwd");
    var check = document.getElementById("check");
    check.addEventListener("click", function() {
        if (pwd.type === "password") {
            pwd.type= "text";
            check.classList= "bi bi-eye-slash-fill";
        } 
        else {
            pwd.type= "password";
            check.classList= "bi bi-eye-fill";
        }            
    });

</script>

<?php include __DIR__ . '/../include/pie.php'; ?>