<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="chessboardJS/css/chessboard-1.0.0.css">
    <script src="https://kit.fontawesome.com/0d820d26d5.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="chessboardJS/js/chessboard-1.0.0.js"></script>
    <script src="index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
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
?>
    <div id="container">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <div class="navbar-header">
                <i class="fas fa-chess-pawn" style='font-size:40px;color:white'></i>
                <a class="navbar-brand" href="#">Chess.cum</a>
              </div>
              <ul class="nav navbar-nav" style="margin-left:15px">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="ranking.php">Ranking</a></li>
              </ul>
              <?php
                if (isset($_SESSION["username"])) {
                ?>
                    <ul class="nav navbar-nav navbar-right">
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
          <div class="rightButtons">
            <button id="searchGame" class="playBtn">Jugar</button>
            <div class="playLog">1.e4 e5</div>
          </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2">
                <div id="board1"></div>
            </div>
          </div>
          <div class="row">
            <button id="backBtn" class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 chessBtn">⏪</button>
            <button id="startBtn" class="chessBtn">🔄</button>
            <button id="forwardBtn" class="chessBtn">⏩</button>
            <!--<button id="actualBtn" class="chessBtn">Actual</button>-->
          </div>
        </div>
    </div>
    
<?php
//Close the SQL connection
  mysqli_close($connex);
?>
</body>
</html>
