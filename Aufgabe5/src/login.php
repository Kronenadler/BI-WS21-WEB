<?php 
require("start.php");
if(isset($_SESSION["user"])) {
    header("Location: friends.php");
}

$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

$error = "";
$passwordOk = false;
if (!isset($_SESSION["loginSes"])) {
  $_SESSION["loginSes"] = array();
}

if (!empty($_POST)) {
$username = $_POST['username'];
$password = $_POST['pwd'];

if($service->login($username, $password)) {
  $_SESSION["user"] = $username;
  header("Location: friends.php");
  $_SESSION["error"] = "";
}
else {
  $passwordOk = true;
  $_SESSION["error"] = "Username or password is invalid. Try again.";
  header("Location: login.php");
}}


?>

<!DOCTYPE html>
<header>
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Login</title>
</header>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
</head>

<body class="login">
    <img class="login" src="../images/chat.png">
    <h1>Please sign in</h1>
   

    <form action="./login.php" method="post">
        <fieldset class="login">
            <legend class="login">Login</legend>

            <?php
          
                    if(isset($_SESSION["error"])){
                        $error = $_SESSION["error"];
                        echo "<span style='color:red'>$error</span>";
                        
                    }
                ?>  
            <div class="row">
                <div class="" id="username">
                    <label for="Username">Username</label>
                    <input placeholder="Username" class="input-login" type="text" name="username" value="" size="20"
                        maxlength="50" />                      
                </div>
            </div>
            <div class="" id="password">
                <label for="Password">Password</label>
                <input type="password" class="input-login" placeholder="Password" name="pwd" value="" size="20"
                    maxlength="50">
            </div>

            </div>
        </fieldset>
        <div class="row">
            <div class="col-12">
                


                <button id="button" class="blue" type="submit" value="save">Login</button>

            </div>
        </div>
    </form>
    <a href="./register.php">
                    <button id="button" type="none" class="grey">Register</button>
                </a>




</body>