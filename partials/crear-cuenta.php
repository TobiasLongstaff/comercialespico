<?php

    session_start();
    require 'conexion.php';    

    /**
    * @version 1.0
    */

    require("../assets/plugins/class.phpmailer.php");
    require("../assets/plugins/class.smtp.php");

    if(isset($_POST['mail']))
    {
        $mail_cliente = $_POST['mail'];
        $nombre_apellido = $_POST['nombre_apellido'];
        $password = sha1($_POST['password']);
        $password_con = sha1($_POST['password_con']);

        $nombre = 'DriveComercial.com';
    
        // Datos de la cuenta de correo utilizada para enviar vía SMTP
        $smtpHost = "c2340804.ferozo.com";  // Dominio alternativo brindado en el email de alta 
        $smtpUsuario = "administracion@drivecomercial.com";  // Mi cuenta de correo
        $smtpClave = "VUtonibo11";  // Mi contraseña

        $hash = md5(rand(0,1000));


        $sql = "SELECT * FROM usuarios WHERE mail = '$mail_cliente' OR nombre_apellido = '$nombre_apellido'";
        $resultado = mysqli_query($conexion, $sql);
        if(mysqli_num_rows($resultado) > 0)
        {
            echo 'El mail ya estan asociados a una cuenta';
        }
        else
        {
            if($password == $password_con)
            {
                $sql = "INSERT INTO usuarios (mail, password, nombre_apellido, hash, nombre_carpeta, tipo) 
                VALUES ('$mail_cliente', '$password', '$nombre_apellido', '$hash', '', 'Pendiente')";
                $resultado = mysqli_query($conexion, $sql);
                if(!$resultado)
                {
                    echo 'Error al cargar los datos, consultar con soporte';
                }
                else
                { 
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->Port = 465; 
                    $mail->SMTPSecure = 'ssl';
                    $mail->IsHTML(true); 
                
                
                    // VALORES A MODIFICAR //
                    $mail->Host = $smtpHost; 
                    $mail->Username = $smtpUsuario; 
                    $mail->Password = $smtpClave;
                
                    $mail->From = $smtpUsuario;
                    $mail->FromName = $nombre;
                    $mail->AddAddress($mail_cliente);
                
                    $mail->Subject = "Tu cuenta de drivecomercial.com se encuentra a espera de aprobación"; // Este es el titulo del email.
                    $mail->Body = '
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
                        <style type="text/css">
                            body
                            {
                                margin: 0;
                                padding: 0;
                                background-color: #ffffff;
                            }
                
                            table
                            {
                                border-spacing: 0;
                            }
                
                            td
                            {
                                padding: 0;
                            }
                
                            .contenido
                            {
                                width: 100%;
                                padding-bottom: 40px;
                                display: flex;
                                justify-content: center;
                                margin-top: 2%;
                            }
                
                            a
                            {
                                color: #ffffff;
                                background-color: #0555bd;
                                border-radius: 5px;
                                padding: 20px;
                                font-size: 25px;
                                text-decoration: none;
                            }
                
                
                            h1
                            {
                                color: #0555bd;
                            }
                
                            h2
                            {
                                margin-bottom: 50px;
                            }
                
                        </style>
                    </head>
                    <body>
                        <div class="contenido">
                            <div>
                                <div>
                                    <h1>¡Hola!</h1>
                                    <h2 style="color: #7D7D7D;">Su cuente se encuentra en espera de aprobación, espere a que comprobemos todos los <br>
                                        datos para dar de alta su cuente, una vez esté aprobado llegara un mail <br>
                                        de aviso. Gracias por utilizar drivecomercial.com<br>
                                        En caso de inconvenientes contactar con soporte técnico.</h2>              
                                </div>               
                            </div>
                        </div>
                    </body>';
                    if(!$mail->send())
                    {
                        echo 'error';
                    }
                    else
                    {
                       echo '1'; 
                    }
                    
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->Port = 465; 
                    $mail->SMTPSecure = 'ssl';
                    $mail->IsHTML(true); 
                
                
                    // VALORES A MODIFICAR //
                    $mail->Host = $smtpHost; 
                    $mail->Username = $smtpUsuario; 
                    $mail->Password = $smtpClave;
                
                    $mail->From = $smtpUsuario;
                    $mail->FromName = $nombre;
                    $mail->AddAddress($smtpUsuario);
                
                    $mail->Subject = "Nueva cuenta de drivecomercial.com"; // Este es el titulo del email.
                    $mail->Body = '
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
                        <style type="text/css">
                            body
                            {
                                margin: 0;
                                padding: 0;
                                background-color: #ffffff;
                            }
                
                            table
                            {
                                border-spacing: 0;
                            }
                
                            td
                            {
                                padding: 0;
                            }
                
                            .contenido
                            {
                                width: 100%;
                                padding-bottom: 40px;
                                display: flex;
                                justify-content: center;
                                margin-top: 2%;
                            }
                
                            a
                            {
                                color: #ffffff;
                                background-color: #220088;
                                border-radius: 5px;
                                padding: 20px;
                                font-size: 25px;
                                text-decoration: none;
                            }
                
                
                            h1
                            {
                                color: #220088;
                            }
                
                            h2
                            {
                                margin-bottom: 50px;
                            }
                
                        </style>
                    </head>
                    <body>
                        <div class="contenido">
                            <div>
                                <div>
                                    <h2 style="color: #7D7D7D;">'.$nombre_apellido.'</h2>    
                                    <h2 style="color: #7D7D7D;">'.$mail_cliente.'</h2>             
                                </div>
                                <a style="color: #ffffff;" href="https://drivecomercial.com/aprobar-usuario.php?mail='.$mail_cliente.'&hash='.$hash.'">Activar cuenta</a>                 
                            </div>
                        </div>
                    </body>';
                    if(!$mail->send())
                    {
                        echo 'error';
                    }
                    else
                    {
                        echo '1';   
                    } 
                }
            }
            else
            {
                echo 'Las contraseñas no son iguales';
            }
        }
    }
    mysqli_close($conexion); 
?>