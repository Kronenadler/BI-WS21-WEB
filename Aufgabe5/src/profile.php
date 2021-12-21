<?php 
    require("./start.php");
    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }
    $username = $_SESSION["user"];
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $user = $service->loadUser($username);

    // Check if friend to chat with is set
    if(!isset($_GET["profileOf"]) || strlen($_GET["profileOf"] <= 0)){
        header("Location: friends.php");
    } else {
        $friend = $_GET["profileOf"];
    }

    echo $friend;
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
                            echo $user->get_username();
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
                            echo $user->get_firstname();
                        ?>
                        </p>
                </div>
            </div>
        </div>
    </body>
</html>