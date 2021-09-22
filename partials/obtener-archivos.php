<?php
    session_start();

    $ubicacion = '';

    if(isset($_POST['ubicacion']) && isset($_SESSION['tipo_usuario']))
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
                        $tipo_usuario = $_SESSION['tipo_usuario'];
                        $archivo_class = str_replace('.', '-', $archivo);
                        $archivo_class = str_replace('!', '-', $archivo_class);
                        echo '
                        <div class="container-btn-archivos" archivo="'.$archivo.'" filanom="'.$archivo_class.'" filaId=https://drivecomercial.com/carpetas-clientes/'.$ubicacion.'/'.$archivo.'>
                            <button class="mostrar-archivo">';
                                if (strpos($archivo, '!') == false) 
                                {
                                    echo '<i class="upload-file uil uil-file"></i><br>';
                                }
                                else
                                {
                                    echo '<i class="upload-file-check uil uil-file-check"></i><br>';
                                }
                        
                            echo '<label>'.$archivo.'</label>
                            </button>
                            <div class="container-controles-archivos container-controles-archivos-'.$archivo_class.'">
                                <a class="container-btn-descargar" href="https://drivecomercial.com/carpetas-clientes/'.$ubicacion.'/'.$archivo.'" download>
                                    <button class="descargar-archivo" type="button">Descargar</button>
                                </a>';
                        if($tipo_usuario == 'admin' || $tipo_usuario == 'editor')
                        {
                            echo '<button class="remove-archivo" type="button">Eliminar</button>';
                        }
                        else
                        {
                            if (strpos($archivo, '!') == false) 
                            {
                                echo '<button class="aprobar-archivo" type="button">Aprobar</button>';
                            }
                        }
                        echo '</div>
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