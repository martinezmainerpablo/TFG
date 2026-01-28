<?php
require_once __DIR__.'/bd.php';

class Proveedor {
    public $idproveedor;
    public $nombre;
    public $telefono;
    public $direccion;
    public $email;
    public $logo;

    //listado de la pagina webProv.php
    public static function listado($pag){
        $tamPagina = TAM_PROV;
        $offset = ($pag-1) * $tamPagina;

        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM proveedor
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
        $proveedores = [];
        while ($prov = $res->fetch_assoc()){
            $proveedores[] = $prov;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $proveedores;
    }
    
    //listado de la pagina webProv.php para la busqueda
    public static function listadoBusca(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM proveedor");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }             

        $ok = $st->execute();  
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $proveedores = [];
        while ($prov = $res->fetch_assoc()){
            $proveedores[] = $prov;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $proveedores;
    }

    //contar el numero total de proveedores para hacer la paginacion
    public static function cuenta(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT COUNT(*) as num FROM proveedor");
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

    //mostrar en el select los proveedores en la pagina formComp.php
    public static function listadoP(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT idproveedor,nombre from proveedor ORDER BY nombre");
        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }
        $ok = $st->execute();
        if ($ok === false) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $proveedores = [];
        while ($pr = $res->fetch_object('proveedor')) {
            $proveedores[] = $pr;
        }
        $res->free();
        $st->close();
        $bd->close();
        return $proveedores;        
    }

    //insertar en la tabla
    public function insertar(){
        $bd = abrirBD();

        $st = $bd->prepare("INSERT INTO proveedor (nombre,email,telefono,direccion,logo) 
        VALUES (?,?,?,?,?)");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param("sssss", 
            $this->nombre,
            $this->email,
            $this->telefono,
            $this->direccion,
            $this->logo);

        $res = $st->execute();

        if ($res === FALSE) {
            die("ERROR de ejecucion: " . $bd->error);
        }

        $this->idproveedor = $bd->insert_id;
        $st->close();
        $bd->close();
    }

    //borrar proveedor(sin uso de momento(dm))
    public static function borrar($id){
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM proveedor WHERE  idproveedor=?");

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

    //compruba que no hay otro prov con el mismo nombre
    public static function cargaNom($nombre){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT nombre as nom FROM proveedor 
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
        $st = $bd->prepare("SELECT telefono as tel FROM proveedor 
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

    //compruba que no hay otro prov con el mismo email
    public static function cargaEm($email){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT email  FROM proveedor 
        WHERE email=?");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("s", $email);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $datos = $res->fetch_assoc();
        $res->free();
        $st->close();
        $bd->close();    
        return $datos['email'];
    }
    
    //compruba que no hay otro prov con el misma direccion
    public static function cargaDir($direccion){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT direccion as dir FROM proveedor 
        WHERE direccion=?");
        if ($st === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $st->bind_param("s", $direccion);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $datos = $res->fetch_assoc();
        $res->free();
        $st->close();
        $bd->close();    
        return $datos['dir'];
    }

    //borrar la imagen del proveedor cuando lo eliminamos
    public static function cargaProv($id) {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM proveedor
                WHERE idproveedor=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("i", $id);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $prov = $res->fetch_object('proveedor');
        $res->free();
        $st->close();
        $bd->close();
        return $prov;
    }


}