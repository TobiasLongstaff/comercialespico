<?php

    session_start();
    require 'conexion.php';

    if(isset($_POST['id']) && isset($_SESSION['id_usuario']))
    {
        $id = $_POST['id'];

        $sql_delete = "DELETE FROM usuarios WHERE id = '$id'";
        $resultado_delete = mysqli_query($conexion, $sql_delete);
        if(!$resultado_delete)
        {
            echo 'Error consultar con soporte ';
        }  
        else
        {
            echo '1';
        }      
    }
    mysqli_close($conexion); 
?>