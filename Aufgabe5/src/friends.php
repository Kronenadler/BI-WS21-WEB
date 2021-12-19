<?php require("start.php");
if(!isset($_SESSION["user"])) {
    header("Location: login.php");
}
$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

if(isset($_POST["reqFriend"]) && $_POST["action"] == "add-friend")
{
    if(isset($_POST["reqFriend"]))
    {
        $friend1 = new Model\Friend($_POST["reqFriend"]);
        $service->friendRequest($friend1);
    }
    else { $errorAdd = "Fehler beim hinzufügen";}
}
else { $errorAdd = "Fehler beim hinzufügen";}

if(isset($_POST["accepted"])){
    $service->friendAccept($_POST["accepted"]);
}
if(isset($_POST["dismiss"])){
    $service->friendDismiss($_POST["dismiss"]);
}
if(isset($_POST["remove"])){
    $service->friendAccept($_POST["remove"]);
}
$friendlist = $service->loadFriends();
array_push($friendlist, "Hans", "Peter");


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

<body class="friends">
    <h1>Friends</h1>
    <div><?php $help1 =$_SESSION["user"];
        echo $help1; ?>
    </div>
    <a href="./logout.php" id="link"> &lt; Log out</a>
    <span>|</span>
    <a href="./settings.php" id="link">Settings</a>
    <hr class="friendslist">
    <ul class="friends">
        <?php 
        if(empty($friendlist)) {
        foreach ($friendlist as $value) {
            $friend = new Model\Friend($value); //create every friend
            if($friend->get_status() == "accepted"){    //check if friend is accepted ?>
                  <li id="friendslist"><?= $value ?> 
                  <button class="msgcount" type="submit" name="remove"
                    value=<?php $value ?>>Remove Friend</button>
                  <button class="msgcount">3</button>
            <?php }
            }
        }
           else {?>
         <li id="friendslist"><?= "You got no friends" ?>
         <?php }; ?>
    </ul>


    <hr class="friendslist">
    <h2>New Requests:</h2>
    <form action="friends.php" method="post">
        <ol>
            <?php 
        if(count($friendlist) != 0) {
            foreach ($friendlist as $value) {
                $friend = new Model\Friend($value);
                if($friend->get_status() == "requested")
                {?>
                    <li id="friendslist"><?= $value ?>
                    <button class="msgcount" type="submit" name="accept" value=<?php $value ?>>Accept Friend</button>
                    <button class="msgcount" type="submit" name="dismiss" value=<?php $value ?>>Dismiss Friend</button>
                <?php }
            }
        }
            else {?>
                
            <?php }; ?>
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