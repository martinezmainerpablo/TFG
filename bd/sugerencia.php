<?php
require_once __DIR__.'/bd.php';

class Sugerencia {
    public $idsugerencia;
    public $titulo;
    public $descripcion;
    public $estado;
    public $idusuario;

    //mostrar todas al administrador 
    public static function listadoAdm($pag){
        $tamPagina = TAM_SUGERENCIAS;
        $offset = ($pag-1) * $tamPagina;

        $bd = abrirBD();
        $st = $bd->prepare("SELECT sug.idsugerencia,sug.titulo,sug.descripcion,sug.estado, us.nombre AS nombreUsu FROM sugerencia sug
            INNER JOIN  usuario us ON sug.idusuario = us.idusuario
            ORDER BY sug.idsugerencia DESC
            LIMIT ?,?");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }       
        $st->bind_param('ii',$offset,$tamPagina); 
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $sugerencias = [];
        while ($sug = $res->fetch_assoc()){
            $sugerencias[] = $sug;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $sugerencias;
    }

    //muestra las de un usuario especifico
    public static function listadoUsu($id,$pag){
        $tamPagina = TAM_SUGERENCIAS;
        $offset = ($pag-1) * $tamPagina;

        $bd = abrirBD();
        $st = $bd->prepare("SELECT sug.idsugerencia,sug.titulo,sug.descripcion,sug.estado, us.nombre AS nombreUsu FROM sugerencia sug
            INNER JOIN  usuario us ON sug.idusuario = us.idusuario
            WHERE us.idusuario=?
            ORDER BY sug.idsugerencia DESC
            LIMIT ?,?");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }    

        $st->bind_param('iii',$id,$offset,$tamPagina); 
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $sugerencias = [];
        while ($sug = $res->fetch_assoc()){
            $sugerencias[] = $sug;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $sugerencias;
    }
    
    public function insertar() {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO sugerencia
                (titulo,descripcion,estado,idusuario) 
                VALUES (?,?,?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("sssi", 
                $this->titulo, 
                $this->descripcion, 
                $this->estado,
                $this->idusuario);
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $this->idsugerencia = $bd->insert_id;
        
        $st->close();
        $bd->close();
    }

    //actualizar el estado de la sugerencia
    public function actualizar()
    {
        $bd = abrirBD();
        $st = $bd->prepare("UPDATE sugerencia SET estado=?
         WHERE idsugerencia=?");

        if ($st === false) {
            die($bd->error);
        }

        $st->bind_param('si',
            $this->estado, 
            $this->idsugerencia);

        $ok = $st->execute();

        if ($ok === false) {
            die($bd->error);
        }
        
        $st->close();
        $bd->close();
    }
    
    public static function cargar($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT sug.idsugerencia,sug.titulo,sug.descripcion,sug.estado, us.nombre as nombreUsu FROM sugerencia sug
            INNER JOIN  usuario us on sug.idusuario = us.idusuario
            WHERE sug.idsugerencia=?");

        if ($st === false) {
            die($bd->error);
        }

        $st->bind_param('i', $id);
        $ok = $st->execute();

        if ($ok === false) {
            die($bd->error);
        }

        $res = $st->get_result();

        $sugerencia = $res->fetch_object("Sugerencia");

        $res->free();
        $st->close();
        $bd->close();

        return $sugerencia;
    }

    public static function cuenta(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM sugerencia ");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $datos = $res->fetch_assoc();
        $res->free();
        $st->close();
        $bd->close();
        return $datos['num'];
    }

    public static function cuentaUsu($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) AS num FROM sugerencia  sug
            INNER JOIN  usuario us ON sug.idusuario = us.idusuario
            WHERE us.idusuario=?");
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
        
        return $datos['num'];
    }

}