<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/sugerencia.php';
    require_once __DIR__ . '/../lib/funciones.php';

    session_start();

    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    }
    else {
        $usuario = null;
        header('Location: /TFG/login.php');
    }

    if (isset($_GET['pag'])) {
        $pag = $_GET['pag'];
    }
    else {
        $pag = 1;
    }

    if($usuario->admin==1){
        $sugerencias=Sugerencia::listadoAdm($pag);
        $numSugerencias = Sugerencia::cuenta();
        $numPaginas = ceil($numSugerencias/ TAM_SUGERENCIAS);
    }
    else{
        $sugerencias=Sugerencia::listadoUsu($usuario->idusuario,$pag);
        $numSugerencias = Sugerencia::cuentaUsu($usuario->idusuario);
        $numPaginas = ceil($numSugerencias/ TAM_SUGERENCIAS);
    }
    
    $tituloPagina="Sugerencias";
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>

<br>
<div class="container">
    <div class="row">
        <div class="col-8"><h2>Sugerencias:</h2></div>
        <?php if ($usuario->admin==0) :?>
            <div class="col-2"><a href="formSugerencia.php" class="btn btn-success"><i class="bi bi-plus-circle"></i>Añadir sugerencia</a></div>    
        <?php endif ;?>             
    </div>
</div>
<br>

<div class="row g-5">
    <?php foreach ($sugerencias as $sug) :?>
        <div class="col-md-3 text-center">
            <div class="card" style="height: 185px; width: 320px;">
                <div class="card-body">
                    <h5 class="card-title"><?= e($sug['titulo'])?></h5>
                    <p class="card-text">Propuesta de: <?= e($sug['nombreUsu'])?></p>    
                    <?php if ($sug['estado']=='A') :?>               
                        <p class="alert alert-success align-bottom">Aprobada!!!</p>
                    <?php elseif ($sug['estado']=='R') :?>
                        <p class="alert alert-danger align-bottom">Rechazada!!!</p>
                    <?php else :?>    
                        <?php if($sug['estado']=='P' && $usuario->admin==1) :?>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal<?= $sug['idsugerencia']?>" class="btn btn-primary">
                                    Ver mas
                            </button>  
                        <?php else :?>
                            <p class="alert alert-warning align-bottom">Pendiente!!!</p>
                        <?php endif ;?>   
                    <?php endif ;?>          
                </div>               
            </div>    
        </div>

        <!-- modal para aprobar o rechazar la sugerencia -->
        <div class="modal fade" id="modal<?=$sug['idsugerencia']?>" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title"><?= e($sug['titulo']) ?></h1>
                    </div>
                    <div class="modal-body">
                        <textarea rows="10" cols="60" disabled><?= e($sug['descripcion']) ?></textarea>
                    </div>
                    <div class="modal-footer d-flex justify-content-cente gap-3">
                        <a href="aprobar.php?id=<?=$sug['idsugerencia']?>" 
                            class="btn btn-success"><i class="bi bi-check-circle"></i></i> Aceptar
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <a href="denegar.php?id=<?=$sug['idsugerencia']?>" 
                            class="btn btn-danger"><i class="bi bi-x-circle"></i></i> Rechazar
                        </a>
                    </div>
                </div>
            </div>
        </div>  
    <?php endforeach; ?>
</div>

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-9">
            <nav> 
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($pag == 1) echo 'disabled';?> ">                    
                        <a class="page-link" href="webSugerencia.php?pag=<?= $pag-1?>" >
                            &lt;&lt;
                        </a>
                    </li>
                    <?php for($i=1; $i<=$numPaginas; $i++): ?>
                        <li class="page-item <?php if($pag == $i) echo 'active';?>">
                            <a class="page-link" href="webSugerencia.php?pag=<?= $i ?>">
                                <?= $i?>
                            </a>
                        </li>
                    <?php endfor;?>
                    <li class="page-item <?= ($pag >= $numPaginas)  ? "disabled" : "" ?> ">
                        <a class="page-link" href="webSugerencia.php?pag=<?= $pag+1?>" >
                            &gt;&gt;
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="col-1">
            <a href="/TFG/index.php" class="btn btn-success">Volver</a>
        </div>                  
    </div>
</div>   

<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__ . '/../include/pie.php' ;?>
