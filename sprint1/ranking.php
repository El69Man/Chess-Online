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
    $query2 = "SELECT * FROM usuario ORDER BY elo DESC LIMIT 50";
    $listar_usuarios = mysqli_query($connex, $query2);
   
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
                <li><a href="perfil.php?username=<?php echo $_SESSION["username"]?>" style="padding: 0px;padding-right: 10px;"><span class="glyphicon"></span><img src="<?php echo $user_data["imagen"]?>"><?php echo $_SESSION["username"]?></a></li>
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
        <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xs-6 col-xs-offset-3">
            <h1 style="text-align: center"><strong>TOP 50 PLAYERS</strong></h1>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Position</th>
                        <th>User</th>
                        <th>ELO</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $suma =1;
                
                if ($listar_usuarios) {
                    while($row = mysqli_fetch_array($listar_usuarios, MYSQLI_ASSOC)){
                        echo "<tr id='" . $suma . "'><td>" . $suma . "</td>";
                        echo "<td><a href='perfil.php?username=" . $row['username'] . "'><span class='glyphicon'></span><img src='". $row['imagen'] ."'>" . $row['username'] ."</a></td>";
                        echo "<td>". $row["elo"] ."</td></tr>";
                        if (isset($_SESSION['username'])){
                            if ($row['username'] == $_SESSION['username']){?>
                                <script>
                                    window.onload = function(){
                                        var myUser = document.getElementById(<?php echo $suma ?>);
                                        myUser.style.background = "linear-gradient(90deg, rgba(0,212,255,1) 1%, rgba(73,73,212,1) 55%, rgba(0,212,255,1) 100%)";      
                                        var myUserColor = myUser.childNodes[1].children[0];
                                        myUserColor.style.color ="white";
                                    };
                                </script>
                            <?php }
                        }
                        $suma = $suma +1;
                    }

                }
                else {
                    echo "Error: " . mysqli_error($connex);
                }
                ?>
                </tbody>
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