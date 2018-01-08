<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="votar.js"></script>
	<link rel="shortcut icon" href="imagenes/VotaLogo.png" />
	<title>Vota</title>
	<link rel="stylesheet" href="style.css">
</head>
<body id='cuerpo' onload="efecto()">
	<header ><img src="imagenes/VotaBanner.png"></header>
	
		<a href='principalUser.php'><img id='home' src='imagenes/home.png'></a>


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
				<p>hola, ".$nombre."</p>");
		echo("<a href='logout.php'><button type='button'>Logout</button></a>
			</div>");


//RESPUSTA Y SUS DATOS
		if(!isset($_POST["resp"])){
			$pregunta = $_POST["pregunta"];
			$dInicio = $_POST["dInicio"];
			$dFinal = $_POST["dFinal"];
			$idPregunta = $_POST["id"];
			$userId = $_POST["uId"];

			$query = $pdo->prepare("SELECT Respuesta, ID_Respuesta FROM Respuestas WHERE ID_Pregunta =".$idPregunta);
			$query->execute();

			$respuesta = $query->fetch();

			
			echo "<p id='cancell' style='color:red; font-size:20px'></p>";
			echo("<h3>".$pregunta."</h3>");

			echo("<div >
					<h5 class='fechas'>".$dInicio."</h5>");
			echo("	<h5 class='fechas'>".$dFinal."</h5>
				</div>");

			$cont=0;

			echo ("<div id='resp'>");
				echo ("<form action='votar.php' method='post' id='form".$cont."'>");
				while($respuesta){
					$respuesta2 = $respuesta['Respuesta'];
		
						echo ("<div class='formu' id='formu".$cont."'>");

							echo("<input type='radio' name='resp' value=".$respuesta2.">".$respuesta2);
							echo("<input type='text' name='idPregunta' value='".$idPregunta."' readonly hidden/>");

						    $cont++;
							$respuesta = $query->fetch();
						echo ("</div><br>");
				}
					echo("<input type='password' name='pass' required= true/>");
					echo("<input type='submit' value='VOTA' id='votacion' /> </div>");
				echo ("</form>");
			echo ("</div>");

		}else{

			$resp = $_POST["resp"];
			$qstr = "SELECT ID_Respuesta FROM Respuestas WHERE ID_Pregunta =".$_POST["idPregunta"]." AND Respuesta = '".$resp."'";

			$query = $pdo->prepare( $qstr );
			$query->execute();
			
			$respuesta = $query->fetch();



			$query = $pdo->prepare("SELECT ID FROM Usuarios WHERE Email = '".$nombre."'");
			$query->execute();
			$id = $query->fetch();

			$query = $pdo->prepare("SELECT * FROM relacionusuariovota WHERE ID_Usuario = '".$id[0]."' AND ID_Pregunta =".$_POST["idPregunta"]);
			$query->execute();
			$contestada = $query->fetch();

//MODIFICA
			if ($contestada) {
				$query2 = $pdo->prepare("SELECT hash_enc FROM relacionusuariovota WHERE ID_Usuario = '".$id[0]."' AND ID_Pregunta =".$_POST["idPregunta"]);
				$query2->execute();

				$encontrarHash = $query2->fetch();
	//DESENCRYPT
				//$hash_dec = AES_DECRYPT($encontrarHash["hash_enc"], $_POST["pass"]);
				
				//$query = $pdo->prepare("UPDATE Votaciones SET ID_Respuesta = ? WHERE hash = AES_DECRYPT(? , ?)");
				// $query = $pdo->prepare("UPDATE Votaciones SET ID_Respuesta = ".$respuesta["ID_Respuesta"]." WHERE hash ='".$encontrarHash["hash_enc"]."'");
				//$query->execute(array($respuesta["ID_Respuesta"], $encontrarHash["hash_enc"], $_POST["pass"]));
	
	//COMPROVACIÓN PASSWORD			
				$queryPass = $pdo->prepare("SELECT Password FROM Usuarios WHERE Nombre = ".$nombre);
				$queryPass->execute();
				$psswrd = $queryPass->fetch();
				
			$contra_enc = hash("sha256", $_POST["pass"]);
			
			if($psswrd[0] == $contra_enc){
				
				$query = $pdo->prepare("SELECT ID_Respuesta FROM Votaciones = WHERE hash = AES_DECRYPT(? , ?)");
				$query->execute(array($encontrarHash["hash_enc"], $_POST["pass"]));
				$idRespuesta = $query->fetch();
				
				$query2 = $pdo->prepare("UPDATE Votaciones SET ID_Respuesta = ? WHERE hash = AES_DECRYPT(? , ?)");
				$query2->execute(array($idRespuesta["ID_Respuesta"]));
				
			
					echo ("Respuesta modificada con exito!");
				
			}else{
				echo ("Error en la contraseña");	
			}
				


//NUEVA RESPUSTA			
			}else{
				$hash = generaPass();
	//COMPROVACIÓN PASSWORD	
				$queryPass = $pdo->prepare("SELECT Password FROM Usuarios WHERE Nombre = ".$nombre);
				$queryPass->execute();
				$psswrd = $queryPass->fetch();
				
				$contra_enc = hash("sha256", $_POST["pass"]);
			
				if($psswrd[0] == $contra_enc){
	//ENCRYPT
				//$hash_enc = AES_ENCRYPT($hash, $_POST["pass"]);

					$query = $pdo->prepare("INSERT INTO relacionusuariovota(ID_Usuario, ID_Pregunta, hash_enc) 
										VALUES (?, ?, AES_ENCRYPT(?,?) )");
				

					$query->execute(array($id[0], $_POST['idPregunta'], $hash, $_POST['pass']));


					$query2 = $pdo->prepare("INSERT INTO Votaciones(hash, ID_Respuesta) 
										VALUES (?, ?)");

					$query2->execute(array($hash, $respuesta[0]));

					echo ("Respuesta guardada con exito!");
				}else{
					echo ("Error en la contraseña");
				}
			}
		}

function generaPass(){
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
     
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=6;
     
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
     
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}

	?>
	<footer><img id="logo" src="imagenes/VotaLogo.png"></footer>
</body>
</html>
