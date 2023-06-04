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
//Contraseña sin cifrar introducida en el formulario
$password = $_POST["password"];
//Contraseña cifrada de la bbdd
$bbdd_password = $myuser_data["password"];
//Comparamos ambas contraseñas
if (password_verify($password, $bbdd_password)) {
    //Ciframos la nueva contraseña que serà la que introduciremos en la bbdd
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
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
    //Creamos y ejecutamos la query
    $queryUserUpdate = "UPDATE usuario SET username = '$name',imagen = '$image',password = '$hashed_password',description = '$description' WHERE user_id = '$id'";
    $result = mysqli_query($connex, $queryUserUpdate);
    $_SESSION["username"] = $name;
    //Regresamos al perfil
    header("Location: perfil.php?username=$name");
}
else{
    header("Location: perfil.php?username=$myusername");
}

//Close the SQL connection
mysqli_close($connex);
?>