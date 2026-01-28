<?php require_once __DIR__ . '/../lib/funciones.php'; ?>

<nav class="navbar navbar-expand-md bg-success fixed-top " data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/TFG/index.php"><img src="/TFG/imagenes/comunes/logo.png"></a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">                    
            <ul class="navbar-nav me-auto ">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center <?php echo ($pagina=="prov")? "active":"";?>" href="/TFG/proveedor/webProv.php">
                        <span class="fs-3 text-center px-2">Proveedores</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center <?php echo ($pagina=="comp")? "active":"";?>" href="/TFG/tipo/webTipComp.php">
                        <span class="fs-3 text-center px-2">TipoComponentes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center <?php echo ($pagina=="ref")? "active":"";?>" href="/TFG/referencia/webRef.php">
                        <span class="fs-3 text-center px-2">Ref.PCB</span>
                    </a>
                </li>
                <li class="nav-item">
                    <?php if ($usuario->admin==1): ?>
                        <a class="nav-link d-flex align-items-center <?php echo ($pagina=="inv")? "active":"";?>" href="/TFG/inventario/webInicioInv.php">
                            <span class="fs-3 text-center px-2">Inventarios</span>
                        </a>
                    <?php else :?> 
                        <a class="nav-link d-flex align-items-center <?php echo ($pagina=="inv")? "active":"";?>" href="/TFG/inventario/webInventario.php">
                            <span class="fs-3 text-center px-2">Inventarios</span>
                        </a>
                    <?php endif; ?>             
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="navbar-text">
                    <span class="fs-5 text-center"><?= e($usuario->nombre)?></span>           
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/TFG/logout.php">
                        <i class="bi bi-x-square-fill text-danger "></i>
                        <span class="d-md-none">Salir</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>          
</nav>
