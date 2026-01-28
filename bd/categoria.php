<?php
require_once __DIR__.'/bd.php';

class Categoria {
    public $idcategoria;
    public $nombre;

    public static function listado(){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM categoria");   
        if ($st === FALSE){
            die ("ERROR SQL: ".$bd->error);
        }       
        $ok = $st->execute();    
        if($ok === false){
            die ("ERROR: " . $bd->error);
        }        
        $res = $st->get_result();
        $categorias = [];
        while ($cat = $res->fetch_assoc()){
            $categorias[] = $cat;
        }
        $res -> free();
        $st->close();
        $bd -> close();

        return $categorias;
    }

    
}