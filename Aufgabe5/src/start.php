<?php
session_start();

define('CHAT_SERVER_URL', 'https://online-lectures-cs.thi.de/chat');
define('CHAT_SERVER_ID', '...'); # Ihre Collection ID


spl_autoload_register(function($class) {
    include str_replace('\\', '/', $class) . '.php';
});
?>