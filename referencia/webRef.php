<?php
    require_once __DIR__ . '/../bd/usuario.php';
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

    if($usuario->admin==1){
        $cuenta = ReferenciaPCB::cuenta();
    }
    else{
        $cuenta = ReferenciaPCB::cuentaFilt($usuario->idusuario);
    }
    
    $tituloPagina = "Referencias PCB";
    $pagina="ref";

    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';
    
?>
<a href="/TFG/sugerencia/webSugerencia.php" class="boton-sug">
    <img src="/TFG/imagenes/comunes/sug.png" alt="Icono de sugerencia" style="width: 40px; height: 40px;" />
</a>

<h1>Referencias PCB</h1>
<br><br>
<div class="row g-3">
    <div class="col-md-4 text-center">
        <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="/TFG/imagenes/comunes/ref.jpg">
            <div class="card-body">
                <h5 class="card-title">Añadir ReferenciaPCB</h5>
                <p class="card-text">Añadir una referenciaPCB a la base de datos.</p>               
                <a href="formRef.php" class="btn btn-success" disabled><i class="bi bi-plus-circle"></i> Añadir</a>
            </div>               
        </div>    
    </div>

    <div class="col-md-4 text-center">
        <div class="card" style="width: 20rem;">
            <img class="card-img-top" src="/TFG/imagenes/comunes/ref-comp.png">
            <div class="card-body">
                <h5 class="card-title">Añadir Componente</h5>
                <p class="card-text">Añadir componentes a las referenciasPCB.</p>
                <?php if ($cuenta == 0) :?>
                    <a href="addComp.php" class="btn btn-success disabled"><i class="bi bi-plus-circle"></i> Añadir</a>
                    <p class="alert alert-warning">Necesitas tener una referencia PCB!</p>                  
                 <?php else :?>
                    <a href="addComp.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Añadir</a>
                <?php endif;?>
            </div>               
        </div>    
    </div>

    <div class="col-md-4 text-center">
        <div class="card" style="width: 20rem;">
            <img class="card-img-top" src="/TFG/imagenes/comunes/ref-buscar.png">
            <div class="card-body">
                <h5 class="card-title">Buscar Referencia</h5>
                <p class="card-text">Buscar una referencia especifica y ver los componentes que la componen.</p>
                <a href="buscarRef.php" class="btn btn-success"><i class="bi bi-search"></i> Buscar</a>
            </div>               
        </div>    
    </div>
    
</div>

<?php include __DIR__. '/../include/scripts.php';?>


<?php include __DIR__.'/../include/pie.php'; ?>