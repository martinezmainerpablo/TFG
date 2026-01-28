<?php
require_once __DIR__ . '/lib/funciones.php';

session_start();

$tituloPagina="Iniciar sesión";

include __DIR__ . '/include/cabecera.php';
?>


<div class="row">
    <div class="col-md-4 offset-md-4">
        <img src="/TFG/imagenes/comunes/logo.png" height=120px width=400px>
        <form action="doLogin.php" method="POST" class="row">
            <h1>Iniciar sesión</h1>
            <?php 
                if (isset($_SESSION['error-login'])):  ?>
                    <div class="alert alert-danger">
                        <?= e($_SESSION['error-login']) ?>
                    </div>
            <?php 
                    unset($_SESSION['error-login']);
                endif; ?>
            <div class="mb-3">
                <label class="form-label" for="login">
                    Nombre de usuario
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="bi bi-person-fill"></i>
                        </span>
                    </div>
                    <input type="text" id="login" name="login" autofocus
                        class="form-control" 
                        placeholder="Nombre" />
                </div>        
            </div>
            <div class="mb-3">
                <label class="form-label" for="pwd">
                    Contraseña
                </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="bi bi-key-fill"></i>
                        </span>
                    </div>
                    <input type="password" id="pwd" name="pwd"
                        class="form-control" 
                        placeholder="Contraseña" />
                        <span class="input-group-text btn" >
                            <i class="bi bi-eye-fill" id="check"></i>
                        </span>
                </div>    
            </div>
            
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-success">
                    Iniciar sesión
                </button>
            </div>  
        </form>
    </div>
</div>

<?php include __DIR__ . '/include/scripts.php' ;?>
<script>
    
    //esta funcion es para cuando pulsas en el ojo poder ver la contraseña que hay escrita
    var pwd = document.getElementById("pwd");
    var check = document.getElementById("check");
    check.addEventListener("click", function() {
        if (pwd.type === "password") {
            pwd.type = "text";
            check.classList="bi bi-eye-slash-fill";
        } 
        else {
            pwd.type = "password";
            check.classList="bi bi-eye-fill";
        }            
    });

</script>

<?php include __DIR__.'/include/pie.php'; ?>
