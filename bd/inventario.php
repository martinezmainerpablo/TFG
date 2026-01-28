<?php
require_once __DIR__ .'/bd.php';

class Inventario{

    public $idinventario;
    public $nombre;
    public $telefono;
    public $idusuario;
    
    //listado de la pagina tabla de webInicioINv.php
    public static function listado($pag){
        $tamPagina = TAM_INV;
        $offset = ($pag-1) * $tamPagina;
      
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM inventario
        LIMIT ?,?");   
        
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }
        $st->bind_param('ii', $offset,$tamPagina);  
        
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $inventarios = [];
        while ($inv = $res->fetch_assoc()){
            $inventarios[] = $inv;
        }
        $res -> free();
        $st->close();
        $bd -> close();
        return $inventarios;
    }
    
    //insertar en la tabla
    public function insertar(){
        $bd = abrirBD();

        $st = $bd->prepare("INSERT INTO inventario (nombre,telefono,idusuario) 
            VALUES (?,?,?)");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param("ssi", 
            $this->nombre,
            $this->telefono,
            $this->idusuario);

        $res = $st->execute();

        if ($res === FALSE) {
            die("ERROR de ejecucion: " . $bd->error);
        }

        $this->idinventario = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    //compruba que no hay otro prov con el mismo nombre
    public static function cargaNom($nombre){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT nombre as nom FROM inventario 
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
    
    //compruba que no hay otro prov con el mismo telefono
    public static function cargaTel($telefono){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT telefono as tel FROM inventario 
            WHERE telefono=?");

        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("s", $telefono);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $datos = $res->fetch_assoc();
        $res->free();
        $st->close();
        $bd->close();    
        return $datos['tel'];
    }

    //el titulo de la pagina de webComponentes.php
    public static function nombre($id){
        $bd = abrirBD();

        $st = $bd->prepare("SELECT nombre 
            FROM inventario 
            WHERE idinventario=?");

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

    //borrar 
    public static function borrar($id){
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM inventario WHERE  idinventario=?");

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

    //rellenar el select
    public static function listadoSelect(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM inventario ORDER BY idinventario desc");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }       
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $inventarios = [];
        while ($inv = $res->fetch_object('inventario')) {
            $inventarios[] = $inv;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $inventarios;
    }

    //busca el id del usuario logueado para luego guardar el componente en el inventario
    public static function buscarInv($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT idinventario as num FROM inventario 
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
    //buscar el id del usuario con el id del inventario
    public static function buscarU($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT idusuario as usu FROM inventario 
        WHERE idinventario=?");
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
        return $datos['usu'];
    }
    
    public static function cuenta(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM inventario");
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
}

