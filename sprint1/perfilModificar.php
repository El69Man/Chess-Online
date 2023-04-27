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
$description = $_POST["description"];
//Si no hay foto nos quedamos con la de la bbdd, si hay foto se cambia el valor

if(isset($_FILES["image"])&& $_FILES['image']['type'] == 'image/jpeg'){
    //Aqui tenemos que subir a la carpeta /profilepic la foto para que funcione
    $imageName = $_FILES["image"]["name"];
    $imageTemp=$_FILES["image"]["tmp_name"];
    $new_file_name = rand(1000000,100000000)."_".time().".jpg";
    $image = "profilepic/".$new_file_name;
    move_uploaded_file($imageTemp, $image);
    
}
else{
    $image = $myuser_data["imagen"];
}
//Cogemos el nombre de usuario y validamos que exista
if(!isset($_POST["name"])){
    $name = $_SESSION["username"];
}
else{
    $name = $_POST["name"];
}
//Si la contraseña no esta vacia y equivale a la existente(bien)
if(isset($_POST["password"]) && $_POST["password"] == $myuser_data["password"]){
    $password = $myuser_data["password"];
}
//Si la contraseña no esta vacia y no equivale a la existente(bien)
if(isset($_POST["password"]) && $_POST["password"] != $myuser_data["password"]){
    $password = $myuser_data["password"];
    header("Location: perfil.php?username=$myusername");
    exit();
}
//Si la contraseña esta vacia(mal)
if(!isset($_POST["password"])){
    $password = $myuser_data["password"];
    header("Location: perfil.php?username=$myusername");
    exit();
}



//Creamos y ejecutamos la query
$queryUserUpdate = "UPDATE usuario SET username = '$name',imagen = '$image',password = '$password',description = '$description' WHERE user_id = '$id'";
$result = mysqli_query($connex, $queryUserUpdate);
$_SESSION["username"] = $name;
//Regresamos al perfil
header("Location: perfil.php?username=$name");


//Close the SQL connection
mysqli_close($connex);
?>