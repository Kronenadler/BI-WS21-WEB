<?php 
    require("./start.php");
    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }
    $username = $_SESSION["user"];
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $user = $service->loadUser($username);
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
                <h2>Profile of Tom</h2>
                <a  href="./chat.html">
                  &lt; Back To Chat
                </a> | 
                <a class="dangerous" href="./friends.html">
                    Remove Friend
                </a>
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
                            echo $user->get_firstname() + " " + $user->get_lastname();
                        ?>
                        </p>
                </div>
            </div>
        </div>
    </body>
</html>