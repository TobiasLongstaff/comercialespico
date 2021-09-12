<?php

    session_start();
    require 'conexion.php';    

    $sql="SELECT * FROM usuarios WHERE tipo = 'clientes'";
    $resultado=mysqli_query($conexion,$sql);
    $json = array();
    while($filas = mysqli_fetch_array($resultado))
    {
        $json[] = array(
            'id' => $filas['id'],
            'nombre' => $filas['nombre_apellido'],
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
    mysqli_close($conexion);

?>