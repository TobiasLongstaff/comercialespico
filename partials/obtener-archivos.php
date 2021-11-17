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
                $tipo_usuario = $_SESSION['tipo_usuario'];
                $gestor = opendir($ruta);
                $json = array();
                while(($archivo = readdir($gestor)) !== false)  
                {
                    if($archivo != "." && $archivo != "..") 
                    {
                        $archivo_class = str_replace('.', '-', $archivo);
                        $archivo_class = str_replace('!', '-', $archivo_class);
                        $fecha = date ("Y-m-d", filectime($ruta.$archivo));

                        if (strpos($archivo, '!') == false) 
                        {
                            $tipo_ico = false;
                        }
                        else
                        {
                            $tipo_ico = true;
                        }

                        $json[] = array(
                            'fecha' => $fecha,
                            'nombre' => $archivo,
                            'nombre_class' => $archivo_class,
                            'tipo_usuario' => $tipo_usuario,
                            'ubicacion' => $ubicacion,
                            'ico' => $tipo_ico
                        );
                    }
                }
                closedir($gestor);
            } 
            $jsonstring = json_encode($json);
            echo $jsonstring;
        }
    
        obtener_estructura_directorios($ruta, $ubicacion);
    }
?>