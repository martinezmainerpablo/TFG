<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/componente.php';
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

    /*Numero de paginas*/
    if (isset($_GET['pag'])) {
        $pag = $_GET['pag'];
    }
    else {
        $pag = 1;
    }
    
    if($usuario->admin ==1){
        $id=$_GET['id'];
        $numComponentes = Almacenaje::cuentaFilt($id);
        $nombreInv=Inventario::nombre($id);
        $componentes= Almacenaje::listadoFiltAdm($id,$pag);
        $componentesBusca= Almacenaje::listadoFiltAdmBus($id);
    }
    else{
        $numComponentes = Almacenaje::cuenta($usuario->idusuario);
        $componentes= Almacenaje::listadoFilt($usuario->idusuario,$pag);
        $componentesBusca= Almacenaje::listadoFiltBus($usuario->idusuario);
    }

    $numPaginas = ceil($numComponentes/ TAM_COMP);
    
    $tituloPagina = "Inventario";
    $pagina="inv";

    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>

<a href="/TFG/sugerencia/webSugerencia.php" class="boton-sug">
    <img src="/TFG/imagenes/comunes/sug.png" alt="Icono de sugerencia" style="width: 40px; height: 40px;" />
</a>

<?php if ($usuario->admin==1): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"><h1><?= $nombreInv ?></h1></div>       
            <div class="col-md-4 offset-md-4"><a href="webInicioInv.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a></div>
        </div>
    </div>
<?php endif ;?>
<br>

<div class="row">
    <div class="col-11 d-flex align-items-center">
        <input type="text" id="buscador" name="buscador" class="form-control" placeholder="Buscador....."/>
    </div>
    <div class="col-1 d-flex align-items-center justify-content-center">
        <span title="Puedes buscar por referencia del fabricante, el nombre o la ubicacion"> 
            <i class="bi bi-info-circle" style="font-size: 24px;"></i>
        </span>
    </div>
</div>

<br>
<div class="table-responsive">
    <table class="table text-center align-middle" id="tabla">
        <thead class="table-success">
            <tr>
                <th></th>
                <th>Ref.Fabricante</th>
                <th>Nombre</th>
                <th>Dimensiones</th>
                <th>Ubicacion</th>
                <th>Stock</th>
                <th>
                    <?php if ($usuario->admin==0): ?>
                        <a href="addComponente.php" class="btn btn-sm btn-success"><i class="bi bi-box-arrow-in-left"></i> Añadir Comp</a></th>
                    <?php endif;?>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($componentes as $comp) : ?>    
                <tr>
                    <td><img src="<?="/TFG/imagenes/componentes/".$comp['referencia'].'_'.$comp['imagen']?>" height=60px width=60px/></td> 
                    <td><?=e($comp['referencia']) ?></td>
                    <td><?=e($comp['nombre']) ?></td>
                    <td><?=e($comp['dimensiones']) ?></td>
                    <td><?=e($comp['ubicacion']) ?></td>  
                    <td>
                        <?php if ($comp['stock'] != 0): ?>
                            <?= $comp['stock'] ?>
                        <?php else :?>
                            <strong>Sin Stock</strong>
                        <?php endif ;?>     
                    </td>
                    <td> 
                        <?php if ($usuario->admin==0): ?>    
                            <a href="formActualizarStock.php?id=<?=$comp['idalmacenaje']?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i></a>
                        <?php endif ;?>    
                    </td>  
                    <td>
                        <?php if ($comp['stock'] == 0 && $usuario->admin==0): ?>
                                <button type="button" data-bs-toggle="modal"
                                data-bs-target="#borrar<?= $comp['idalmacenaje']?>" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash3-fill"></i></button>
                        <?php endif; ?>     
                    </td>
                </tr>
                
                <!-- modal para borrar el componentes si la cantidad esta a 0 -->
                <div class="modal fade" id="borrar<?= $comp['idalmacenaje']?>" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title">Borrar Componente</h1>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres borrar el componente con Referencia: <strong><?= $comp['referencia'] ?></strong>
                                    del inventario?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="borrarAlmacenaje.php?id=<?=$comp['idalmacenaje']?>" 
                                    class="btn btn-danger">Borrar componente
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

