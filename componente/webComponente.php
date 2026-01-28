<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/componente.php';
    require_once __DIR__ . '/../bd/composicion.php';
    require_once __DIR__ . '/../bd/almacenaje.php';
    require_once __DIR__ . '/../bd/tipocomponente.php';
    require_once __DIR__ . '/../bd/categoria.php';
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

    $id = $_GET['id'];

    $nombreCat=tipoComponente::nombre($id);
    $componentes= Componente::listadoFilt($id,$pag);

    $numComponentes = Componente::cuentaFilt($id);
    $numPaginas = ceil($numComponentes/ TAM_COMP);
    

    $tituloPagina = "Componentes";
    $pagina="comp";
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';
?>
<a href="/TFG/sugerencia/webSugerencia.php" class="boton-sug">
    <img src="/TFG/imagenes/comunes/sug.png" alt="Icono de sugerencia" style="width: 40px; height: 40px;" />
</a>

<div class="container">
  <div class="row">
    <div class="col-md-4"><h1><?= $nombreCat ?></h1></div>
    <div class="col-md-4 offset-md-4"><a href="/TFG/tipo/webTipComp.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a></div>
  </div>
</div>
<br>
<div class="table-responsive">
    <table class="table text-center align-middle">
        <thead>
            <tr>
                <th></th>
                <th>Fabricante</th>
                <th>Ref.Fabricante</th>
                <th>Nombre</th>
                <th>Dimensiones/Tamaño</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($componentes as $comp) : ?>    
                    <tr>
                        <td><img src="<?="/TFG/imagenes/componentes/".$comp['referencia'].'_'.$comp['imagen']?>" height=60px width=60px/></td> 
                        <td><?= e($comp['nombreProv']) ?></td>
                        <td><?= e($comp['referencia']) ?></td>
                        <td><?= e($comp['nombreComp']) ?></td>
                        <td><?= e($comp['dimensiones']) ?></td> 
                        <td><a href="verComponente.php?id=<?=$comp['referencia']?>" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a></td>
                        <td>
                            <?php if ($usuario->admin==1 && Composicion::buscar($comp['referencia'])==0 && Almacenaje::buscar($comp['referencia'])==0) : ?>
                                 <button type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal<?= $comp['referencia']?>" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash3-fill"></i></button>
                            <?php endif; ?> 
                        </td>
                    </tr>
                    <div class="modal fade" id="modal<?= $comp['referencia']?>" data-bs-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title">Borrar Componente</h1>
                                </div>
                                <div class="modal-body">
                                    <p>¿Seguro que quieres borrar el componente con Referencia: <strong><?= e($comp['referencia']) ?></strong>
                                        y nombre: <strong><?=e($comp['nombreComp'])?></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="borrarComponente.php?id=<?=$id?>&referencia=<?=$comp['referencia']?>" 
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

<!--paginacion-->
<nav> 
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($pag == 1) echo 'disabled';?> ">                    
            <a class="page-link" href="webComponente.php?id=<?=$id?>&pag=<?= $pag-1?>" >
                &lt;&lt;
            </a>
        </li>
        <?php for($i=1; $i<=$numPaginas; $i++): ?>
            <li class="page-item <?php if($pag == $i) echo 'active';?>">
                <a class="page-link" href="webComponente.php?id=<?=$id?>&pag=<?= $i ?>">
                    <?= $i?>
                </a>
            </li>
        <?php endfor;?>
        <li class="page-item <?= ($pag >= $numPaginas)  ? "disabled" : "" ?> ">
            <a class="page-link" href="webComponente.php?id=<?=$id?>&pag=<?= $pag+1?>" >
                &gt;&gt;
            </a>
        </li>
    </ul>
</nav>
<?php include __DIR__.'/../include/scripts.php'; ?>

<?php include __DIR__.'/../include/pie.php'; ?>