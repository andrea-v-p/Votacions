<html>
  <head>
    <link rel="shortcut icon" href="imagenes/VotaLogo.png" />
    <title>Nueva Cuenta</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header><img src="imagenes/VotaBanner.png"></header>
    

<?php

//include("/var/www/html/ProjecteVota/config.php");
  
  $hostname = "localhost";
  $dbname = "ProjecteVota";
  $username = "root";
  $pass = "";
    
  $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pass");


$nombre = $_POST["nombre"];
$email = $_POST["email"];
$contra1 = $_POST["password1"];
$contra2 = $_POST["password2"];

$query = $pdo->prepare("SELECT Email FROM Usuarios WHERE Email = '".$email."'");
$query->execute();
$registrado = $query->fetch();

//SI NO ESTA REGISTRADO
if(!$registrado){

//SI LOS 2 PASSWORD SON IGUALES
  if($contra1 == $contra2){
  $contra_enc = hash("sha256", $contra1);
  

 try{  
    $query = $pdo->prepare("INSERT INTO Usuarios(Nombre, Email, Password) 
                VALUES (?, ?, ?)");
    $query->execute(array($nombre, $email, $contra_enc));

    
    echo("<a href='inicioLogin.php'><button type='button'>Volver</button></a>");
    
  } catch (PDOException $e) {
   					echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    				exit;
  }
  
  }else{
   echo(' <p style="color:red; font-size:20px">Las contraseñas no coinciden</p>');
    echo("<a href='inicioLogin.php'><button type='button'>Volver</button></a>");
  }
//SI ESTA REGISTRADO
}else{
   echo(' <p style="color:red; font-size:20px">Ya estas registrado</p>');
   echo("<a href='inicioLogin.php'><button type='button'>Volver</button></a>");
}
?>
  <footer><img id="logo" src="imagenes/VotaLogo.png"></footer>
  </body>
</html>