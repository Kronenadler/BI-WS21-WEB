<?php

require("./start.php");
$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

// Check if user is logged in
if(!isset($_SESSION["user"]) || !isset($_SESSION["chat_token"])){
    header("Location: login.php");
}

// Check if friend should be removed
if(isset($_GET["removeFriend"])){
    $service->friendRemove($_GET["removeFriend"]);
    header("Location: friends.php");
}

// Check if friend to chat with is set
if(!isset($_GET["chatWith"])){
    header("Location: friends.php");
} else {
    $friend = $_GET["chatWith"];
}

?>
<!DOCTYPE html>

<!-- 
    Header 
-->
<header>
    <link rel="stylesheet" href="../styles/styles_general_nick.css">
    <link rel="stylesheet" href="../styles/styles_chat_nick.css">

    <script src="../scripts/chat.js"></script>
    
    <!-- User Token Stuff -->
    <script>
        const chat = {
            "url": "<?php echo CHAT_SERVER_URL ?>",
            "collection_id": "<?php echo CHAT_SERVER_ID ?>",
            "currentUser": "<?php echo $_SESSION["user"] ?>",
            "token": "<?php echo $_SESSION["chat_token"] ?>",
            "messagedUser": "<?php echo $friend ?>"
        };
    </script>

    <title>Chat</title>
</header>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
</head>

<!--
    Body
-->
<body class="full-screen">
    <h1 id="chat_title" class="title">Chat with <?php echo $friend ?></h1>

    <!-- Menu-->
    <p id="nav_header">
        <a href="./friends.php">&lt; Back</a> |
        <a href="./profile.php">Profile</a> |
        <!-- ToDo: Remove Friend Functionality -->
        <a href="./chat.php?removeFriend=<?php echo $friend ?>">Remove Friend</a>
        
    </p>



    <!-- Chat messages -->
    <div id="message_box" class="box">
        <div>
            <label>There are currently no text messages</label>
        </div>
    </div>

    <!-- New message -->
    <form id="message_form" method="post" onsubmit="sendMessage(); return false">
        <input id="message_form_input" type="text" placeholder="New Message">
        <button class="btn" type="submit">Send</button>
    </form>



    <script>
        main();
    </script>
</body>