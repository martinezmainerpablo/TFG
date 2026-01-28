<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/proveedor.php';
    require_once __DIR__ . '/../lib/funciones.php';

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

    if (isset($_SESSION['errores'])) {
        $errores = $_SESSION['errores']; // si hay errores que los guarde y los muestre por pantalla
        $proveedor = $_SESSION['datos']; //guardar los datos escritos por si hay errores en otros campos
        unset($_SESSION['errores']); // quitamos los errores y los datos de la sesión
        unset($_SESSION['datos']); // para que no aparezcan la próxima vez
    }
    else {
        $errores = [];
        $proveedor = new Proveedor();  
    }

    $tituloPagina = " Añadir Proveedor";
    $pagina="prov";
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';
?>
<h1>Añadir nuevo proveedor</h1><br>

<form action="guardarProv.php" method="POST" class="row g-3" enctype="multipart/form-data">
    <div class="col">
        <div >
            <label class="form-label" for="nombre">
                Nombre
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="bi bi-person-fill"></i>
                    </span>
                </div>
                <input type="text" id="nombre" name="nombre"
                    class="form-control  
                        <?php if (isset($errores['nombre'])) echo 'is-invalid'; ?> " 
                    placeholder="Nombre" 
                    value="<?= e($proveedor->nombre) ?>" >
                        <?php if (isset($errores['nombre'])): ?>
                                <div class="invalid-feedback">
                                    <?= e($errores['nombre']) ?>
                                </div>
                        <?php endif; ?>
            </div>
        </div>
        <br>
        <div>
            <label class="form-label" for="email">
                Correo electrónico
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="bi bi bi-envelope-fill"></i>
                    </span>
                </div>
                <input type="email" id="email" name="email"
                    class="form-control 
                    <?php if (isset($errores['email'])) echo 'is-invalid'; ?>"
                    placeholder="direccion@example.com"
                    value="<?= e($proveedor->email) ?>"/>
                        <?php if (isset($errores['email'])): ?>
                            <div class="invalid-feedback">
                                <?= e($errores['email']) ?>
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
                    value="<?= e($proveedor->telefono) ?>"/>
                        <?php if (isset($errores['telefono'])): ?>
                            <div class="invalid-feedback">
                                <?= e($errores['telefono']) ?>
                            </div>
                        <?php endif; ?>
            </div>
        </div>
        <br>
        <div>
            <label class="form-label" for="direccion">
                Direccion:
            </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="bi bi-signpost-fill"></i>
                    </span>
                </div>
                <input type="text" id="direccion" name="direccion"
                    class="form-control 
                    <?php if (isset($errores['direccion'])) echo 'is-invalid'; ?>"
                    placeholder="calle madrid 25"
                    value="<?= e($proveedor->direccion) ?>"/>
                        <?php if (isset($errores['direccion'])): ?>
                            <div class="invalid-feedback">
                                <?= e($errores['direccion']) ?>
                            </div>
                        <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col">
        <p>Logo del proveedor:</p>
        <input type="file" name="foto" class="form-control
            <?php if (isset($errores['foto'])) echo 'is-invalid'; ?>"
         id="foto" /><br>
            <?php if (isset($errores['foto'])): ?>
                    <div class="invalid-feedback">
                        <?= e($errores['foto']) ?>
                    </div>
                <?php endif; ?>
        <img id="imagen"  src="/TFG/imagenes/comunes/gris.jpg" 
            style="max-height: 300px" class="img-fluid rounded figure-img"/>
        <p>Arrastrar una foto en la parte gris</p>
    </div>
    
    <div class="col-md-12 text-center">
        <br>
        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guardar</button>
        <a href="webProv.php" class="btn btn-success "><i class="bi bi-box-arrow-in-left"></i> Volver</a>
    </div>

</form>

<?php include __DIR__.'/../include/scripts.php'; ?>

<script>
    const imagen = document.getElementById("imagen");
    const foto = document.getElementById("foto");

    foto.addEventListener("change", leerImagen);

    imagen.addEventListener("dragenter", function() {
        imagen.classList.add("border", "border-3", "border-primary");
    });

    imagen.addEventListener("dragleave", function() {
        imagen.classList.remove("border", "border-3", "border-primary");
    });

    imagen.addEventListener("dragover", function(e) {
        imagen.classList.add("border", "border-3", "border-primary");
        e.preventDefault();
    });

    imagen.addEventListener("drop", function(e) {
        if (e.dataTransfer.files) {
            foto.files = e.dataTransfer.files;
            leerImagen();
        }
        imagen.classList.remove("border", "border-3", "border-primary");
        e.preventDefault();
    });

    function leerImagen() {
        let f = foto.files[0];
        let reader = new FileReader();
        reader.onloadend = function() {
            let data = reader.result;
            imagen.src = data;            
        };
        reader.readAsDataURL(f);
    }
    
</script>

<?php include __DIR__.'/../include/pie.php'; ?>