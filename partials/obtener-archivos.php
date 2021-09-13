<?php
    session_start();
    require 'conexion.php';

    $ubicacion = '';

    if(isset($_POST['ubicacion']))
    {
        $ubicacion = $_POST['ubicacion'];
    }
    else
    {
        if(!empty($_SESSION['id_usuario']))
        {
            $id_usuario = $_SESSION['id_usuario'];
            $sql="SELECT * FROM carpetas_asociadas WHERE id_cliente = '$id_usuario'";
            $resultado=mysqli_query($conexion,$sql);
            if($filas = mysqli_fetch_array($resultado))
            {
                $ubicacion = $filas['nombre_carpeta'];
            }
        } 
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
                    <div class="container-ico-archivos" filaId=https://drivecomercial.com/'.$ubicacion.'/'.$archivo.'>
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

    obtener_estructura_directorios($ruta, $ubicacion);
?>