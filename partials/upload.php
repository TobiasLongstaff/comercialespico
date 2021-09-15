<?php 
    session_start();
    require 'conexion.php';

    /**
    * @version 1.0
    */

    require("../assets/plugins/class.phpmailer.php");
    require("../assets/plugins/class.smtp.php");

    if(isset($_POST['ubicacion']) && isset($_POST['sub-ubicacion']))
    {
        $ubicacion = $_POST['ubicacion'];
        $sub_ubicacion = $_POST['sub-ubicacion'];
        $conteo = count($_FILES["archivos"]["name"]);

        $sql = "SELECT * FROM usuarios WHERE nombre_carpeta = '$sub_ubicacion'";
        $resultado=mysqli_query($conexion,$sql);
        if($filas = mysqli_fetch_array($resultado))
        {
            $mail_cliente = $filas['mail'];
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
        
            $mail->Subject = "Nuevo archive en drivecomercial.com"; // Este es el titulo del email.
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
                            <h2 style="color: #7D7D7D;">Te avisamos que se subió un nuevo archivo a la carpeta '.$ubicacion.'. Gracias por utilizar drivecomercial.com<br>
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
        }

        for ($i = 0; $i < $conteo; $i++) 
        {
            $ubicacionTemporal = $_FILES["archivos"]["tmp_name"][$i];
            $nombreArchivo = $_FILES["archivos"]["name"][$i];
            // $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

            // // Renombrar archivo
            // $nuevoNombre = sprintf("%s_%d.%s", uniqid(), $i, $extension);

            // Mover del temporal al directorio actual
            $nombreArchivo = str_replace(' ','-', $nombreArchivo);
            $nombreArchivo = str_replace('#','-', $nombreArchivo);
            move_uploaded_file($ubicacionTemporal, '../carpetas-clientes/'.$ubicacion.'/'.$nombreArchivo);
        }

        
        // Responder al cliente
        echo json_encode(true);
    }
?>