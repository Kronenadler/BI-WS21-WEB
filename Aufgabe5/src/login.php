<?php 
require("start.php");


if (!isset($_SESSION["loginData"])) {
  $_SESSION["loginData"] = array();
}
  $username = $_POST["username"];
  $password = $_POST["pwd"];
  if (empty($username) ||empty($password)) {
     $error = "Somethign went wront";
  } 
  else {
     $error = "everythigns fine";
  }


if(login($username,$password)) {
  $_SESSION["user"] = $this->username;
  header("Location: friends.php");
}
else {
  $error = "Fehler in der Registrierung.";
}
?>




