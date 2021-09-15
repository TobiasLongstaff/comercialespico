<?php

    if(isset($_POST['ubicacion']))
    {
        $ubicacion = $_POST['ubicacion'];
        $carpeta = '../carpetas-clientes/'.$ubicacion.'/';

        if (!is_dir($carpeta))
        {
            mkdir($carpeta);
        }

        rmdir($carpeta);        
    }
?>