<?php

    require 'conexion.php';

    if(isset($_POST['cliente']) && isset($_POST['carpeta']))
    {
        $id_cliente = $_POST['cliente'];
        $carpeta = $_POST['carpeta'];

        $sql = "INSERT INTO carpetas_asociadas (nombre_carpeta, id_cliente) VALUES ('$carpeta', '$id_cliente')";
        $resultado = mysqli_query($conexion, $sql);
        if(!$resultado)
        {
            echo 'error';
        }
        else
        {
            echo '1';
        }        
    }

?>