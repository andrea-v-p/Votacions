<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="imagenes/VotaLogo.png" />
	<title>login</title>
	<link rel="stylesheet" href="style.css">
	<script src="votaciones.js"></script> 
</head>
<body>
	<header><img src="imagenes/VotaBanner.png"></header>
	<div id="loginForm">
	<?php
		
		session_start();                                                


//include("/var/www/html/ProjecteVota/config.php");
  
  $hostname = "localhost";
  $dbname = "ProjecteVota";
  $username = "root";
  $pass = "";
    
  $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pass");

		//FORMULARIO SI EL POST ESTA VACIO
	if(!isset($_POST["email"])){	
		
		formulario();
	

	 	//SI EL FORMULARIO ESTA RELLENO HACE UNA QUERY PARA RECOGER EL ID COMPROBANDO EL EMAIL
	}else{
		$query = $pdo->prepare("SELECT ID FROM Usuarios WHERE Email = '".$_POST["email"]."'");
		$query->execute();
		$id = $query->fetch();

			//SI LA QUERY ANTERIOR NO FALLA CREA OTRA QUERY QUE RECOGE EL PASSWORD COMBROBANDO EL ID
		if($id){
			$query = $pdo->prepare("SELECT Password FROM Usuarios WHERE ID = ".$id[0]);
			$query->execute();

			$psswrd = $query->fetch();

			//COMPRUEBA EL PASSWORD INTRODUCIDO CONTRA EL PASSWORD DE LA QUERY
			$contra_enc = hash("sha256", $_POST["password"]);
			
			if($psswrd[0] == $contra_enc){
				try {
					$query = $pdo->prepare("SELECT Email FROM Usuarios WHERE ID = ".$id[0]);
					$query->execute();

					$intermedia = $query->fetch();

					$_SESSION["user"] = $intermedia[0];
		//IF ADMIN
					$query = $pdo->prepare("SELECT Admin FROM Usuarios WHERE Email = '".$_POST["email"]."'");
					$query->execute();
					$admin = $query->fetch();


					if ($admin["Admin"]==1) {
						header('Location: principalAdmin.php');
					}else{
						header('Location: principalUser.php');
					}
		
				} catch (PDOException $e) {
   					echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    				exit;
  				}
			
			//SI FALLA EL PASSWORD RECARGA EL FORMULARIO
			}else{
				 echo(' <p style="color:red; font-size:20px">Password erroneo!</p>
				 	<br>');
				
				 formulario();
				
			}

			//SI FALLA EL EMAIL RECARGA EL FORMULARIO
		} else {
			echo(' <p style="color:red; font-size:20px">Email no encontrado!</p>
			 	<br>');
			formulario();

		}
		
	}

	//FUNCION DE GENERACION DE FORMULARIOS
	function formulario(){
		echo('<form action="inicioLogin.php" method="post" id="inicio" class="formularioInicio">
				<h4>Inicia sessión</h4>
				<p>Email: <input type="text" name="email" required="true"></p>
			    <p>Password: <input type="password" name="password" required="true"></p>

			    <input value="Login" type="submit" id="inicio" />
			</form>');

		echo('<form action="creaCuenta.php" method="post" id="nuevaCuentaForm" class="formularioInicio">
				<h4>Registrate</h4>
				<p>Nombre: <input type="text" name="nombre" required="true"></p>
				<p>Email: <input type="text" name="email" required="true"></p>
			    <p>Introduce password: <input type="password" name="password1" required="true"></p>
			    <p>Confirma password: <input type="password" name="password2" required="true"></p>

			    <input value="registrate" type="submit" id="nuevaCuenta" />
			</form>');
	}

	?>
     </div>
     <footer><img id="logo" src="imagenes/VotaLogo.png"></footer>
</body>
</html>
