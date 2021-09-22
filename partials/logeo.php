<?php

    session_start();
    require 'conexion.php';

    if(isset($_POST['mail']) && isset($_POST['password']))
    {
        $mail = $_POST['mail'];
        $password = sha1($_POST['password']);
        $sql = "SELECT * FROM usuarios WHERE password = '$password' AND mail = '$mail' OR nombre_apellido = '$mail'";
        $resultado = mysqli_query($conexion, $sql);
        $numero_fila = mysqli_num_rows($resultado);
        if($numero_fila == '1')
        {
            $filas = mysqli_fetch_array($resultado);
            $tipo_usuario = $filas['tipo'];

            if($tipo_usuario == 'estandar' || $tipo_usuario == 'admin' || $tipo_usuario == 'editor' || $tipo_usuario == 'clientes')
            {
                $id = $filas['id'];
                $_SESSION['id_usuario'] = $id;
                $_SESSION['tipo_usuario'] = $tipo_usuario;
                $_SESSION['nombre_usuario'] = $filas['nombre_apellido'];
                $_SESSION['mail_usuario'] = $filas['mail'];             
                $_SESSION['nombre_carpeta'] = $filas['nombre_carpeta'];

                $sql_mail = "SELECT * FROM mail";
                $resultado_mail = mysqli_query($conexion, $sql_mail);
                if($filas_mail = mysqli_fetch_array($resultado_mail))
                {
                    $_SESSION['mail_general'] = $filas_mail['correo'];
                }

                echo '1';                
            }
            else
            {
                echo 'Su cuenta está pendiente de aprobación';
            }
        }
        else
        {
            echo 'Usuario o Contraseña incorrectos';
        }
    }
    else
    {
        echo 'Error al cargar los valores contactar con el soporte';
    } 
    mysqli_close($conexion); 
?>