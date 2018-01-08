<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="imagenes/VotaLogo.png" />
	<title>Principal</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header><img src="imagenes/VotaBanner.png"></header>
	
	<a href='principalUser.php'><img id='home' src='imagenes/home.png'></a>

	<?php


include("/var/www/html/ProjecteVota/config.php");
  

//INCLUIR EN TODOS LOS DOCUMENTOS
		session_start();
		$nombre = $_SESSION["user"];

		$idQuery = $pdo->prepare("SELECT ID FROM Usuarios WHERE Email = '".$nombre."'");
		$idQuery->execute();
		$id = $idQuery->fetch();

		
		echo("<div id='login'>
				hola, ".$nombre."<br>");
		echo("<a href='logout.php'><button type='button'>Logout</button></a>
			</div>");

//PREGUNTAS PENDIENTES
		$queryPendientes = $pdo->prepare("SELECT * FROM Invitacion join Pregunta on (Pregunta.ID = Invitacion.ID_Pregunta) WHERE Invitacion.email ='".$nombre."' AND ID_Pregunta NOT IN  (SELECT ID_Pregunta FROM relacionusuariovota join Pregunta on (Pregunta.ID = relacionusuariovota.ID_Pregunta) WHERE relacionusuariovota.ID_Usuario =".$id['ID'].")");
		$queryPendientes->execute();

		$preguntasPendientes = $queryPendientes->fetch();


//PREGUNTAS REALIZADAS
		//$query = $pdo->prepare("SELECT * FROM Pregunta");
		$queryRealizadas = $pdo->prepare("SELECT * FROM relacionusuariovota join Pregunta on (Pregunta.ID = relacionusuariovota.ID_Pregunta) WHERE relacionusuariovota.ID_Usuario =".$id['ID']);
		$queryRealizadas->execute();

		$preguntasRealizadas = $queryRealizadas->fetch();


//PREGUNTAS PENDIENTES
		echo ("<table id='preguntasPendientes' class='preguntas'>");

		echo ("<tr>");
		echo ("<th><h3>Preguntas Pendientes</h3></th>");
		echo ("</tr>");

			echo ("<tr>");
            	echo ("<th>PREGUNTA</th>");
            	echo ("<th>FECHA INICIO</th>");
            	echo ("<th>FECHA FINAL</th>");
            	echo ("<th>VOTA</th>");
            echo ("</tr>");

		while($preguntasPendientes){

				echo ("<form action='votar.php' method='post'>");
				echo ("<tr >");
					echo ("<td><input type='text' name='pregunta' value='".$preguntasPendientes['Pregunta']."' readonly></td>");
			    	echo ("<td><input type='text' name='dInicio' value='".$preguntasPendientes['DataInici']."' readonly></td>");
			    	echo ("<td><input type='text' name='dFinal' value='".$preguntasPendientes['DataFinal']."' readonly></td>");

			        echo ("<td><input value='VOTA' type='submit' id='VOTA' /></td>");

			        echo ("<td><input type='text' name='id' value='".$preguntasPendientes['ID']."' readonly hidden></td>");
			    	echo ("<td><input type='text' name='uId' value='".$preguntasPendientes['ID_Usuario']."' readonly hidden></td>");

			    echo ("</tr>");
			    echo ("</form>");

            $preguntasPendientes = $queryPendientes->fetch();
           }			
       echo ("</table>"); 



//PREGUNTAS REALIZADAS
		echo ("<table id='preguntasRealizadas' class='preguntas'>");

		echo ("<tr>");
		echo ("<th><h3>Preguntas Realizadas</h3></th>");
		echo ("</tr>");

			echo ("<tr>");
            	echo ("<th>PREGUNTA</th>");
            	echo ("<th>FECHA INICIO</th>");
            	echo ("<th>FECHA FINAL</th>");
            	echo ("<th>VOTA</th>");
            echo ("</tr>");

		while($preguntasRealizadas){

				echo ("<form action='votar.php' method='post'>");
				echo ("<tr >");
					echo ("<td><input type='text' name='pregunta' value='".$preguntasRealizadas['Pregunta']."' readonly></td>");
			    	echo ("<td><input type='text' name='dInicio' value='".$preguntasRealizadas['DataInici']."' readonly></td>");
			    	echo ("<td><input type='text' name='dFinal' value='".$preguntasRealizadas['DataFinal']."' readonly></td>");

			        echo ("<td><input value='VOTA' type='submit' id='VOTA' /></td>");

			        echo ("<td><input type='text' name='id' value='".$preguntasRealizadas['ID']."' readonly hidden></td>");
			    	echo ("<td><input type='text' name='uId' value='".$preguntasRealizadas['ID_Usuario']."' readonly hidden></td>");

			    echo ("</tr>");
			    echo ("</form>");

            $preguntasRealizadas = $queryRealizadas->fetch();
           }			
       echo ("</table>"); 

	?>
	<footer><img id="logo" src="imagenes/VotaLogo.png"></footer>
</body>
</html>
