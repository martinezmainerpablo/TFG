<?php
require_once __DIR__ .'/bd.php';

class Composicion{

    public $idcomposicion;
    public $idreferenciapcb;
    public $referenciaFabricante;
    public $posicion;

    //listado filtrado
    public static function listado($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT c.idcomposicion,c.posicion, c.referenciaFabricante as referencia, comp.nombre, comp.dimensiones, comp.imagen,
            pr.nombre as nombreProv
            FROM composicion c
            INNER JOIN componente comp ON c.referenciaFabricante=comp.referenciaFabricante
            INNER JOIN proveedor pr ON comp.idproveedor=pr.idproveedor
            WHERE idreferenciapcb=?
            order by posicion");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }
        $st->bind_param('i',$id);       
        $ok = $st->execute(); 

        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $composiciones = [];
        while ($comp = $res->fetch_assoc()){
            $composiciones[] = $comp;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $composiciones;
    }
    
    //insertar composiciones
    public function insertar(){
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO composicion (idreferenciapcb,referenciaFabricante,posicion) 
            VALUES (?,?,?)");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param("iss",
            $this->idreferenciapcb, 
            $this->referenciaFabricante,
            $this->posicion);

        $res = $st->execute();

        if ($res === FALSE) {
            die("ERROR de ejecucion: " . $bd->error);
        }

        $this->idcompomente = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    //comprobar que esta el componente en la referencia
    public static function esta($id,$posicion){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM composicion 
            WHERE idreferenciapcb=? && posicion=?");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("is", $id,$posicion);
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
    
    //comprobar que esta el componente en la referencia
    public static function cuenta($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM composicion 
            WHERE idreferenciapcb=?");
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

    //borrar componente de la composicion
    public static function borrar($id){
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM composicion WHERE  idcomposicion=?");

        if ($st === false) {
            die($bd->error);
        }
        $st->bind_param('i', $id);
        $ok = $st->execute();
        if ($ok === false) {
            die($bd->error);
        }
        $st->close();
        $bd->close();
    }
   
    //buscar si el componente esta en alguna composicion
    public static function buscar($nombre){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM composicion 
            WHERE referenciaFabricante=?");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("s",$nombre);
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