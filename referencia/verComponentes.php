<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/composicion.php';
    require_once __DIR__ . '/../bd/referenciapcb.php';
    require_once __DIR__ . '/../lib/funciones.php';

    session_start();
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    }
    else {
        $usuario = null;
        header('Location: /TFG/login.php');
    }
    $id = $_GET['id'];

    $nombreRef=ReferenciaPCB::nombre($id);
    $composicion= Composicion::listado($id);
    $referencia= ReferenciaPCB::buscarUsu($id);
    
    $tituloPagina = "Referencia PCB";
    $pagina="ref";
    
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';
?>

<div class="row">
    <div class="col-md-4"><h1><?= $nombreRef ?></h1></div>
    <div class="col-md-4 offset-md-4"><a href="buscarRef.php" class="btn btn-success ">Volver</a></div>
</div>

<br>
<div class="table-responsive">
    <table class="table text-center align-middle">
        <thead>
            <tr>
                <th></th>
                <th>Ref.Fabricante</th>
                <th>Fabricante</th>
                <th>Nombre</th>
                <th>Dimensiones</th>
                <th>Posicion</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($composicion as $comp) : ?>    
                <tr>
                    <td><img src="<?="/TFG/imagenes/componentes/".e($comp['referencia']).'_'.e($comp['imagen'])?>" height=60px width=60px/></td> 
                    <td><?= e($comp['referencia']) ?></td>
                    <td><?= e($comp['nombreProv']) ?></td>
                    <td><?= e($comp['nombre']) ?></td>
                    <td><?= e($comp['dimensiones']) ?></td>
                    <td><?= e($comp['posicion']) ?></td>
                    <td>
                        <?php if ($usuario->admin == 1 || $referencia == $usuario->idusuario) : ?>
                            <button type="button" data-bs-toggle="modal"
                                data-bs-target="#modal<?= $comp['idcomposicion']?>" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        <?php endif ;?>    
                    </td>
                </tr>    
                <div class="modal fade" id="modal<?= $comp['idcomposicion']?>" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Borrar Componente de la composicion</h2>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres borrar el componente con Referencia: <strong><?= $comp['referencia'] ?></strong>, de la composicion: 
                                    <strong><?= $nombreRef?></strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="borrarComposicion.php?id=<?=$id?>&composicion=<?=$comp['idcomposicion']?>" 
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

<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__.'/../include/pie.php'; ?>