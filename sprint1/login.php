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
    if (password_verify($password, $row["password"])) {
        // password is correct, start session and redirect to home page
        $_SESSION["username"] = $username;
        header("Location: index.php");
        die();
    } else {
        // password is incorrect, show error message
        header("Location: login.php");
        die();
    }
} else {
    // user does not exist, show error message
    header("Location: login.php");
    die();
}

?>

</body>
</html>