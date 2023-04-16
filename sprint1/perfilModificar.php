<?php
session_start();
include_once "connexio.php";
$connex = new mysqli($lloc, $usuari, $pwd, $bbdd);

// check connection
if ($connex->connect_error) {
    die("Connection failed: " . $connex->connect_error);
}

//Cogemos todos los datos del usuario 
$myusername = $_SESSION["username"];
$myquery = "SELECT * FROM usuario WHERE username = '$myusername'";
$myresult = mysqli_query($connex, $myquery);
$myuser_data = mysqli_fetch_assoc($myresult);
//Cogemos los datos del formulario y le hacemos un control rapido

//Este ID es de campo oculto y nos sirve para no joder la base de datos:l y actualizar solo el usuario que toca
$id = $_POST["id"];
//Si no hay foto nos quedamos con la de la bbdd, si hay foto se cambia el valor
if(!isset($_POST["image"])){
    $image = $myuser_data["imagen"];
}
else{
    //TODO Aqui tenemos que subir a la carpeta /img la foto para que funcione
    $image = $_POST["image"];
}
//Cogemos el nombre de usuario y validamos que exista
if(!isset($_POST["image"])){
    $name = $myuser_data["username"];
}

$name = $_POST["name"];
//Si la contraseña no esta vacia y equivale a la existente(bien)
if(isset($_POST["password"])&&$_POST["password"] == $myuser_data["password"]){
    $password = $myuser_data["password"];
}
//Si la contraseña esta vacia(mal)
if(!isset($_POST["password"])){
    header("Location: perfil.php?username=$myusername");
}
//Si existe checkeo de contraseña y coinciden(bien)
if(isset($_POST["passwordCheck"])&&$_POST["passwordCheck"]== $_POST["password"]){
    $password =$_POST["password"];
}
//Si existe checkeo de contraseña y no coinciden(mal)
if(isset($_POST["passwordCheck"])&&$_POST["passwordCheck"]== $_POST["password"]){
    header("Location: perfil.php?username=$myusername");
}


//Creamos y ejecutamos la query
$queryUserUpdate = "UPDATE usuario SET username = '$name',imagen = '$image',password = '$password' WHERE user_id = '$id'";
$result = mysqli_query($connex, $queryUserUpdate);

if(!isset($_POST["image"])){
    $_SESSION["username"] = $name;
}
else{
    $name = $_SESSION["username"];
}
//Regresamos al perfil
header("Location: perfil.php?username=$name");

//Close the SQL connection
mysqli_close($connex);
?>