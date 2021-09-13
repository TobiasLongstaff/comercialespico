<?php

    require 'conexion.php';   
    session_start();

    if($_SESSION['tipo_usuario'] == 'admin' || $_SESSION['tipo_usuario'] == 'editor')
    {
        if(isset($_POST['nombre_carpeta']))
        {
            $nombre_carpeta = $_POST['nombre_carpeta'];
            mkdir('../carpetas-clientes/'.$nombre_carpeta , 0777, true);
        }        
    }

?>