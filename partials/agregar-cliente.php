<?php

    session_start();
    require 'conexion.php';

    if(isset($_POST['nombre']) && isset($_SESSION['id_usuario']))
    {
        $nombre = $_POST['nombre'];
        $password = sha1($_POST['password']);
        $mail = $_POST['mail'];
        $hash = md5(rand(0,1000));

        $sql = "INSERT INTO usuarios (nombre_apellido, mail, password, hash, nombre_carpeta, tipo) 
        VALUES ('$nombre', '$mail', '$password', '$hash', '', 'clientes')";
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
    mysqli_close($conexion); 

?>