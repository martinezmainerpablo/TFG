<?php
    require_once __DIR__ . '/bd/usuario.php';
    require_once __DIR__ . '/bd/proveedor.php';
    require_once __DIR__ . '/bd/componente.php';
    require_once __DIR__ . '/bd/composicion.php';
    require_once __DIR__ . '/bd/almacenaje.php';
    require_once __DIR__ . '/lib/funciones.php';

    session_start();

    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    }
    else {
        $usuario = null;
        header('Location: login.php');
    }
    
    /*Numero de paginas*/
    if (isset($_GET['pag'])) {
        $pag = $_GET['pag'];
    }
    else {
        $pag = 1;
    }
    
    $componentes=Componente::listadoPrinc($pag);
    $listaComponentes=Componente::listadoBusca();
    $numComponentes = Componente::cuenta();
    $numPaginas = ceil($numComponentes/ TAM_COMP);

    $tituloPagina = "AUDIOBUS";

    include __DIR__ . '/include/cabecera.php';
    include __DIR__ . '/include/menu.php';

?>

<a href="/TFG/sugerencia/webSugerencia.php" class="boton-sug">
    <img src="/TFG/imagenes/comunes/sug.png" alt="Icono de sugerencia" style="width:40px; height: 40px;" />
</a>

<div class="container">
    <div class="row">
        <div class="col-4"><h2>Todos los componentes: </h2></div>
        <?php if ($usuario->admin==1) :?>
            <div class="col-4 offset-4"><a href="/TFG/componente/formComp.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Nuevo Componente</a></div>
        <?php endif ;?>    
    </div>
</div>

<br>
<div class="row">
    <div class="col-11 d-flex align-items-center">
        <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Busca en la Tabla"/>
    </div>
    <div class="col-1 d-flex align-items-center justify-content-center">
        <span title="Puedes buscar por cualquier campo de la tabla"> 
            <i class="bi bi-info-circle" style="font-size: 24px;"></i>
        </span>
    </div>
</div>

<br>
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <!-- La tabla con paginacion/principal-->
            <table class="table align-middle" id="tablaPag">
                <thead class="table-success">
                    <tr>
                        <th class="px-4"></th>
                        <th class="px-3">Fabricante</th>
                        <th class="px-2">Ref.Fabricante</th>
                        <th class="px-3">Nombre</th>
                        <th class="px-3">Dimensiones/Tamaño</th>
                        <th class="px-3">Tipo</th> 
                        <th class="px-1"></th>
                        <th class="px-4"></th>      
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($componentes as $comp) :?>
                        <tr>
                            <td class="px-4"><img src="<?="/TFG/imagenes/componentes/".$comp['referencia'].'_'.$comp['imagen']?>" height=70px width=70px /></td> 
                            <td class="px-3"><?=e($comp['nombreProv']) ?></td>
                            <td class="px-2"><?=e($comp['referencia']) ?></td>
                            <td class="px-3"><?=e($comp['nombreComp']) ?></td>
                            <td class="px-3"><?=e($comp['dimensiones']) ?></td>
                            <td class="px-3"><?=e($comp['nombreTipo']) ?></td>
                            <td class="px-1"><a href="/TFG/componente/verComponente.php?id=<?=$comp['referencia']?>" class="btn btn-sm btn-success">
                                <i class="bi bi-eye"></i></a>
                            </td>
                            <td class="px-4">
                                <?php if ($usuario->admin==1 && Composicion::buscar($comp['referencia'])==0 && Almacenaje::buscar($comp['referencia'])==0) : ?>
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#modal<?= $comp['referencia']?>" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3-fill"></i></button>
                                <?php endif; ?>   
                            </td>
                        </tr>
                        <!-- Modal para poder borrar un componente -->
                        <div class="modal fade" id="modal<?=$comp['referencia']?>" data-bs-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title">Borrar Componente</h1>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Seguro que quieres borrar el componente con Referencia: <strong><?=e($comp['referencia']) ?></strong>
                                            y nombre: <strong><?=e($comp['nombreComp'])?></strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="/TFG/componente/borrarCompInd.php?referencia=<?=$comp['referencia']?>" 
                                            class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Borrar componente
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

        <div class="table-responsive">                        
            <!-- Esta tabla esta sin paginacion para buscar en toda la tabla completa -->
            <table class="table align-middle" id="tablaBusca" style="display: none;">
                <thead class="table-success">
                    <tr>
                        <th class="px-4"></th>
                        <th class="px-3">Fabricante</th>
                        <th class="px-2">Ref.Fabricante</th>
                        <th class="px-3">Nombre</th>
                        <th class="px-3">Dimensiones/Tamaño</th>
                        <th class="px-3">Tipo</th> 
                        <th class="px-1"></th>
                        <th class="px-4"></th>      
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaComponentes as $lcomp) : ?>
                        <tr>
                            <td class="px-4"><img src="<?="/TFG/imagenes/componentes/".$lcomp['referencia'].'_'.$lcomp['imagen']?>" height=70px width=70px /></td> 
                            <td class="px-3"><?=e( $lcomp['nombreProv']) ?></td>
                            <td class="px-2"><?=e($lcomp['referencia']) ?></td>
                            <td class="px-3"><?=e($lcomp['nombreComp']) ?></td>
                            <td class="px-3"><?=e($lcomp['dimensiones']) ?></td>
                            <td class="px-3"><?=e($lcomp['nombreTipo']) ?></td>
                            <td class="px-1"><a href="/TFG/componente/verComponente.php?id=<?=$lcomp['referencia']?>" class="btn btn-sm btn-success">
                                <i class="bi bi-eye"></i></a>
                            </td>
                            <td class="px-4">
                                <?php if ($usuario->admin==1 && Composicion::buscar($lcomp['referencia'])==0 && Almacenaje::buscar($lcomp['referencia'])==0) : ?>
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#modal<?= $lcomp['referencia']?>" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                <?php endif; ?>   
                            </td>
                        </tr>
                        <!-- Modal para poder borrar un componente -->
                        <div class="modal fade" id="modal<?=$lcomp['referencia']?>" data-bs-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title">Borrar Componente</h1>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Seguro que quieres borrar el componente con Referencia: <strong><?=e($lcomp['referencia']) ?></strong>
                                            y nombre: <strong><?=e($lcomp['nombreComp'])?></strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="/TFG/componente/borrarCompInd.php?referencia=<?=$lcomp['referencia']?>" 
                                            class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Borrar componente
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
    </div>   
