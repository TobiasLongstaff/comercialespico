<?php

    session_start();
    require 'conexion.php';

    if(isset($_POST['id']))
    {
        $id = $_POST['id'];
        $sql = "SELECT * FROM usuarios WHERE id = '$id'";
        $json = array();
        $resultado=mysqli_query($conexion,$sql);
        if($filas = mysqli_fetch_array($resultado))
        {
            $json[] = array(
                'nombre' => $filas['nombre_apellido']
            );
        }
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
        mysqli_close($conexion);        
    }
?>