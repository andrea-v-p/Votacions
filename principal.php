<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		$nombre = $_POST["nick"];
		$password = $_POST["password"];

		echo ("Hola ".$nombre.", su contraseña es: ".$password);

	?>
</body>
</html>