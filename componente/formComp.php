<?php

    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/componente.php';
    require_once __DIR__ . '/../bd/tipocomponente.php';
    require_once __DIR__ . '/../bd/categoria.php';
    require_once __DIR__ . '/../bd/proveedor.php';
    require_once __DIR__ . '/../lib/funciones.php';

    
    session_start();
    
    require_once __DIR__ . '/../bd/usuario.php';

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
        $componente = $_SESSION['datos']; //guardar los datos escritos por si hay errores en otros campos
        unset($_SESSION['errores']); // quitamos los errores y los datos de la sesión
        unset($_SESSION['datos']); // para que no aparezcan la próxima vez
    }
    else {
        $errores = []; // array vacío
        $componente = new componente();  
    }

    $listaProveedores = Proveedor::listadoP();
    $listaComponentes = TipoComponente::listadoComp();

    $tituloPagina = "Añadir Componete";
    $pagina="comp";
    
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>
    <h1>Añadir nuevo componente</h1>
    <br>
    <form action="guardarComp.php" method="POST" class="row g-3"enctype="multipart/form-data" >
        <div class="col">
            <div >
                <label class="form-label" for="nombre">
                    Referencia Fabricante:
                </label>
                <input type="text" id="referencia" name="referencia"
                    class="form-control 
                        <?php if (isset($errores['referencia'])) echo 'is-invalid'; ?>" 
                    placeholder="Referencia del fabricante" 
                    value="<?= e($componente->referenciaFabricante) ?>" >
                        <?php if (isset($errores['referencia'])): ?>
                                <div class="invalid-feedback">
                                    <?= e($errores['referencia']) ?>
                                </div>
                        <?php endif; ?>
            </div>
            <br>
            <div>
                <label class="form-label" for="tipocomponente">
                    Seleccione el tipo de componente:
                </label>
                <select id="tipocomponente" name="tipocomponente" class="form-select">
                    <?php foreach ($listaComponentes as $lc): ?>
                        <option value="<?= $lc->idtipocomponente?>"
                            <?= ($lc->idtipocomponente == $componente->idtipocomponente) ? "selected" : "" ?>         
                        >
                            <?= e($lc->nombre .' ('. $lc->nombreCat .')')?>  
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <div>
                <label class="form-label" for="nombre">
                    Nombre:
                </label>
                <input type="text" id="nombre" name="nombre"
                    class="form-control 
                    <?php if (isset($errores['nombre'])) echo 'is-invalid'; ?>"
                    placeholder="Nombre del componente"
                    value="<?= e($componente->nombre) ?>"/>
                        <?php if (isset($errores['nombre'])): ?>
                            <div class="invalid-feedback">
                                <?= e($errores['nombre']) ?>
                            </div>
                        <?php endif; ?>
            </div>
            <br>
            <div>
                <label class="form-label" for="dimension">
                    Dimensiones/Tamaño:
                </label>
                <input type="text" id="dimension" name="dimension"
                    class="form-control 
                    <?php if (isset($errores['dimension'])) echo 'is-invalid'; ?>" 
                    placeholder="Dimensiones del componente"
                    value="<?= e($componente->dimensiones) ?>"/>
                        <?php if (isset($errores['dimension'])): ?>
                            <div class="invalid-feedback">
                                <?= e($errores['dimension']) ?>
                            </div>
                        <?php endif; ?>
            </div>
            <br>
            <div>
                <label class="form-label" for="caracteristicas">
                    Caracteristicas:
                </label>
                <textarea id="caracteristicas" name="caracteristicas"
                    class="form-control 
                        <?php if (isset($errores['caracteristicas'])) echo 'is-invalid'; ?>" 
                    placeholder="Caracteristicas" rows="10"
                    ><?= e($componente->caracteristicas) ?></textarea>
                        <?php if (isset($errores['caracteristicas'])): ?>
                                <div class="invalid-feedback">
                                    <?= e($errores['caracteristicas']) ?>
                                </div>
                        <?php endif; ?>
            </div>
            <br>
            <div>
                <label class="form-label" for="proveedor">
                    Seleccione al proveedor:
                </label>
                <select id="proveedor" name="proveedor" class="form-select">
                    <?php foreach ($listaProveedores as $lp): ?>
                        <option value="<?= $lp->idproveedor?>"
                            <?= ($lp->idproveedor == $componente->idproveedor) ? "selected" : "" ?>         
                        >
                            <?= e($lp->nombre)?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <p>Imagen del componente:</p>
            <input type="file" id="foto" name="foto" class="form-control
                <?php if (isset($errores['foto'])) echo 'is-invalid'; ?>"
            /><br>
                <?php if (isset($errores['foto'])): ?>
                        <div class="invalid-feedback">
                            <?= e($errores['foto']) ?>
                        </div>
                    <?php endif; ?>
            <img id="imagen"  src="/TFG/imagenes/comunes/gris.jpg" 
                style="max-height: 300px" class="img-fluid rounded figure-img"/>
            <p>Arrastrar una foto en la parte gris.</p>
        </div>

        <div class="col-md-12 text-center">
            <br>
            <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Guadar</button>
            <a href="/TFG/index.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a>
        </div>

    </form>

<?php include __DIR__.'/../include/scripts.php'; ?>

<script>
    const imagen = document.getElementById("imagen");
    const foto = document.getElementById("foto");

    foto.addEventListener("change", leerImagen);

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