<?php
require_once __DIR__.'/bd.php';

class Usuario {
    public $idusuario;
    public $nombre;
    public $login;
    public $pwd;
    public $admin;

    public static function cargaLogin($login) {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM usuario
                WHERE login=?");

        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("s", $login);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $usuario = $res->fetch_object('Usuario');
        $res->free();
        $st->close();
        $bd->close();
        return $usuario;
    }

    public function insertar() {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO usuario
                (nombre,login,pwd,admin) 
                VALUES (?,?,?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("sssi", 
                $this->nombre, 
                $this->login, 
                $this->pwd,
                $this->admin);
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $this->idusuario = $bd->insert_id;
        
        $st->close();
        $bd->close();
    }

    //compruba que no hay otro usuaio con el mismo email
    public static function cargaEm($email){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT login  FROM usuario 
            WHERE login=?");

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
        return $datos['login'];
    }

    //borrar 
    public static function borrar($id){
        $bd = abrirBD();
        $st = $bd->prepare("DELETE FROM usuario WHERE  idusuario=?");

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
    
}