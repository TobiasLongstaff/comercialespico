<?php
    session_start();

    if(isset($_SESSION['tipo_usuario']))
    {
        if(!empty($_POST['ubicacion'])) 
        {
            $ubicacion = $_POST['ubicacion'];       
        }
        else
        {
            $ubicacion = $_SESSION['nombre_carpeta'];
        }

        $ruta = '../carpetas-clientes/'.$ubicacion;

        function obtener_estructura_directorios($ruta)
        {
            if(is_dir($ruta))
            {
                $gestor = opendir($ruta);
                while(($archivo = readdir($gestor)) !== false)  
                {
                    if($archivo != "." && $archivo != "..") 
                    {
                        $tipo_usuario = $_SESSION['tipo_usuario'];
                        echo '
                        <div class="container-carpetas" filaId='.$archivo.'>
                            <button class="btn-carpeta">
                                <i class="upload-file fas fa-folder"></i><br>
                                <label>'.$archivo.'</label>
                            </button>';
                        if($tipo_usuario == 'admin' || $tipo_usuario == 'editor')
                        {
                            echo '<div class="container-controles-carpetas container-controles-carpetas-'.$archivo.'">
                                <button class="remove-carpeta" type="button" >Eliminar</button>
                            </div>';
                        }
                        echo '</div>';
                    }
                }
                closedir($gestor);
            } 
            else 
            {
                echo "No es una ruta de directorio valida<br/>";
            }
        }
            
        obtener_estructura_directorios($ruta);  
    }
    // mysqli_close($conexion);
?>