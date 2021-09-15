<?php
    require 'conexion.php';

    /**
    * @version 1.0
    */

    require("../assets/plugins/class.phpmailer.php");
    require("../assets/plugins/class.smtp.php");

    $nombre = 'DriveComercial.com';
    
    // Datos de la cuenta de correo utilizada para enviar vía SMTP
    $smtpHost = "c2340804.ferozo.com";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "administracion@drivecomercial.com";  // Mi cuenta de correo
    $smtpClave = "VUtonibo11";  // Mi contraseña

    $mail_usuario = '';

    if(isset($_POST['hash']) && isset($_POST['mail']) && isset($_POST['selectlist_permisos']))
    {
        $mail_usuario = $_POST['mail'];
        $hash = $_POST['hash'];
        $permisos = $_POST['selectlist_permisos'];

        $sql="UPDATE usuarios SET tipo = '$permisos' WHERE mail = '$mail_usuario' AND hash = '$hash'";
        $resultado = mysqli_query($conexion,$sql);
        if(!$resultado)
        {
            echo 'error';
        }
        else
        {
            $sql = "SELECT * FROM usuarios WHERE mail = '$mail_usuario'";
            $resultado = mysqli_query($conexion, $sql);
            if($filas = mysqli_fetch_array($resultado))
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
                $mail->AddAddress($mail_usuario);
            
                $mail->Subject = "Tu cuenta de drivecomercial.com ha sido aprobada "; // Este es el titulo del email.
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
                                <h2 style="color: #7D7D7D;">Su cuenta ya se encuentra habilitada para realizar operaciones dentro del sistema.<br>
                                En caso de inconvenientes contactar son soporte tecnico.</h2>                 
                            </div>
                            <a style="color: #ffffff;" href="https://drivecomercial.com/">Iniciar sesión</a>               
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
    }
    else
    {
        echo 'error';
    }
    mysqli_close($conexion);
?>