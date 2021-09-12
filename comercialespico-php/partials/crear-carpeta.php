<?php

    require 'conexion.php';   
    session_start();

    if(isset($_SESSION['nombre-carpeta-cliente']) && isset($_POST['nombre_carpeta']))
    {
        $nombre_carpeta = $_POST['nombre_carpeta'];
        $nombre_carpeta_cliente = $_SESSION['nombre-carpeta-cliente'];
        mkdir('../carpetas-clientes/'.$nombre_carpeta_cliente.'/'.$nombre_carpeta, 0777, true);
    }

?>