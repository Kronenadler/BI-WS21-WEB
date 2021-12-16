<?php

use Utils\BackendService;

require("src/start.php");
$service = new BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
var_dump($service->test());
echo "<br><br>";

/*var_dump($service->register("Test123", "12345678"));
echo "<br><br>";*/

var_dump($service->login("Test123", "12345678"));
echo $_SESSION["chat_token"];
echo "<br><br>";


/*$testLogin = $service->login("Test123", "12345678");
if($testLogin === false){
    echo "false<br>";
} else {
    var_dump($testLogin);
    echo "<br>";
}*/