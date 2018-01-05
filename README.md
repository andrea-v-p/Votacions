# ProjecteVota
(PARA EL SCRUMMASTER: LOS DAILYS MEATINGS Y LAS RETROSPECTIVAS SE ENCUENTRA EN EL APARTADO WIKI DE ESTE PROJECTO,
PUEDES ACCEDER A TRAVÉS DE https://github.com/SonHak/ProjecteVota/wiki)



Para que funcione hace falta un archivo de configuracion, "config.php" con el siguente contenido:

"<?php"

	$hostname = "localhost";
	$dbname = "projecteVota";
	$username = "root";
	$pass = "";

	$pdo = new PDO ("mysql:host=$hostname; dbname=$dbname", "$username", "$pass");
"?>"

