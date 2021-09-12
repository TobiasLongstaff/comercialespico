<?php
    session_start();

    if(isset($_SESSION['nombre-carpeta-cliente']))
    {
        function obtener_estructura_directorios($ruta)
        {
            if(is_dir($ruta))
            {
                $gestor = opendir($ruta);
                while(($archivo = readdir($gestor)) !== false)  
                {
                    if($archivo != "." && $archivo != "..") 
                    {
                        echo '
                        <div class="container-ico-archivos" filaId=http://localhost/comercialespico-php/carpetas-clientes/'.$_SESSION['nombre-carpeta-cliente'].'/'.$_POST['ubicacion'].'/'.$archivo.'>
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
            }
        }

        function obtener_estructura_directorios_cliente($ruta)
        {
            if(is_dir($ruta))
            {
                $gestor = opendir($ruta);
                while(($archivo = readdir($gestor)) !== false)  
                {
                    if($archivo != "." && $archivo != "..") 
                    {
                        echo '
                        <div class="container-ico-archivos" filaId=http://localhost/comercialespico-php/carpetas-clientes/'.$_SESSION['nombre-carpeta-cliente'].'/'.$archivo.'>
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
            }
        }

        if(isset($_POST['ubicacion']))
        {
            $ruta = '../carpetas-clientes/'.$_SESSION['nombre-carpeta-cliente'].'/'.$_POST['ubicacion'];
            obtener_estructura_directorios($ruta);
        }
        else
        {
            $ruta = '../carpetas-clientes/'.$_SESSION['nombre-carpeta-cliente'];
            obtener_estructura_directorios_cliente($ruta);
        }
        // mysqli_close($conexion);
    }
?>