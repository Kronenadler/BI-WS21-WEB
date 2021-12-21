<?php require("start.php");
if(!isset($_SESSION["user"])) {
    header("Location: login.php");
}
//header("Refresh:10");
$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
$friendlist = $service->loadFriends();

if(isset($_POST["reqFriend"]) && $_POST["action"] == "add-friend" && $_POST["reqFriend"] != $_SESSION["user"])
{  

        $service->friendRequest($_POST["reqFriend"]);   
        header("Location: friends.php");

}
else { $errorAdd = "Fehler beim hinzufügen";}

if(isset($_POST["remove"]) ){
    $service->friendRemove($_POST["remove"]);
    header("Location: friends.php");}

if(isset($_POST["dismiss"])){
    $service->friendDismiss($_POST["dismiss"]);
    header("Location: friends.php");}

 if(isset($_POST["accept"])){
    $service->friendAccept($_POST["accept"]);
    header("Location: friends.php");}
 if(isset($_POST["chat"])){
        header("Location: chat.php?chatWith=".$_POST["chat"]);}
 


?>
<!DOCTYPE html>
<!--Diese Ansicht enthält drei Bereiche: die ungeordnete Liste mit aktuellen Freunden, die
geordnete Liste mit Freundschaftsanfragen und ein Formular, mit dem ein neuer Freund
hinzugefügt werden kann. Setzen Sie die Listen sowie das Formular um und separieren Sie
diese visuell voneinander, zum Beispiel über eine Trennungslinie. Verlinken Sie die Einträge in
der Liste mit Freunden mit der Chat-Ansicht. Ergänzen Sie einen Link zur Logout-Ansicht und
ggf. zu den Nutzerprofil-Einstellungen.->
<form action="send.html" method="post"> -->

<header>
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/friends.js"></script>
    <title>
        Friendslist
    </title>
</header>
<script>
window.chatToken = "<?= $_SESSION['chat_token'] ?>";
window.chatCollectionId = "<?= $CHAT_SERVER_ID ?>";
window.chatServer = "<?= $CHAT_SERVER_URL ?>";
</script>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="friends" >
    <div><h1>Friends
    <button class="refresh" onclick="location.reload();">Refresh Page</button></h1>
    </div>
    <div><?php $help1 =$_SESSION["user"];
        echo "User logged in: ".$help1; ?>
    </div>
    <a href="./logout.php" id="link"> &lt; Log out</a>
    <span>|</span>
    <a href="./settings.php" id="link">Settings</a>
    <hr class="friendslist">
    <div id="2222">
    <ul class="friends">
        <?php 
        $notempty = false;   
        $acceptedCount = 0;                              //$friendlist = array aus objects
        if(count($friendlist) > 0) {       //Hat der Array einen Inhalt?
        foreach ($friendlist as $friend) { 
            $notempty=false; 
           
            if($friend->status == "accepted"){
          ?>    <form method="post">
                    <li id="friendslist"><?= $friend->username ?>    
                    <button class="buttonsphp" type="submit" name="remove"
                    value=<?= $friend->username ?>>Remove Friend</button>
                    <button class="msgcount" type="submit" name="chat" value="<?php echo $friend->username ?>">Chat</button>
            </form>
            <?php 
             $acceptedCount = $acceptedCount + 1;
            } else { ?><li id="friendslist"><?= "You got no friends" ?><?php }
        }
        }
           else if( $acceptedCount == 0) {
               ?>
         <li id="friendslist"><?= "You got no friends" ?>
         <?php };
        ?>
    </ul>
           </div>   

    <hr class="friendslist">
    <h2>New Requests:</h2>
    <form action="friends.php" method="post">
        <ol>
            <?php 
       // if(count($friendlist) != 0) {
            foreach ($friendlist as $friend) {
                if($friend->status == "requested")
                {?>
                    <li id="friendslist"><?= $friend->username ?>
                    <button class="buttonsphp" type="submit" name="accept" value=<?= $friend->username ?>>Accept</button>
                    <button class="buttonsphp" type="submit" name="dismiss" value=<?= $friend->username ?>>Dismiss</button>
                   
                <?php }
            }
        //}
          //  else {?>
                
            <?php //}; ?>
        </ol>
        
    
    </form>
    <form method="post">
        <hr class="friendslist">
        <input class="frInsertUsername" placeholder="Add Friend to List" type="text" name="reqFriend" value="" size="20"
            maxlength="50;" list="names" onkeyup="keyup(this)" />
        <datalist id="names">
            <option value="Test"></option>
        </datalist>
        <!--id="link"-->
        <button class="sendFR" name="action" type="submit" value="add-friend">Add</button>
    </form>
</body>
