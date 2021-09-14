<?php

    session_start();
    require 'conexion.php';

    if(isset($_POST['nombre']) && isset($_SESSION['id_usuario']))
    {
        $nombre = $_POST['nombre'];
        $password = sha1($_POST['password']);
        $mail = $_POST['mail'];
        $hash = md5(rand(0,1000));
        $nombre_carpeta = str_replace(' ','-', $nombre);
        $nombre_carpeta = strtolower($nombre_carpeta);

        $sql = "INSERT INTO usuarios (nombre_apellido, mail, password, hash, nombre_carpeta, tipo) 
        VALUES ('$nombre', '$mail', '$password', '$hash', '$nombre_carpeta', 'clientes')";
        $resultado = mysqli_query($conexion, $sql);
        if(!$resultado)
        {
            echo 'error';
        }
        else
        {
            mkdir('../carpetas-clientes/'.$nombre_carpeta , 0777, true); 
            echo '1';
        }
    }
    mysqli_close($conexion); 

?>