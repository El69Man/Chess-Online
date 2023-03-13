<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/0d820d26d5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="container">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <div class="navbar-header">
                <i class="fas fa-chess-pawn" style='font-size:40px;color:white'></i>
                <a class="navbar-brand" href="#">Chess.cum</a>
              </div>
              <ul class="nav navbar-nav" style="margin-left:15px">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Page 1</a></li>
              </ul>
              <?php
                session_start();
                if (isset($_SESSION["username"])) {
                ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li>Hola <?php $_SESSION["username"]?></li>
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
    </div>
</body>
</html>
