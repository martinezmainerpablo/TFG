<?php
const TAM_COMP = 12;
const TAM_PROV = 12;
const TAM_INV = 20;
const TAM_SUGERENCIAS = 12;

function abrirBD() {
    $bd = new mysqli(
            "localhost",   // Servidor
            "root",   // Usuario
            "root",     // Contraseña
            "almacen"); // Esquema
    if ($bd->connect_errno) {
        die("Error de conexión: " . $bd->connect_error);
    }
    $bd->set_charset("utf8mb4");
    return $bd;
}

