<?php session_start(); ?>

<!DOCTYPE html>
<html>
<body>

<?php
include_once "connexio.php";
$connex = new mysqli($lloc, $usuari, $pwd, $bbdd);
// check connection
if ($connex->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// get username and password from form
$username = $_POST["username"];
$password = $_POST["password"];
// prepare statement
$stmt = $connex->prepare("SELECT * FROM usuario WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
// check if user exists
if ($result->num_rows == 1) {
    // user exists, check password
    $row = $result->fetch_assoc();
    //Obtenemos la contraseña cifrada almacenada en la base de datos
    $bbdd_password = $row["password"];
    $userId=$row["user_id"];
    //Comparamos la contraseña introducida con la cifrada de la bbdd
    if (password_verify($password, $bbdd_password)) {
        // password is correct, start session and redirect to home page

        setcookie($username,$userId,time()+10800);

        session_set_cookie_params([
            'path' => '/El69Man/Chess-Online/sprint1/', // Path to the root of your application
            'domain' => 'localhost',
            'secure' => false, // Set to true if using HTTPS
            'httponly' => true
        ]);

        
        $_SESSION["username"] = $username;
        $_SESSION["userId"] = $userId;
       header("Location: index.php");
    } else {
        // password is incorrect, show error message
       header("Location: login.html");
    }
} else {
    // user does not exist, show error message
  header("Location: login.html");
}
?>
</body>
</html>