<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/0d820d26d5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
<?php 
session_start();
    include_once "connexio.php";
    $connex = new mysqli($lloc, $usuari, $pwd, $bbdd);
    
    // pick the username from URL
    $usernick = $_GET['username'];
    //pick the info of my session(bugs ocurred without that)
    if(isset($_SESSION["username"])){
        $myuser = $_SESSION['username'];
        $myquery = "SELECT * FROM usuario WHERE username = '$myuser'";
        $myresult = mysqli_query($connex, $myquery);
    
        if (!$myresult) {
            die("Error en la consulta: " . mysqli_error($connex));
        }
        $myuser_data = mysqli_fetch_assoc($myresult);
    }
    // prepare query
    $query = "SELECT * FROM usuario WHERE username = '$usernick'";

    $result = mysqli_query($connex, $query);
    // check connection
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($connex));
    }
    //in this variable we took all data from the query
    $user_data = mysqli_fetch_assoc($result);
?>
 <div id="container">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <i class="fas fa-chess-pawn" style='font-size:40px;color:white'></i>
                <a class="navbar-brand" href="index.php">Chess.cum</a>
            </div>
            <ul class="nav navbar-nav" style="margin-left:15px">
                <li><a href="index.php">Home</a></li>
                <li><a href="ranking.php">Ranking</a></li>
            </ul>
            <?php
                if (isset($_SESSION["username"])) {
            ?>
            <ul class="nav navbar-nav navbar-right" style="margin-right: 0px">
                <li><a href="perfil.php?username=<?php echo $_SESSION["username"]?>" style="padding: 0px;padding-right: 10px;"><span class="glyphicon"></span><img src="<?php echo $myuser_data["imagen"]?>"><?php echo $_SESSION["username"]?></a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
            </ul>
            <?php
            } 
            else {
            ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="signup.html"><span class="glyphicon glyphicon-user"></span>Sign Up</a></li>
                    <li><a href="login.html"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
                </ul>
            <?php
                }
            ?>
        </div>
    </nav>
    <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xs-6 col-xs-offset-3">
        <div class="row">
            <img id="profilepic" class="col-sm-4 col-md-4 col-lg-4 col-xs-4" src="<?php echo $user_data["imagen"]?>"> 
            <h1 id="username" class="col-sm-8 col-md-8 col-lg-8 col-xs-8"><?php echo $user_data["username"]?></h1>  
            <div class="row">
                <h2 id="elo" class="col-sm-6 col-md-6 col-lg-6 col-xs-6">ELO: <?php echo $user_data["elo"]?></h1>  
            </div>
        </div>
        <?php
        //Si el perfil revisat és el propi, afegim el formulari de modificació
        if (isset($_SESSION["username"])){
            if($_SESSION["username"] == $user_data["username"]){
            ?>
            <form method="post" action="perfilModificar.php" enctype="multipart/form-data">
                <label for="image">Cambiar foto de perfil:<p>
                <input type="file" name="image" id="image">
                <p>
                <label for="name">Cambiar nombre de usuario:
                <input type="text" name="name" value="<?php echo $myuser_data["username"]?>">
                <p>
                <label for="password">Cambiar contraseña:
                <input type="password" name="password" value="<?php echo $myuser_data["password"]?>">
                <p>
                <label for="id">
                <input type="hidden" name="id" value="<?php echo $myuser_data["user_id"]?>">
                <label for="submit">
                <input type="submit" value="Guardar cambios">
            </form>
            <?php
            }    
        }
        ?>
    </div>
</div>





<?php

//Close the SQL connection
  mysqli_close($connex);
?>
</body>
</html>
