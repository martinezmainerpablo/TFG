<?php
require_once __DIR__ .'/bd.php';

class ReferenciaPCB{
    public $idreferenciapcb;
    public $nombre;
    public $idusuario;
    
    //insertar en la pagina addRef.php
    public function insertar(){
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO referenciapcb (nombre,idusuario) 
        VALUES (?,?)");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param("si", 
            $this->nombre,
            $this->idusuario);

        $res = $st->execute();

        if ($res === FALSE) {
            die("ERROR de ejecucion: " . $bd->error);
        }

        $this->idreferenciapcb = $bd->insert_id;
        $st->close();
        $bd->close();
    }
    
    //rellenar el inpunt de en añdir componente en la pagina addComp.php
    public static function listado(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM referenciapcb
            order by idreferenciapcb desc");   

        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }       
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $referencias = [];
        while ($ref = $res->fetch_object('referenciapcb')) {
            $referencias[] = $ref;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $referencias;
    }

    //rellenar el inpunt con las referencias del usuario de en añdir componente en la pagina addComp.php
    public static function listadoFilt($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM referenciapcb 
        WHERE idusuario=?
        ORDER BY idreferenciapcb DESC");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }
        $st->bind_param('i',$id);        
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $referencias = [];
        while ($ref = $res->fetch_object('referenciapcb')) {
            $referencias[] = $ref;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $referencias;
    }

    //contar cuantas referencia hay
    public static function cuenta(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) AS num FROM referenciapcb");

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

    //contar cuantas referencia hay y si no hay ninguna que no pueda añadir componentes a la ref
    public static function cuentaFilt($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) AS num FROM referenciapcb
            WHERE idusuario=?");

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

    //buscar si existe una referencia 
    public static function carga($nombre){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT nombre as nom FROM referenciapcb 
            WHERE nombre=?");

        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("s", $nombre);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $datos = $res->fetch_assoc();
        $res->free();
        $st->close();
        $bd->close();
        return $datos['nom'];
    }

    //mostrar lista de referencias en buscarRef.php
    public static function listadoBuscar(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM referenciapcb");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }       
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $referencias = [];
        while ($ref = $res->fetch_assoc()){
            $referencias[] = $ref;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $referencias;
    }

    //saber el nombre de la referencia
    public static function nombre($id){
        $bd = abrirBD();

        $st = $bd->prepare("SELECT nombre FROM referenciapcb  
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
    
        return $datos['nombre'];
    }
    
    //borrar una referenciaPCB
    public static function borrar($id){
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM referenciapcb WHERE  idreferenciapcb=?");
    
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

    //saber el usuario de la referencia
    public static function buscarUsu($id){
        $bd = abrirBD();

        $st = $bd->prepare("SELECT idusuario FROM referenciapcb  
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
    
        return $datos['idusuario'];
    }
    
}

