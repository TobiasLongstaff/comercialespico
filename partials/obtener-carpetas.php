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
                $tipo_usuario = $_SESSION['tipo_usuario'];
                $gestor = opendir($ruta);
                while(($archivo = readdir($gestor)) !== false)  
                {
                    if($archivo != "." && $archivo != "..") 
                    {
                        $fecha = date ("Y-m-d", filectime($ruta.'/'.$archivo));

                        $json[] = array(
                            'fecha' => $fecha,
                            'nombre' => $archivo,
                            'tipo_usuario' => $tipo_usuario,
                        );
                    }
                }

                $jsonstring = json_encode($json);
                echo $jsonstring;
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