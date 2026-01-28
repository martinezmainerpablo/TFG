<?php
require_once __DIR__.'/bd.php';

class TipoComponente {
    public $idtipocomponente;
    public $nombre;
    public $idcategotia;

    //mostrar el listado de componentes en la pagina webTipComp.php
    public static function listado(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT ct.idtipocomponente as idtipocomponente, ct.nombre as nombre, c.nombre as nombreCategoria, ct.idcategoria 
            FROM tipocomponente ct
            INNER JOIN categoria c ON ct.idcategoria=c.idcategoria");   

        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }       
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $tipoComponente = [];
        while ($tComp = $res->fetch_assoc()){
            $tipoComponente[] = $tComp;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $tipoComponente;
    }

    
    //funcion para mostrar la lista de tipos en un nuevo componente
    public static function listadoComp(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT ct.* ,c.nombre as nombreCat from tipocomponente ct
            INNER JOIN categoria c ON ct.idcategoria=c.idcategoria");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }
        $ok = $st->execute();
        if ($ok === false) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $tipocomponentes = [];
        while ($tcomp = $res->fetch_object('tipocomponente')) {
            $tipocomponentes[] = $tcomp;
        }
        $res->free();
        $st->close();
        $bd->close();
        return $tipocomponentes;        
    }

    //el titulo de la pagina de webComponentes.php
    public static function nombre($id){
        $bd = abrirBD();

        $st = $bd->prepare("SELECT tc.nombre as nombre FROM tipocomponente tc 
            WHERE idtipocomponente=?");

        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("i", $id);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $datos = $res->fetch_assoc();
        $res->free();
        $st->close();
        $bd->close();
    
        return $datos['nombre'];
    }
    
}