<?php
session_start();

define('CHAT_SERVER_URL', 'https://online-lectures-cs.thi.de/chat');
define('CHAT_SERVER_ID', '0be8ffd7-60bb-4f00-84fc-4e8a9cb53aa3'); # Ihre Collection ID

include("../Utils/BackendService.php");

spl_autoload_register(function($class) {
    include '../'.str_replace('\\', '/', $class) . '.php';
});
?>