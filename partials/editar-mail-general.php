<?php

    session_start();
    require 'conexion.php';
    

    if(isset($_POST['mail']) && isset($_SESSION['id_usuario']))
    {
        $mail = $_POST['mail'];

        $sql="UPDATE mail SET correo = '$mail'";
        $resultado = mysqli_query($conexion,$sql);
        if(!$resultado)
        {
            echo '2';    
        }
        else
        {
            $_SESSION['mail_general'] = $mail;
            echo '1';
        }
    }
    mysqli_close($conexion);

?>