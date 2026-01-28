<?php
require_once __DIR__ .'/bd.php';


class Componente{
    public $referenciaFabricante;
    public $idtipocomponente;
    public $nombre;
    public $caracteristicas;
    public $dimensiones;
    public $imagen;
    public $idproveedor;

    // Esta funcion nos mostrara el listado con todos los componentes para la pagina principal
    public static function listadoPrinc($pag){
        ##Tener controlado el tamaño de la paginas
        $tamPagina = TAM_COMP;
        $offset = ($pag-1) * $tamPagina;

        $bd = abrirBD();
        $st = $bd->prepare("SELECT cp.nombre as nombreComp,cp.referenciaFabricante as referencia ,cp.caracteristicas as caracteristicas,  
            cp.imagen as imagen,pr.nombre as nombreProv,tc.nombre as nombreTipo, cp.dimensiones as dimensiones,
            tc.idtipocomponente as idtipocomponente
            FROM componente cp
            INNER JOIN proveedor pr ON cp.idproveedor= pr.idproveedor
            INNER JOIN tipocomponente tc ON cp.idtipocomponente=tc.idtipocomponente
            ORDER BY cp.referenciaFabricante
            limit ?,?");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }

        $st->bind_param('ii',$offset,$tamPagina);       
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $componentes = [];
        while ($cp = $res->fetch_assoc()){
            $componentes[] = $cp;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $componentes;
    }

    //para la pagina principal
    public static function listadoBusca(){

        $bd = abrirBD();
        $st = $bd->prepare("SELECT cp.nombre as nombreComp,cp.referenciaFabricante as referencia ,cp.caracteristicas as caracteristicas,  
            cp.imagen as imagen,pr.nombre as nombreProv,tc.nombre as nombreTipo, cp.dimensiones as dimensiones,
            tc.idtipocomponente as idtipocomponente
            FROM componente cp
            INNER JOIN proveedor pr ON cp.idproveedor= pr.idproveedor
            INNER JOIN tipocomponente tc ON cp.idtipocomponente=tc.idtipocomponente
            ORDER BY cp.referenciaFabricante");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }
  
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $componentes = [];
        while ($cp = $res->fetch_assoc()){
            $componentes[] = $cp;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $componentes;
    }

    //filtra los componentes por su tipo
    public static function listadoFilt($idtipocomponente,$pag){ 
        $tamPagina = TAM_COMP;
        $offset = ($pag-1) * $tamPagina;

        $bd = abrirBD();
        $st = $bd->prepare("SELECT cp.nombre as nombreComp,cp.referenciaFabricante as referencia,cp.caracteristicas as caracteristicas,  
            cp.imagen as imagen,pr.nombre as nombreProv,tc.nombre as nombreTipo, cp.dimensiones as dimensiones
            FROM componente cp
            INNER JOIN proveedor pr ON cp.idproveedor= pr.idproveedor
            INNER JOIN tipocomponente tc ON cp.idtipocomponente=tc.idtipocomponente
            where tc.idtipocomponente=?
            limit ?,?"); 
          
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }

        $st->bind_param('iii',$idtipocomponente,$offset,$tamPagina);       
        
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $componentes = [];
        while ($cp = $res->fetch_assoc()){
            $componentes[] = $cp;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $componentes;
    }

    //filtra los componentes por su proveedor de momento sin uso
    public static function listadoProv($id){      
        $bd = abrirBD();
        $st = $bd->prepare("SELECT cp.nombre as nombreComp,cp.referenciaFabricante as referencia,cp.caracteristicas as caracteristicas,  
            cp.imagen as imagen,pr.nombre as nombreProv,tc.nombre as nombreTipo, cp.dimensiones as dimensiones
            FROM componente cp
            INNER JOIN proveedor pr ON cp.idproveedor= pr.idproveedor
            INNER JOIN tipocomponente tc ON cp.idtipocomponente=tc.idtipocomponente
            where pr.idproveedor=?"); 
          
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }

        $st->bind_param('i',$id);       
        
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $componentes = [];
        while ($cp = $res->fetch_assoc()){
            $componentes[] = $cp;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $componentes;
    }

    //saber el total de componentes 
    public static function cuenta(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM componente");
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

    //saber el total de componentes 
    public static function cuentaFilt($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM componente 
        where idtipocomponente=?");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }

        $st->bind_param('i',$id);
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
    //insertar componentes en la tabla
    public function insertar(){
        $bd = abrirBD();

        $st = $bd->prepare("INSERT INTO componente (referenciaFabricante,idtipocomponente,nombre,caracteristicas,dimensiones,imagen,idproveedor) 
        VALUES (?,?,?,?,?,?,?)");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param("sissssi", 
            $this->referenciaFabricante,
            $this->idtipocomponente,
            $this->nombre,
            $this->caracteristicas,
            $this->dimensiones,
            $this->imagen,
            $this->idproveedor);

        $res = $st->execute();

        if ($res === FALSE) {
            die("ERROR de ejecucion: " . $bd->error);
        }

        $this->idcompomente = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    //borrar componentes
    public static function borrar($id){
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM componente WHERE  referenciaFabricante=?");

        if ($st === false) {
            die($bd->error);
        }

        $st->bind_param('s', $id);
        $ok = $st->execute();

        if ($ok === false) {
            die($bd->error);
        }

        $st->close();
        $bd->close();
    }

    //saber si existe un componente con esa referencia
    public static function carga($nombre){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT referenciaFabricante as nom FROM componente 
        WHERE referenciaFabricante=?");
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
    
    //buscar un componente atrave de una referencia
    public static function cargarComp($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM componente
                WHERE referenciaFabricante=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("s", $id);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $comp = $res->fetch_object('componente');
        $res->free();
        $st->close();
        $bd->close();
        return $comp;
    }


    //buscar si el proveedor tiene algun componente en nuestra bd
    public static function buscarProv($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM componente 
        WHERE idproveedor=?");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("i",$id);
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

    //buscar un componente y mostrar todos sus datos
    public static function buscar($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT cp.nombre as nombreComp,cp.referenciaFabricante as referencia,cp.caracteristicas as caracteristicas,  
            cp.imagen as imagen,pr.nombre as nombreProv,tc.nombre as nombreTipo, cp.dimensiones as dimensiones
            FROM componente cp
            INNER JOIN proveedor pr ON cp.idproveedor= pr.idproveedor
            INNER JOIN tipocomponente tc ON cp.idtipocomponente=tc.idtipocomponente
            where cp.referenciaFabricante=?"); 
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("s", $id);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $componente = $res->fetch_object('Componente');
        $res->free();
        $st->close();
        $bd->close();
        return $componente;
    }
    
}