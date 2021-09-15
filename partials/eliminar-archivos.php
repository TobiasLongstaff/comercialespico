<?php

	if(isset($_POST['ubicacion']))
	{
		$ubicacion = $_POST['ubicacion'];
		$file = '../carpetas-clientes/'.$ubicacion;
		if (is_file($file)) 
		{
			chmod($file, 0777);

			if(!unlink($file)) 
			{
				echo 'error1';
			}
			echo '1';
		} 
		else 
		{
			echo 'error2';
		}		
	}

?>