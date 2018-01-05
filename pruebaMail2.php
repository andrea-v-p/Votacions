<?php		
			
			$para      = 'adrytaisho@gmail.com';
			$titulo    = 'El título';
			$mensaje   = 'Hola';
			$cabeceras = 'From: adrytaisho@gmail.com' . "\r\n" .
				'Reply-To: webmaster@example.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			mail ($para, $titulo, $mensaje, $cabeceras);
			echo "correo enviado";

?>

