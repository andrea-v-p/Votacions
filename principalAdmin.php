<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="imagenes/VotaLogo.png" />
	<title>Principal</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header><img src="imagenes/VotaBanner.png"></header>
	
	<a href='principalAdmin.php'><img id='home' src='imagenes/home.png'></a>

	<?php


//include("/var/www/html/ProjecteVota/config.php");
  
  $hostname = "localhost";
  $dbname = "ProjecteVota";
  $username = "root";
  $pass = "";
    
  $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pass");
  

//INCLUIR EN TODOS LOS DOCUMENTOS
		session_start();
		$nombre = $_SESSION["user"];
		
		echo("<div id='login'>
				hola, ".$nombre."<br>");
		echo("<a href='logout.php'><button type='button'>Logout</button></a>
			</div>");

		echo("<a href='crearConsulta.php'><button type='button'>Crear Consulta</button></a>");


		$query = $pdo->prepare("SELECT * FROM Pregunta");
		$query->execute();

		$pregunta = $query->fetch();
		echo ("<table id='preguntas' class='preguntas'>");
			echo ("<tr>");
            	echo ("<th>PREGUNTA</th>");
            	echo ("<th>FECHA INICIO</th>");
            	echo ("<th>FECHA FINAL</th>");
            	echo ("<th>INVITA</th>");
            echo ("</tr>");

		while($pregunta){

				echo ("<form action='invita.php' method='post'>");
				echo ("<tr >");
					echo ("<td><input type='text' name='pregunta' value='".$pregunta['Pregunta']."' readonly></td>");
			    	echo ("<td><input type='text' name='dInicio' value='".$pregunta['DataInici']."' readonly></td>");
			    	echo ("<td><input type='text' name='dFinal' value='".$pregunta['DataFinal']."' readonly></td>");

			        echo ("<td><input value='INVITA' type='submit' id='invita' /></td>");

			        echo ("<td><input type='text' name='id' value='".$pregunta['ID']."' readonly hidden></td>");

			    echo ("</tr>");
			    echo ("</form>");

            $pregunta = $query->fetch();
           }			
       echo ("</table>"); 

	?>
	<footer><img id="logo" src="imagenes/VotaLogo.png"></footer>
</body>
</html>
