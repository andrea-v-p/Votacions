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


	


//SI NO SE HAN RELLENADO LOS EMAILS
		if(!isset($_POST["emails"])){
			$pregunta = $_POST["pregunta"];
			$dInicio = $_POST["dInicio"];
			$dFinal = $_POST["dFinal"];
			$idPregunta = $_POST["id"];
			
			echo("<h3>".$pregunta."</h3>");

				echo("<div >
						<h5 class='fechas'>".$dInicio."</h5>");
				echo("	<h5 class='fechas'>".$dFinal."</h5>
					</div>");

				echo "<br>";

				echo ("<form action='invita.php' method='post'>");

						echo ("<textarea type='textArea' name='emails' cols='50' rows='15'> </textArea>");
						echo "<br>";
				        echo ("<input value='INVITA' type='submit' id='invita' />");
						echo ("<textarea type='textArea' name='pregunta2' cols='50' rows='15' value='".$pregunta."' hidden> </textArea>");
				    echo ("</form>");

		}else{
			
			$Emails = $_POST['emails'];
			$arrayEmails = explode(";",$Emails);

			foreach($arrayEmails as $email){
				$titulo    = 'Has sido invitado';
				$mensaje   = 'Ha sido usted invitado para votar a una pregunta. Haga click en el siguiente enlace ' . "\n" . 'adricardenaslara.tk';
				$cabeceras = 'From: adrytaisho@gmail.com' . "\r\n" .
					'Reply-To: adrytaisho@gmail.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				mail ($email, $titulo, $mensaje, $cabeceras);
				
			}
			 echo "<p>correo enviado</p>";
			
		}

	?>
	<footer><img id="logo" src="imagenes/VotaLogo.png"></footer>
</body>
</html>
