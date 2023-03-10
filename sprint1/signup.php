<!DOCTYPE html>
<html>
<body>

<?php
include_once "connexio.php";
$connex = mysqli_connect($lloc, $usuari, $pwd, $bbdd);
if($connex){

$consulta = "SELECT username, password from usuario";    
$name = $_REQUEST['user'];
$password = $_REQUEST["pwd"];

if($resultat = mysqli_query($connex, $consulta)){
    while($fila = mysqli_fetch_assoc($resultat)){
        if($resultat = $name){
            echo "existo";
        }
        else{
            echo "no existo";
        }
    }
}







}

?>

</body>
</html>