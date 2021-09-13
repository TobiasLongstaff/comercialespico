<?php
    session_start();

    $ruta = '../carpetas-clientes/';

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
                    <div filaId='.$archivo.'>
                        <button class="btn-carpeta">
                            <i class="upload-file fas fa-folder"></i><br>
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
        
    obtener_estructura_directorios($ruta);        

    // mysqli_close($conexion);
?>