<!-- tabla para buscar -->
<div class="table-responsive">
    <table class="table text-center align-middle" id="tablaBusca" style="display: none;">
        <thead class="table-success">
            <tr>
                <th></th>
                <th>Ref.Fabricante</th>
                <th>Nombre</th>
                <th>Dimensiones</th>
                <th>Ubicacion</th>
                <th>Stock</th>
                <th>
                    <?php if ($usuario->admin==0): ?>
                        <a href="addComponente.php" class="btn btn-sm btn-success"><i class="bi bi-box-arrow-in-left"></i> Añadir Comp</a></th>
                    <?php endif;?>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($componentesBusca as $compB) : ?>    
                <tr>
                    <td><img src="<?="/TFG/imagenes/componentes/".$compB['referencia'].'_'.$compB['imagen']?>" height=60px width=60px/></td> 
                    <td><?=e($compB['referencia']) ?></td>
                    <td><?=e($compB['nombre']) ?></td>
                    <td><?=e($compB['dimensiones']) ?></td>
                    <td><?=e($compB['ubicacion']) ?></td>  
                    <td>
                        <?php if ($compB['stock'] != 0): ?>
                            <?= $compB['stock'] ?>
                        <?php else :?>
                            <strong>Sin Stock</strong>
                        <?php endif ;?>     
                    </td>
                    <td> 
                        <?php if ($usuario->admin==0): ?>    
                            <a href="formActualizarStock.php?id=<?=$compB['idalmacenaje']?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i></a>
                        <?php endif ;?>    
                    </td>  
                    <td>
                        <?php if ($compB['stock'] == 0 && $usuario->admin==0): ?>
                                <button type="button" data-bs-toggle="modal"
                                data-bs-target="#borrar<?= $compB['idalmacenaje']?>" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash3-fill"></i></button>
                        <?php endif; ?>     
                    </td>
                </tr>
                <!-- modal para borrar el componentes si la cantidad esta a 0 -->
                <div class="modal fade" id="borrar<?= $compB['idalmacenaje']?>" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title">Borrar Componente</h1>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres borrar el componente con Referencia: <strong><?= $compB['referencia'] ?></strong>
                                    del inventario?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="borrarAlmacenaje.php?id=<?=$compB['idalmacenaje']?>" 
                                    class="btn btn-danger">Borrar componente
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

<!-- Paginacion -->
<nav id="pag" style="display:block;"> 
    <?php if ($usuario->admin==1): ?>
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($pag == 1) echo 'disabled';?> ">                    
                <a class="page-link" href="webInventario.php?id=<?=$id?>&pag=<?= $pag-1?>" >
                    &lt;&lt;
                </a>
            </li>
            <?php for($i=1; $i<=$numPaginas; $i++): ?>
                <li class="page-item <?php if($pag == $i) echo 'active';?>">
                    <a class="page-link" href="webInventario.php?id=<?=$id?>&pag=<?= $i ?>">
                        <?= $i?>
                    </a>
                </li>
            <?php endfor;?>
            <li class="page-item <?= ($pag >= $numPaginas)  ? "disabled" : "" ?> ">
                <a class="page-link" href="webInventario.php?id=<?=$id?>&pag=<?= $pag+1?>" >
                    &gt;&gt;
                </a>
            </li>
        </ul>
    </nav>
    <?php else :?>
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($pag == 1) echo 'disabled';?> ">                    
                <a class="page-link" href="webInventario.php?pag=<?= $pag-1?>" >
                    &lt;&lt;
                </a>
            </li>
            <?php for($i=1; $i<=$numPaginas; $i++): ?>
                <li class="page-item <?php if($pag == $i) echo 'active';?>">
                    <a class="page-link" href="webInventario.php?pag=<?= $i ?>">
                        <?= $i?>
                    </a>
                </li>
            <?php endfor;?>
            <li class="page-item <?= ($pag >= $numPaginas)  ? "disabled" : "" ?> ">
                <a class="page-link" href="webInventario.php?pag=<?= $pag+1?>" >
                    &gt;&gt;
                </a>
            </li>
        </ul>
    <?php endif ;?>    
</nav>

<?php include __DIR__ . '/../include/scripts.php' ;?>
<script>

    let navPag= document.getElementById("pag");
    let inputBuscar = document.getElementById("buscador");
    let tabla = document.getElementById("tabla");
    let tablaBusca= document.getElementById("tablaBusca");
    let columnas = tablaBusca.getElementsByTagName("tr"); //variabale para saber todas las columnas de la tabla para luego poder seleccionar una

    //esta funcion busca por un nombre o una referencia del componente
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
            const nombreFab = celdas[1];  //selecciona la celda por la que quiero buscar 
            const nombreComp = celdas[2];
            const nombreUbi = celdas[4];
            if (nombreFab || nombreComp || nombreUbi) {
                const encontrada = nombreFab.textContent || nombreFab.innerText;
                const encontrada2 = nombreComp.textContent || nombreComp.innerText;
                const encontrada3 = nombreUbi.textContent || nombreCom.innerText;
                columnas[i].style.display =(encontrada.toLowerCase().includes(busca) || encontrada2.toLowerCase().includes(busca) || 
                                            encontrada3.toLowerCase().includes(busca)) ? "" : "none";
            }
        }

        if (busca != "") {
            tabla.style.display = "none"; 
            tablaBusca.style.display = "table"; 
        } 
        else {
            tabla.style.display = "table"; 
            tablaBusca.style.display = "none";
        }

    }
    
    inputBuscar.addEventListener("focus", busqueda);  // mostrar la tabla completa con la busquda del input
    inputBuscar.addEventListener("blur", busqueda); //para cuando pulse fuera del input vuelva la tabla con la paginacion
    inputBuscar.addEventListener("input", busqueda); //para cuando escribo algo en el input cambie la tabla

</script>

<?php include __DIR__ . '/../include/pie.php' ;?>
