<?php
		

include("/var/www/html/ProjecteVota/config.php");
 


	//INCLUIR EN TODOS LOS DOCUMENTOS
	session_start();
	$nombre = $_SESSION["user"];
		
	echo("<div id='login'>
			hola, ".$nombre."<br>");
	echo("<a href='logout.php'><button type='button'>Logout</button></a>
		</div>");
		
	$nombre = $_SESSION["user"];
	$query = $pdo->prepare("SELECT ID FROM Usuarios WHERE Email = '".$nombre."'");
	$query->execute();
	$id = $query->fetch();

	$dInicio = $_POST['fechaInicio'];
	$dFinal = $_POST['fechaFinal'];
	$hInicio = $_POST['horaInicio'];
	$hFinal = $_POST['horaFinal'];
	$pregunta = $_POST['pregunta'];
	

	
	
	$query = $pdo->prepare("INSERT INTO Pregunta(Pregunta,ID_Usuario,DataInici,DataFinal,HoraInicio,HoraFinal) 
							VALUES (?, ?, ?, ?, ?, ?)");
	$query->execute(array($pregunta,$id[0],$dInicio,$dFinal,$hInicio,$hFinal));
	
	
	$query = $pdo->prepare("SELECT MAX(ID) FROM Pregunta WHERE ID_Usuario = ".$id[0]);
	$query->execute();
	$idPregunta = $query->fetch();
	echo $idPregunta[0];
	
	$query = $pdo->prepare("INSERT INTO Respuestas(ID_Pregunta,Respuesta) 
						VALUES (?, ?)");
							
	$arrayRespuestas = array($_POST['respuesta']);
	
	$maxSize = sizeOf($arrayRespuestas[0]);
	
	for($i=0;$i <= $maxSize;$i++){
		$query->execute(array($idPregunta[0],$arrayRespuestas[0][$i]));

	}
	
	
	header('Location: principalAdmin.php');
	
?>
