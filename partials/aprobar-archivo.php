<?php

    session_start();    
    require 'conexion.php';

    /**
    * @version 1.0
    */

    require("../assets/plugins/class.phpmailer.php");
    require("../assets/plugins/class.smtp.php");

    if(isset($_POST['ubicacion']) && isset($_SESSION['nombre_carpeta']) && isset($_SESSION['mail_general']))
    {
        $ubicacion = $_POST['ubicacion'];
        $nombre_carpeta = $_SESSION['nombre_carpeta'];
        $mail_cliente = $_SESSION['mail_general'];

        $array_archivo = explode('.', $ubicacion);

        $ubicacion_nombre = $array_archivo[0];
        $tipo_archivo = $array_archivo[1];

        $nuevo_nombre = '../carpetas-clientes/'.$nombre_carpeta.$ubicacion_nombre.'!.'.$tipo_archivo;
        $file = '../carpetas-clientes/'.$nombre_carpeta.$ubicacion;

        rename ($file, $nuevo_nombre);

        $sql = "SELECT * FROM mail";
        $resultado=mysqli_query($conexion,$sql);
        if($filas = mysqli_fetch_array($resultado))
        {
            $mail_cliente = $filas['correo'];
            $nombre = 'DriveComercial.com';
        
            // Datos de la cuenta de correo utilizada para enviar vía SMTP
            $smtpHost = "c2340804.ferozo.com";  // Dominio alternativo brindado en el email de alta 
            $smtpUsuario = "administracion@drivecomercial.com";  // Mi cuenta de correo
            $smtpClave = "VUtonibo11";  // Mi contraseña

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
        
            $mail->Subject = "Archivo aprobado en drivecomercial.com"; // Este es el titulo del email.
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
                            <h1>Hola!</h1>
                            <h2 style="color: #7D7D7D;">Te avisamos que El archivo '.$ubicacion.' ha sido aprobado por '.$_SESSION['nombre_usuario'].' Gracias por utilizar drivecomercial.com<br>
                            En caso de inconvenientes contactar con soporte tecnico.</h2>              
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
        }

        echo '1';
    }
    mysqli_close($conexion); 

?>