<?php
    require_once __DIR__ . '/../bd/usuario.php';
    require_once __DIR__ . '/../bd/tipocomponente.php';
    require_once __DIR__ . '/../lib/funciones.php';

    session_start();
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    }
    else {
        $usuario = null;
        header('Location: /TFG/login.php');
    }

    $tipoComponente= TipoComponente::listado();
    
    $tituloPagina = "Tipo de Componentes";
    $pagina="comp";
    
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>
<a href="/TFG/sugerencia/webSugerencia.php" class="boton-sug">
    <img src="/TFG/imagenes/comunes/sug.png" alt="Icono de sugerencia" style="width: 40px; height: 40px;" />
</a>
    <div class="container">
        <div class="row">
            <div class="col-md-4"><h2>Tipo de componentes:</h2></div>
            <?php if ($usuario->admin==1) :?>
                <div class="col-md-4 offset-md-4"><a href="/TFG/componente/formComp.php" class="btn btn-success "><i class="bi bi-plus-circle"></i>
                    Nuevo Componente</a></div>
            <?php endif ;?>
        </div>
    </div>

    <br>   
    <div class="container">
        <div class="row align-items-start">
            <div class="col">
                <h4>Componentes Pasivos(sin silicio).</h4>
                <table class="table text-center align-middle table-primary ">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th></th>  
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tipoComponente as $tpc) : ?>
                            <tr>
                                <?php if($tpc['idcategoria']==1) :?>
                                    <td><?= e($tpc['nombre']) ?></td>
                                    <td><a href="/TFG/componente/webComponente.php?id=<?=$tpc['idtipocomponente']?>" class="btn btn-success">
                                        <i class="bi bi-eye"></i></a></td>
                                <?php endif;?>      
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <h4>Componentes Activos(con silicio).</h4>
                    <table class="table text-center align-middle table-secondary">
                        <thead>
                            <tr>
                                <th >Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tipoComponente as $tpc) : ?>
                                <tr>
                                    <?php if($tpc['idcategoria']==2) :?>
                                        <td><?= e($tpc['nombre']) ?></td>
                                        <td><a href="/TFG/componente/webComponente.php?id=<?=$tpc['idtipocomponente']?>" class="btn btn-success">
                                            <i class="bi bi-eye"></i></a></td>
                                    <?php endif;?>      
                                </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> 
        </div>
    </div> 
<?php include __DIR__. '/../include/scripts.php';?>

<?php include __DIR__.'/../include/pie.php'; ?>