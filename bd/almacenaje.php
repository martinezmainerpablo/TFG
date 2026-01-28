<?php
require_once __DIR__ .'/bd.php';

class Almacenaje{

    public $idalmacenaje;
    public $referenciaFabricante;
    public $imagen;
    public $stock;
    public $ubicacion;
    public $idinventario;


    //listado filtrado de los componentes de un inventario por su usuario
    public static function listadoFilt($id,$pag){
        $tamPagina = TAM_COMP;
        $offset = ($pag-1) * $tamPagina;

        $bd = abrirBD();
        $st = $bd->prepare("SELECT alm.idalmacenaje,alm.stock,alm.ubicacion, cp.referenciaFabricante AS referencia, cp.imagen, cp.nombre, cp.dimensiones, us.idusuario
            FROM almacenaje alm
            INNER JOIN componente cp ON alm.referenciaFabricante=cp.referenciaFabricante
            INNER JOIN inventario inv ON alm.idinventario= inv.idinventario
            INNER JOIN  usuario us ON inv.idusuario = us.idusuario
            WHERE us.idusuario=?
            ORDER BY alm.ubicacion
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
        $componentes = [];
        while ($comp = $res->fetch_assoc()){
            $componentes[] = $comp;
        }
        $res -> free();
        $st->close();
        $bd -> close();
        return $componentes;
    }

    //listado filtrado de los componentes de un inventario por su usuario para buscador
    public static function listadoFiltBus($id){

        $bd = abrirBD();
        $st = $bd->prepare("SELECT alm.idalmacenaje,alm.stock,alm.ubicacion, cp.referenciaFabricante AS referencia, cp.imagen, cp.nombre, cp.dimensiones, us.idusuario
            FROM almacenaje alm
            INNER JOIN componente cp ON alm.referenciaFabricante=cp.referenciaFabricante
            INNER JOIN inventario inv ON alm.idinventario= inv.idinventario
            INNER JOIN  usuario us ON inv.idusuario = us.idusuario
            WHERE us.idusuario=?
            ORDER BY alm.ubicacion"); 

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
        while ($comp = $res->fetch_assoc()){
            $componentes[] = $comp;
        }
        $res -> free();
        $st->close();
        $bd -> close();
        return $componentes;
    }

    //listado filtrado de los componentes de un inventario para el aadmin
    public static function listadoFiltAdm($id,$pag){
        $tamPagina = TAM_COMP;
        $offset = ($pag-1) * $tamPagina;

        $bd = abrirBD();
        $st = $bd->prepare("SELECT alm.idalmacenaje,alm.stock,alm.ubicacion, cp.referenciaFabricante AS referencia, cp.imagen, cp.nombre, cp.dimensiones
            FROM almacenaje alm
            INNER JOIN componente cp ON alm.referenciaFabricante=cp.referenciaFabricante
            WHERE alm.idinventario=?
            ORDER BY alm.ubicacion
            limit ?,?"); 

        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }      
        $st->bind_param('iii',$id,$offset,$tamPagina); 
        $ok = $st->execute();    
        if($ok === false){
             die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $componentes = [];
        while ($comp = $res->fetch_assoc()){
            $componentes[] = $comp;
        }
        $res -> free();
        $st->close();
        $bd -> close();
        return $componentes;
    }

    //listado filtrado de los componentes de un inventario para el admin buscador
    public static function listadoFiltAdmBus($id){

        $bd = abrirBD();
        $st = $bd->prepare("SELECT alm.idalmacenaje,alm.stock,alm.ubicacion, cp.referenciaFabricante AS referencia, cp.imagen, cp.nombre, cp.dimensiones
            FROM almacenaje alm
            INNER JOIN componente cp ON alm.referenciaFabricante=cp.referenciaFabricante
            WHERE alm.idinventario=?
            ORDER BY alm.ubicacion"); 

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
        while ($comp = $res->fetch_assoc()){
            $componentes[] = $comp;
        }
        $res -> free();
        $st->close();
        $bd -> close();
        return $componentes;
    }
    //saber el total de componentes de un inventario, para luego si es 0 poder borrarlo
    public static function cuentaFilt($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) AS num FROM almacenaje 
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
        
        return $datos['num'];
    }

    //saber el total de componentes de un inventario 
    public static function cuenta($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) AS num FROM almacenaje  alm
            INNER JOIN inventario inv ON alm.idinventario= inv.idinventario
            INNER JOIN  usuario us ON inv.idusuario = us.idusuario
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
    //insertar en la bd
    public function insertar(){
        $bd = abrirBD();

        $st = $bd->prepare("INSERT INTO almacenaje (referenciaFabricante,stock,ubicacion,idinventario) 
        VALUES (?,?,?,?)");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param("sisi", 
            $this->referenciaFabricante,
            $this->stock,
            $this->ubicacion,
            $this->idinventario);

        $res = $st->execute();

        if ($res === FALSE) {
            die("ERROR de ejecucion: " . $bd->error);
        }

        $this->idalmacenaje = $bd->insert_id;
        $st->close();
        $bd->close();
    } 

    //borrar componente del almacenaje borrarAlmacenaje.php
    public static function borrar($id){
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM almacenaje WHERE  idalmacenaje=?");

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

    //cargar el componente del inventario y poder actualizar el stock actualizarStock.php
    public static function cargar($id)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT alm.idalmacenaje,alm.stock,alm.ubicacion, cp.referenciaFabricante AS referencia, cp.imagen, cp.nombre, cp.dimensiones
            FROM almacenaje alm
            INNER JOIN componente cp ON alm.referenciaFabricante=cp.referenciaFabricante 
            Where alm.idalmacenaje=?");

        if ($st === false) {
            die($bd->error);
        }

        $st->bind_param('i', $id);
        $ok = $st->execute();

        if ($ok === false) {
            die($bd->error);
        }

        $res = $st->get_result();

        $almacenaje = $res->fetch_object("Almacenaje");

        $res->free();
        $st->close();
        $bd->close();

        return $almacenaje;
    }

    //actualizar el stock actualizar.php
    public function actualizar()
    {
        $bd = abrirBD();
        $st = $bd->prepare("UPDATE almacenaje SET stock=?
         WHERE idalmacenaje=?");

        if ($st === false) {
            die($bd->error);
        }

        $st->bind_param('ii',
            $this->stock, 
            $this->idalmacenaje);
        $ok = $st->execute();

        if ($ok === false) {
            die($bd->error);
        }
        
        $st->close();
        $bd->close();

    }

    //buscar si el componente esta en algun inventario 
    public static function buscar($id){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) AS num FROM almacenaje 
        WHERE referenciaFabricante=?");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("s", $id);
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

    //buscar si hay un componente ocupando una ubicacion guardarComp.php
    public static function ocupado($id,$ubi){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) AS num FROM almacenaje 
        WHERE idinventario=? && ubicacion=?");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("is", $id,$ubi);
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