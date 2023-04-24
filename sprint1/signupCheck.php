<?php
include_once "connexio.php";
$connex = new mysqli($lloc, $usuari, $pwd, $bbdd);
// check connection
if ($connex->connect_error) {
    die("Connection failed: " . $connex->connect_error);
}
$username = $_POST["username"];

if (!empty($username)) {
    $stmt = $connex->prepare("SELECT username FROM usuario WHERE username=?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;

    if ($num_rows > 0) {
        echo "existe";
    } else {
        echo "noexiste";
    }
    $stmt->close();
} else {
    echo "noexiste";
}


?>