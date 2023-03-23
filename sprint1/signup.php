<!DOCTYPE html>
<html>
<body>

<?php
include_once "connexio.php";
$connex = new mysqli($lloc, $usuari, $pwd, $bbdd);

// check connection
if ($connex->connect_error) {
    die("Connection failed: " . $connex->connect_error);
}

// get username and password from form
$username = $_POST["username"];
$password = $_POST["password"];
$description = $_POST["description"];
if(empty($_POST["username"])){
  header("Location: signup.html");
}

//Crear la consulta SQL
$sql = "INSERT INTO usuario (username, password, description) VALUES ('$username', '$password','$description')";
// Insertar los datos en la base de datos
if ($connex->query($sql) === TRUE) {
    
    session_start();
    $_SESSION["username"] = $username;
    header("Location: index.php");
  } 
  else {



    header("Location: signup.html");
  }
  
  // Cerrar la conexión a la base de datos
  mysqli_close($connex);
  ?>
