<?php

    session_start();
    require 'conexion.php';

    if(isset($_POST['mail']) && isset($_POST['password']))
    {
        $mail = $_POST['mail'];
        $password = sha1($_POST['password']);
        $sql = "SELECT * FROM usuarios WHERE mail = '$mail' AND password = '$password'";
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

                echo '1';                
            }
            else
            {
                echo 'Su cuenta está pendiente de aprobación';
            }

            if($tipo_usuario == 'clientes')
            {
                $sql_carpeta = "SELECT * FROM carpetas_asociadas WHERE id_cliente = '$id'";
                $resultado_carpeta = mysqli_query($conexion, $sql_carpeta);
                if($filas_carpeta = mysqli_fetch_array($resultado_carpeta))
                {
                    $_SESSION['nombre-carpeta-cliente'] = $filas_carpeta['nombre_carpeta'];
                }
            }
            else
            {
                $_SESSION['nombre-carpeta-cliente'] = $filas['nombre_carpeta'];
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