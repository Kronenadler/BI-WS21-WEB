<?php

use Model\Friend;
use Model\User;

require("src/start.php");

// Test User
$user = new User("Test");

$json = json_encode($user);
echo $json."<br>";

$jsonObject = json_decode($json);
$newUser = User::fromJson($jsonObject);
var_dump($newUser);

echo "<br>";

// Test Friend
$friend = new Friend("Hello There");

$json = json_encode($friend);
echo $json."<br>";

$friend->accept_friend();
$json = json_encode($friend);
echo $json."<br>";

$friend->dismiss_friend();
$json = json_encode($friend);
echo $json."<br>";

$jsonObject = json_decode($json);
$newFriend = Friend::fromJson($jsonObject);
var_dump($newFriend);

?>