</div>

<br>
<!--paginacion-->
<nav id="pag" style="display:block;"> 
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($pag == 1) echo 'disabled';?> ">                    
            <a class="page-link" href="index.php?pag=<?= $pag-1?>" >
                &lt;&lt;
            </a>
        </li>
        <?php for($i=1; $i<=$numPaginas; $i++): ?>
            <li class="page-item <?php if($pag == $i) echo 'active';?>">
                <a class="page-link" href="index.php?pag=<?= $i ?>">
                    <?= $i?>
                </a>
            </li>
        <?php endfor;?>
        <li class="page-item <?= ($pag >= $numPaginas)  ? "disabled" : "" ?> ">
            <a class="page-link" href="index.php?pag=<?= $pag+1?>" >
                &gt;&gt;
            </a>
        </li>
    </ul>
</nav>

<?php include __DIR__. '/include/scripts.php';?>

<script>
    const pag = document.getElementById("pag");
    const tablaPag = document.getElementById("tablaPag");
    const tablaBusca = document.getElementById("tablaBusca");
    const inputBuscar = document.getElementById("buscar");
    const tablaProv = document.getElementById("tablaProv");
   
    //esta funcion lo que hace es que cuando pulsas el input desaparece una tabla y la paginacion y muestra una tabla para poder hacer la busqueda
    function pulsarInput() {

        // Oculta o mostra el navPag dependiendo si esta el input pulsado o no
        if (inputBuscar == document.activeElement) {
            pag.style.display = "none";
        } 
        else {
            pag.style.display = "block";
        }
        
        // Filtra las filas de la tabla según el input de busqueda
        let busca = inputBuscar.value.toLowerCase();
        let linea = Array.from(tablaBusca.querySelectorAll("tbody tr"));
        linea.forEach(tr => {
            let text = tr.textContent.toLowerCase();
            let encontrada = text.includes(busca);
            if (busca !== "") {
                tr.style.display = encontrada ? "table-row" : "none";
            }         
        });

        if(busca != ""){
            tablaPag.style.display = "none"; //Oculta la primera tabla
            tablaBusca.style.display = "table"; // Mostra la segunda tabla
        } 
        else{
            tablaPag.style.display = "table"; // Vuelve la primera tabla
            tablaBusca.style.display = "none"; // Oculta la segunda tabla
        }  
    }

    //dependiendo de lo que usemos el input hara una cosa u otra
    inputBuscar.addEventListener("focus", pulsarInput); // mostrar la tabla completa con la busquda del input
    inputBuscar.addEventListener("blur" , pulsarInput);  //para cuando pulse fuera del input vuelva la tabla con la paginacion
    inputBuscar.addEventListener("input", pulsarInput); //para cuando escribo algo en el input cambie la tabla

</script>

<?php include __DIR__. '/include/pie.php'; ?>

