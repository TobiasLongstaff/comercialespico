<?php

    require 'partials/conexion.php';

    if(empty($_SESSION['id_usuario']))
    {
        header("location: index.php");
    }
    else
    {
        $tipo_usuario = $_SESSION['tipo_usuario'];
        $nombre_usuario = $_SESSION['nombre_usuario'];
        if(empty($_SESSION['nombre-carpeta-cliente']))
        {
            $carpeta_usuario = '';
        }
        else
        {
            $carpeta_usuario = $_SESSION['nombre-carpeta-cliente'];
        }
        
    }

?>        
        <main class="container-menu">
            <nav>
                <h1>Archivos de <?=$nombre_usuario?></h1>
                <div>
                    <?php
                        if($tipo_usuario == 'admin')
                        {

                    ?>
                            <a href="configuracion.php">
                                <button type="button" class="btn-nav">
                                    <i class="uil uil-setting"></i>
                                </button>
                            </a> 
                    <?php
                        }
                    ?>
                    <a href="cerrarsesion.php">
                        <button type="button" class="btn-nav">
                            <i class="uil uil-sign-out-alt"></i>
                        </button>
                    </a> 
                </div>   
            </nav>
            <div class="container-general">
                <div class="container-archivos">
                    <div class="container-controles">
                        <div>
                            <?php
                                if($tipo_usuario == 'admin' || $tipo_usuario == 'editor')
                                {

                            ?>
                                    <button type="button" class="btn-nueva-carpeta" id="btn-volver">
                                        <i class="fas fa-chevron-left"></i>
                                    </button> 
                                    <button type="button" class="btn-nueva-carpeta" id="crear-nueva-carpeta">
                                        <i class="fas fa-folder-plus"></i>
                                    </button>       
                            <?php
                                }
                            ?>                    
                        </div>
                        <div class="container-nombre-ubicacion">
                            <h2>../<?=$carpeta_usuario?>/</h2>
                            <h2 id="text-ubicacion"></h2>                            
                        </div>
                    </div>
                    <div id="container-carpetas">
                    </div>
                    <?php
                        if($tipo_usuario == 'admin' || $tipo_usuario == 'editor')
                        {
                    ?>
                            <div class="footer-archivos">
                                <form id="form-cliente-asociado" method="post">
                                    <input type="hidden" id="nombre-carpeta" value="<?=$carpeta_usuario?>/">
                                    <label>Cliente</label><br>
                                    <select id="select-cliente" class="selectlist">
                                        <?php
                                            $sql="SELECT * FROM usuarios WHERE tipo = 'clientes'";
                                            $resultado=mysqli_query($conexion,$sql);
                                            while($filas = mysqli_fetch_array($resultado))
                                            {
                                                echo '<option value="'.$filas['id'].'">'.$filas['nombre_apellido'].'</option>';
                                            }
                                        ?>
                                        
                                    </select>                        
                                    <input type="submit" class="btn-enviar" value="Asociar Cliente">    
                                </form>
                            </div>
                    <?php
                        }
                    ?>
                </div>
                <?php
                    if($tipo_usuario == 'admin' || $tipo_usuario == 'editor')
                    {                
                ?>
                        <div class="cantainer-subir-archivo">
                            <h2>Subir Archivos</h2>
                            <div class="file-upload">
                                <input type="hidden" id="nombre-carpeta-destino">
                                <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Agregar Archivos</button>
                                <div class="image-upload-wrap">
                                    <input multiple class="file-upload-input" type='file' id="inputArchivos" onchange="readURL(this);" />
                                    <div class="drag-text">
                                        <h3>Arrastre y suelte un archivo o seleccione agregar archivo</h3>
                                    </div>
                                </div>
                                <div class="file-upload-content">
                                    <i class="upload-file fas fa-file-alt"></i>
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUpload()" class="remove-image">Remover <span class="image-title">Uploaded Image</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="container-btn-upload">
                                <button id="btnEnviar" class="btn-enviar">Subir</button>
                            </div>
                            <div class="alert-info" id="estado"></div>           
                        </div>
                <?php
                    }           
                ?>
            </div>
            <div class="overlay" id="overlay">
                <div class="container-popup" id="popup">
                    <div class="header-popup">
                        <button type="button" id="btn-cerrar-popup" class="btn-cerrar-popup">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="container-btn-popup">
                        <iframe id="iframe-popup" src=""></iframe>                
                    </div>
                </div>
            </div>
        </main>
    </body>    
    <script src="assets/plugins/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        var ubicacion = '<?=$carpeta_usuario?>';
        var tipo = '<?=$tipo_usuario?>';
    </script>
    <script src="assets/scripts/menu.js"></script>
</html>