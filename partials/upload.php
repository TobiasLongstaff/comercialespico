<?php

    require 'conexion.php';   
    session_start();

    if(isset($_SESSION['nombre-carpeta-cliente']) && isset($_POST['ubicacion']))
    {
        $nombre_carpeta_cliente = $_SESSION['nombre-carpeta-cliente'];
        $ubicacion = $_POST['ubicacion'];
        $conteo = count($_FILES["archivos"]["name"]);
        for ($i = 0; $i < $conteo; $i++) 
        {
            $ubicacionTemporal = $_FILES["archivos"]["tmp_name"][$i];
            $nombreArchivo = $_FILES["archivos"]["name"][$i];
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

            // Renombrar archivo
            $nuevoNombre = sprintf("%s_%d.%s", uniqid(), $i, $extension);

            // Mover del temporal al directorio actual
            move_uploaded_file($ubicacionTemporal, '../carpetas-clientes/'.$nombre_carpeta_cliente.'/'.$ubicacion.'/'.$nuevoNombre);
        }
        // Responder al cliente
        echo json_encode(true);
    }
?>