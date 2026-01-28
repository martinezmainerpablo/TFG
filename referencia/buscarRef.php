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

    $listaReferencias = ReferenciaPCB::listadoBuscar();  

    $tituloPagina = "Referencias PCB";
    $pagina="ref";
    
    include __DIR__ . '/../include/cabecera.php';
    include __DIR__ . '/../include/menu.php';

?>
<h3>Buscar referencia Referencia</h3><br>
    <div>
        <label class="form-label" for="buscar">
            Escribe una Referencia PCB:
        </label>
        <div class="row">
            <div class="col-11 d-flex align-items-center">
                <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Referencia PCB" autofocus/>
            </div>
            <div class="col-1 d-flex align-items-center justify-content-center">
                <span title="Puedes buscar por el nombre de la referencia"> 
                    <i class="bi bi-info-circle" style="font-size: 24px;"></i>
                </span>
            </div>
        </div>
    </div>

    <br>
    <table class="table text-center table-secondary align-middle" id="tabla">
        <?php foreach ($listaReferencias as $lr) : ?>
            <tr>
                <td><?= e($lr['nombre']) ?></td>
                <td><a href="verComponentes.php?id=<?=$lr['idreferenciapcb']?>" class="btn btn-success"><i class="bi bi-eye"></i> Componentes</a></td>
                <td>
                    <?php if (Composicion::cuenta($lr['idreferenciapcb'])==0) : ?>
                        <?php if ($usuario->admin == 1 || $lr['idusuario'] == $usuario->idusuario) : ?>
                            <button type="button" data-bs-toggle="modal"
                                data-bs-target="#modal<?= $lr['idreferenciapcb']?>" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash3-fill"></i></button></td>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <div class="modal fade" id="modal<?= $lr['idreferenciapcb']?>" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Borrar Referencia</h2>
                            </div>
                            <div class="modal-body">
                                <p>¿Seguro que quieres borrar la Referencia: <strong><?= $lr['nombre'] ?></strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="borrarReferencia.php?id=<?= $lr['idreferenciapcb']?>" 
                                    class="btn btn-danger"><i class="bi bi-trash3-fill"></i> Borrar Referencia
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
    </table>

    <div class="col-md-12 text-center"><br>
        <a href="webRef.php" class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Volver</a>
    </div>

<?php include __DIR__.'/../include/scripts.php'; ?>

<script>
    let tabla = document.getElementById("tabla");
    let inputBuscar = document.getElementById("buscar");
        
    //buscar en la tabla las filas que contengan lo del input (falta que cuando se borre el input desaparezca toda la tabla)
    inputBuscar.addEventListener("input", function() {
    let busca = inputBuscar.value.toLowerCase();
    let linea = Array.from(tabla.querySelectorAll("tr"));
        linea.forEach(tr => {
            let text = tr.textContent.toLowerCase();
            let encontrada = text.includes(busca);
            if (buscar != "") {
                tr.style.display = encontrada ? "table-row" : "none";                    
            } 
            else {
                tr.style.display = "none";
            }
        });
    });    
    
</script>

<?php include __DIR__.'/../include/pie.php'; ?>
