<?php
    require 'partials/conexion.php';
    require 'partials/header.html';
    session_start();

    if(empty($_SESSION['id_usuario']))
    {
        header('Location: index.php');
    }


    $id = '';
    $nombre_apellido = '';
    $hash = '';

    if(isset($_GET['hash']) && isset($_GET['mail']))
    {
        $mail_usuario = $_GET['mail'];
        $hash = $_GET['hash'];
        
        $sql="SELECT * FROM usuarios WHERE mail = '$mail_usuario' AND hash = '$hash'";
        $resultado=mysqli_query($conexion,$sql);
        while($filas = mysqli_fetch_array($resultado))
        {
            $id = $filas['id'];
            $nombre_apellido = $filas['nombre_apellido'];
        }
    }
?>
        <main class="container">
            <div class="container-aprobar">
                <nav style="--delay: .3s">
                    <h2>Verificación y Aprobación de Usuarios</h2>
                    <div class="container-controles-nav">
                        <a href="cerrarsesion.php">
                            <button type="button" class="btn-nav">
                                <i class="uil uil-sign-out-alt"></i>
                            </button>             
                        </a>                
                    </div>
                </nav>
                <div class="container-aprobar-usuarios">
                    <form id="from-aprobar-usuario" method="POST">   
                        <h2>Datos del usuario</h3>              
                        <div class="container-datos-usuario">                 
                            <p>id: <?=$id?></p>
                            <p>Nombre y apellido: <?=$nombre_apellido?></p>
                            <span>Mail: </span>
                            <input class="textbox-general-abm" type="text" id="mail-usuario" value="<?=$mail_usuario?>" require disabled><br>
                            <span>Hash: </span>
                            <input class="textbox-general-abm" type="text" id="hash-usuario" value="<?=$hash?>" require disabled>
                        </div>
                        <select class="selectlist" id="select-permisos">
                            <option value="" disabled selected>Permisos</option>
                            <option value="editor">Editor</option>
                            <option value="admin">Administrador</option>
                        </select>
                        <input class="descargar-archivo" type="submit" value="Aprobar Cuenta">
                    </form>
                </div>
            </div>
        </main>
    </body>
    <script src="assets/plugins/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/sweetalert2.all.min.js"></script>
    <script src="assets/scripts/aprobar_usuario.js"></script>
 </html>