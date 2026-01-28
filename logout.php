<?php
require_once __DIR__ . '/bd/usuario.php';

session_start();
session_destroy();

header('Location: index.php');