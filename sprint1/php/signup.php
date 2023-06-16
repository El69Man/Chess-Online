<?php session_start(); ?>

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
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$description = $_POST["description"];
if(empty($_POST["username"])){
  header("Location: signup.html");
}
//Crear la consulta SQL
$sql = "INSERT INTO usuario (username, password, description) VALUES ('$username', '$hashed_password','$description')";
$userId = "SELECT user_id FROM usuario WHERE username = '$username'"; 
// Insertar los datos en la base de datos
if ($connex->query($sql) === TRUE) {

    setcookie($username,$userId,time()+3600);

    session_set_cookie_params([
            //'lifetime' => 3600, // Cookie lifetime in seconds
            'path' => '/El69Man/Chess-Online/sprint1/', // Path to the root of your application
            'domain' => 'localhost',
            'secure' => false, // Set to true if using HTTPS
            'httponly' => true
        ]);

    
    $_SESSION["username"] = $username;
    $_SESSION["userId"] = $connex->query($userId);
    header("Location: index.php");
  } 
  else {
    header("Location: signup.html");
  }
  
  // Cerrar la conexión a la base de datos
  mysqli_close($connex);
  ?>
