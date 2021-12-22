<?php 
    require("./start.php");
    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }
    $username = $_SESSION["user"];
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

    // Check if friend to chat with is set
    if(!isset($_GET["profileOf"]) || strlen($_GET["profileOf"] <= 0)){
        header("Location: friends.php");
    } else {
        $friend = $_GET["profileOf"];
        $user = $service->loadUser($friend);
    }

    // Check if friend should be removed
    if(isset($_GET["removeFriend"])){
        $service->friendRemove($_GET["removeFriend"]);
        header("Location: friends.php");
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="../styles/styles.css">
        <title>
            Profile
        </title>
    </head>
    <body>
        <div>
            <div>
                <h2>Profile of <?php echo $friend?></h2>
                <a  href="chat.php?chatWith=<?php echo $friend?>">
                  &lt; Back To Chat
                </a> | 
                <a class="dangerous" href="./profile.php?removeFriend=<?php echo $friend ?>">Remove Friend</a>
            </div>
            <div style="margin: 20 0 0 0;"> 
                <img src="../images/profile.png" class="left"> 
                <div class="right">
                        <p>
                            <?php
                            echo $user->get_comment();
                            ?>
                        </p>
            
                        <p>Coffee or Tea ?</p>
                        <p>      
                        <?php
                            echo $user->get_coffeeOrTea();
                        ?> 
                        </p>
                        <p>Name</p>
                        <p>      
                        <?php
                            echo "{$user->get_firstname()}   {$user->get_lastname()}";
                        ?>
                        </p>
                </div>
            </div>
        </div>
    </body>
</html>