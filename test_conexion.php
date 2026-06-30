<?php
require_once "clases/myConexionPDO.php";

$db = new mod_db();
$con = $db->getConexion();

if ($con) {
    echo " Conexión exitosa a la BD";
} else {
    echo " Error de conexión";
}