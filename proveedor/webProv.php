<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/proveedor.php';
    require_once __DIR__ . '/../bd/componente.php';
    require_once __DIR__ . '/../lib/funciones.php';

    session_start();
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    }
    else {
        $usuario = null;
        header('Location: /TFG/login.php');
    }

    /*Numero de paginas*/
    if (isset($_GET['pag'])) {
        $pag = $_GET['pag'];
    }
    else {
        $pag = 1;
    }

    $proveedores= Proveedor::listado($pag);
    $proveedoresBusca= Proveedor::listadoBusca();


    $numProveedores= Proveedor::cuenta();
    $numPaginas = ceil($numProveedores/ TAM_PROV);

    $tituloPagina = "Proveedoress";
    $pagina="prov";

    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';
    
?>
<a href="/TFG/sugerencia/webSugerencia.php" class="boton-sug">
    <img src="/TFG/imagenes/comunes/sug.png" alt="Icono de sugerencia" style="width: 40px; height: 40px;" />
</a>
<h1>Proveedores</h1>
<br>

<div class="row">
    <div class="col-11 d-flex align-items-center">
        <input type="text" id="buscador" class="form-control" placeholder="Buscar proveedor">
    </div>
    <div class="col-1 d-flex align-items-center justify-content-center">
        <span title="Puedes buscar por el nombre del proveedor"> 
            <i class="bi bi-info-circle" style="font-size: 24px;"></i>
        </span>
    </div>
</div>

<br>
<div class="table-responsive">
    <table class="table text-center align-middle" id="tabla">
        <thead class="table-primary">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Direccion</th>
                <th>
                    <?php if ($usuario->admin==1) :?>
                        <a href="formProv.php" class="btn btn-primary btn-sm"><i class="bi bi-person-fill-add"></i> Nuevo Proveedor</a>
                    <?php endif; ?>   
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proveedores as $prov) : ?>
                <tr>
                    <td><img src="<?="/TFG/imagenes/proveedor/".$prov['idproveedor'].'_'.$prov['logo']?>" 
                        height=42px width=115px alt="Logo de <?= e($prov['nombre']) ?>"/>
                    </td>
                    <td><?=e($prov['nombre']) ?></td>
                    <td><?=e($prov['telefono']) ?>/<?= e($prov['email']) ?></td>
                    <td><?=e($prov['direccion']) ?></td>
                    <td>
                        <?php if ($usuario->admin==1 && Componente::buscarProv($prov['idproveedor'])==0) : ?>
                            <button type="button" data-bs-toggle="modal"
                                data-bs-target="#modal<?= $prov['idproveedor']?>" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        <?php endif; ?>   
                    </td>
                </tr>   

                <!-- Modal para poder borrar un proveedor -->               
                <div class="modal fade" id="modal<?= $prov['idproveedor']?>" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Borrar Proveedor</h5>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres borrar al proveedor <strong><?= e($prov['nombre']) ?></strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="borrarProveedor.php?id=<?=$prov['idproveedor']?>" 
                                    class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Borrar proveedor
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>                
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Tabla oculta, solo aparece cuando pulsas en el input de busqueda -->
<div class="table-responsive">
    <table class="table text-center align-middle" id="tablaBusca" style="display: none;">
        <thead class="table-primary">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Direccion</th>
                <th>
                    <?php if ($usuario->admin==1) :?>
                        <a href="formProv.php" class="btn btn-primary btn-sm"><i class="bi bi-person-fill-add"></i> Nuevo Proveedor</a>
                    <?php endif; ?>   
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proveedoresBusca as $provB) : ?>
                <tr>
                    <td><img src="<?="/TFG/imagenes/proveedor/".$provB['idproveedor'].'_'.$provB['logo'] ?>" 
                        height=42px width=115px alt="Logo de <?= e($provB['nombre']) ?>"/>
                    </td>
                    <td><?=e($provB['nombre']) ?></td>
                    <td><?=e($provB['telefono']) ?>/<?= e($provB['email']) ?></td>
                    <td><?=e($provB['direccion']) ?></td>
                    <td>
                        <?php if ($usuario->admin==1 && Componente::buscarProv($provB['idproveedor'])==0) : ?>
                            <button type="button" data-bs-toggle="modal"
                                data-bs-target="#modal<?= $provB['idproveedor']?>" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        <?php endif; ?>   
                    </td>
                </tr>   

                <!-- Modal para poder borrar un proveedor -->               
                <div class="modal fade" id="modal<?= $provB['idproveedor']?>" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Borrar Proveedor</h5>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres borrar al proveedor <strong><?= e($provB['nombre']) ?></strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="borrarProveedor.php?id=<?=$provB['idproveedor']?>" 
                                    class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Borrar proveedor
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancelar 
                                </button>
                            </div>
                        </div>
                    </div>
                </div>                
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br>

<!--paginacion-->
<nav id="pag" style="display:block;"> 
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($pag == 1) echo 'disabled';?> ">                    
            <a class="page-link" href="webProv.php?pag=<?=$pag-1?>" >
                &lt;&lt;
            </a>
        </li>
        <?php for($i=1; $i<=$numPaginas; $i++): ?>
            <li class="page-item <?php if($pag == $i) echo 'active';?>">
                <a class="page-link" href="webProv.php?pag=<?=$i?>">
                    <?= $i?>
                </a>
            </li>
        <?php endfor;?>
        <li class="page-item <?= ($pag >= $numPaginas)  ? "disabled" : "" ?> ">
            <a class="page-link" href="webProv.php?pag=<?=$pag+1?>" >
                &gt;&gt;
            </a>
        </li>
    </ul>
</nav>

<?php include __DIR__ . '/../include/scripts.php'; ?>

<script>

    let navPag= document.getElementById("pag");
    let inputBuscar = document.getElementById("buscador");
    let tablaPag = document.getElementById("tabla");
    let tablaBusca= document.getElementById("tablaBusca");
    let columnas = tablaBusca.getElementsByTagName("tr"); //variabale para saber todas las columnas de la tabla para luego poder seleccionar una

    //esta funcion hace que busca en toda la tabla de proveedores pero solo por la columna de nombre
    function busqueda() {
        
        if (inputBuscar == document.activeElement) {
            navPag.style.display = "none";
        } 
        else {
            navPag.style.display = "block";
        }

        let busca = inputBuscar.value.toLowerCase();
        for (let i = 1; i < columnas.length; i++) { // Comienza  desde 1 para no contar el encabezado
            const celdas = columnas[i].getElementsByTagName("td");
            const nombreCelda = celdas[1]; //selecciona la celda por la que quiero buscar en este caso la 1 que es el nombre del proveedor, porque la 0 es la img
            if (nombreCelda) {
                const encontrada = nombreCelda.textContent || nombreCelda.innerText;
                columnas[i].style.display = encontrada.toLowerCase().includes(busca) ? "" : "none";
            }
        }

        if (busca != "") {
            tablaPag.style.display = "none"; //Oculta la primera tabla
            tablaBusca.style.display = "table"; // Mostra la segunda tabla
        } 
        else {
            tablaPag.style.display = "table"; // Vuelve la primera tabla
            tablaBusca.style.display = "none"; // Oculta la segunda tabla
        }
    }

    inputBuscar.addEventListener("focus", busqueda);  // mostrar la tabla completa con la busquda del input
    inputBuscar.addEventListener("blur", busqueda); //para cuando pulse fuera del input vuelva la tabla con la paginacion
    inputBuscar.addEventListener("input", busqueda); //para cuando escribo algo en el input cambie la tabla

</script>

<?php include __DIR__.'/../include/pie.php'; ?>
