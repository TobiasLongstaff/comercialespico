<?php

    require 'conexion.php';   
    session_start();

    if($_SESSION['tipo_usuario'] == 'admin' || $_SESSION['tipo_usuario'] == 'editor')
    {
        if(isset($_POST['nombre_carpeta']) && isset($_POST['ubicacion']))
        {
            $nombre_carpeta = $_POST['nombre_carpeta'];
            $nombre_carpeta = str_replace(' ','-', $nombre_carpeta);
            $ubicacion_actual = $_POST['ubicacion'];
            mkdir('../carpetas-clientes/'.$ubicacion_actual.'/'.$nombre_carpeta , 0777, true);
        }        
    }

?>