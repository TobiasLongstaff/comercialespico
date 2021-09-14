<?php
    session_start();
    require 'conexion.php';

    $ubicacion = '';

    if(isset($_POST['ubicacion']))
    {
        if(!empty($_SESSION['nombre_carpeta']))
        {               
            $carpeta = $_SESSION['nombre_carpeta'];
            $ubicacion = $carpeta.'/'.$_POST['ubicacion'];
        }
        else
        { 
            $ubicacion = $_POST['ubicacion'];
        }

        $ruta = '../carpetas-clientes/'.$ubicacion.'/';    

        function obtener_estructura_directorios($ruta, $ubicacion)
        {
            if(is_dir($ruta))
            {
                $gestor = opendir($ruta);
                while(($archivo = readdir($gestor)) !== false)  
                {
                    if($archivo != "." && $archivo != "..") 
                    {
                        echo '
                        <div class="container-ico-archivos" filaId=https://drivecomercial.com/carpetas-clientes/'.$ubicacion.'/'.$archivo.'>
                            <button class="mostrar-archivo">
                                <i class="upload-file fas fa-file-alt"></i><br>
                                <label>'.$archivo.'</label>
                            </button>
                        </div>';
                    }
                }
                closedir($gestor);
            } 
            else 
            {
                echo "No es una ruta de directorio valida<br/>";
                echo $ruta;
            }
        }
    
        obtener_estructura_directorios($ruta, $ubicacion);
    }
?>