<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/almacenaje.php';
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
    
    if(isset($_GET['pag'])){
        $pag = $_GET['pag'];
    }
    else{
        $pag=1;
    }

    $numInventarios = Inventario::cuenta();
    $numPaginas = ceil($numInventarios/ TAM_INV);
    $listaInventarios= Inventario::listado($pag);

    $tituloPagina = "Inventarios";
    $pagina="inv";
    
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>
<a href="/TFG/sugerencia/webSugerencia.php" class="boton-sug">
    <img src="/TFG/imagenes/comunes/sug.png" alt="Icono de sugerencia" style="width: 40px; height: 40px;" />
</a>
<div class="container">
    <div class="row">
        <div class="col-md-4"><h2>Inventarios</h2></div>
        <div class="col-md-4"><a href="addComponente.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Añadir componente</a></div>
        <?php if ($usuario->admin==1) :?>
            <div class="col-md-4 "><a href="formInventario.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Nuevo Inventario</a></div>
        <?php endif ;?>
    </div>
</div>
<br>
<div class="container">
    <div class="row align-items-start">
        <div class="col">
            <table class="table text-center table-secondary align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaInventarios as $li) : ?>
                        <tr>
                            <td><?=e($li['nombre']) ?></td>
                            <td><?=e($li['telefono']) ?></td>
                            <td>
                                <a href="webInventario.php?id=<?=$li['idinventario']?>" class="btn btn-success"><i class="bi bi-eye"></i></a>
                            </td>
                            <td>
                                <?php if ($usuario->admin==1 && Almacenaje::cuentaFilt($li['idinventario'])==0) :?>
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#modal<?= $li['idinventario']?>" class="btn  btn-danger">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Modal para borrar el inventario si esta vacio -->
                            <div class="modal fade" id="modal<?= $li['idinventario']?>" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">Borrar Inventario</h2>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Seguro que quieres borrar el inventario: <strong><?= $li['nombre'] ?></strong>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="borrarInventario.php?id=<?= $li['idinventario']?>" 
                                                class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Borrar Inventario
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($pag == 1) echo 'disabled';?> ">                    
            <a class="page-link" href="webInicioInv.php?pag=<?=$pag-1?>" >
                &lt;&lt;
            </a>
        </li>
        <?php for($i=1; $i<=$numPaginas; $i++): ?>
            <li class="page-item <?php if($pag == $i) echo 'active';?>">
                <a class="page-link" href="webInicioInv.php?pag=<?=$i?>">
                    <?= $i?>
                </a>
            </li>
        <?php endfor;?>
        <li class="page-item <?= ($pag >= $numPaginas)  ? "disabled" : "" ?> ">
            <a class="page-link" href="webInicioInv.php?pag=<?=$pag+1?>" >
                &gt;&gt;
            </a>
        </li>
    </ul>
</nav>
<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__.'/../include/pie.php'; ?>