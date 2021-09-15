<?php

    session_start();
    require 'conexion.php';

    if(isset($_POST['id']) && isset($_SESSION['id_usuario']))
    {
        $id = $_POST['id'];

        $sql="SELECT * FROM usuarios WHERE id = '$id'";
        $resultado=mysqli_query($conexion,$sql);
        if($filas = mysqli_fetch_array($resultado))
        {
            $nombre_carpeta = $filas['nombre_carpeta'];

            $carpeta = '../carpetas-clientes/'.$nombre_carpeta.'/';
    
            if (!is_dir($carpeta))
            {
                mkdir($carpeta);
            }
    
            // rmdir($carpeta);    
            if(!rmdir($carpeta))
            {
                echo 'error';
 
            }
            else
            {
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

        }        
    }
    mysqli_close($conexion); 
?>