<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/0d820d26d5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    img {
			max-width: 100%;
			height: auto;
		}
    #profilepic {
        max-width: 20%;
		height: auto;
    }
    </style>
</head>
<body>
<?php 
 session_start();
    include_once "connexio.php";
    $connex = new mysqli($lloc, $usuari, $pwd, $bbdd);

    // pick the username from URL
    if (isset($_SESSION["username"])) {
        $username = $_SESSION['username'];
    // prepare query
    $query = "SELECT * FROM usuario WHERE username = '$username'";
    $result = mysqli_query($connex, $query);
    // check connection
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($connex));
    }
    //in this variable we took all data from the query
    $user_data = mysqli_fetch_assoc($result);
    }
    //Aqui creem la llista de tots els usuaris ordenats per elo, 
    $listar_usuarios = mysqli_query($connex, "SELECT TOP 100 * FROM usuario ORDER BY elo ASC");
    $usuario = mysqli_fetch_assoc($listar_usuarios);

    //Variable para limpiar codigo
    $perfil_usuario = '<a href="perfil.php?username=<?php echo $usuario["username"]?>" style="padding: 0px;padding-right: 10px;"><span class="glyphicon"></span><img style="max-width: 50px;margin-right: 10px;" src="<?php echo $usuario["imagen"]?>"><?php echo $usuario["username"]?></a>';
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
                <li class="active"><a href="#">Ranking</a></li>
            </ul>
            <?php
                if (isset($_SESSION["username"])) {
            ?>
            <ul class="nav navbar-nav navbar-right" style="margin-right: 0px">
                <li><a href="perfil.php?username=<?php echo $_SESSION["username"]?>" style="padding: 0px;padding-right: 10px;"><span class="glyphicon"></span><img style="max-width: 50px;margin-right: 10px;" src="<?php echo $user_data["imagen"]?>"><?php echo $_SESSION["username"]?></a></li>
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
    <div class="row">
        <div id="ranking">
            <table>
                <tr>
                    <th>Position</th>
                    <th>User</th>
                    <th>ELO</th>
                </tr>
                <?php
                $suma =1;
                    while ($usuario = mysqli_fetch_assoc($listar_usuarios)) {
                        echo"<tr><td>".$suma."</td>";
                        echo "<td>". $perfil_usuario."</td>";
                        echo "<td>".$usuario["elo"]."</td></tr>";
                        $suma = $suma +1;
                    }
                ?>
            </table>
        </div>
    </div>
</div>
<?php
//Close the SQL connection
  mysqli_close($connex);
?>
</body>
</html>