<?php

    session_start();
    require 'conexion.php';
    

    if(isset($_POST['id']) && isset($_SESSION['id_usuario']))
    {
        $id = $_POST['id']; 
        $nombre = $_POST['nombre'];
        $password = sha1($_POST['password']);
        $mail = $_POST['mail'];

        $sql="UPDATE usuarios SET nombre_apellido = '$nombre', password = '$password', mail = '$mail' WHERE id = '$id'";
        $resultado = mysqli_query($conexion,$sql);
        if(!$resultado)
        {
            echo '2';    
        }
        else
        {
            echo '1';
        }
    }
    mysqli_close($conexion);

?>