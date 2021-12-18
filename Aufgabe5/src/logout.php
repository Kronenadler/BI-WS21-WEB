<?php 
require("start.php");
session_unset();
?>



<!DOCTYPE html>
<header>
    <link rel="stylesheet" href="../styles/styles.css">

    <title>Log out</title>
</header>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
<body class="login">
   <div class="logout">
    <img class="login" src="../images/logout.png">
    <h1>Logged out...</h1>
    <h3>See u!</h3>

    <a href="./login.php" id="link">Login again!</a>
</div>
</body>
