<?php require("start.php");
if(!isset($_SESSION["user"])) {
    header("Location: login.php");
}
$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

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

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="friends" >
    <h1>Friends</h1>
    <div><?php $help1 =$_SESSION["user"];
        echo $help1; ?>
    </div>
    <a href="./logout.php" id="link"> &lt; Log out</a>
    <span>|</span>
    <a href="./profile/settings.html" id="link">Settings</a>
    <hr class="friendslist">
    <ul class="friends">
        <?php 
        if(count($friendlist) != 0) {
        foreach ($friendlist as $value) {
            $friend = new Model\Friend($value);
            if($friend->get_status() == "accepted"){?>
        <li id="friendslist"><?= $value ?><button class="msgcount">3</button>
            <?php }}}
            else {?>
        <li id="friendslist"><?= "You got no friends" ?><?php }; ?>

    </ul>


    <hr class="friendslist">
    <h2>New Requests:</h2>
    <ol>
        <li class="friendrequest"><a href="#FRbyTrack">Friend Request from Track</a></li>
    </ol>
    <hr class="friendslist">
    <input class="frInsertUsername" placeholder="Add Friend to List" type="text" name="Username" value="" size="20"
        maxlength="50;" list="names" onkeyup="keyup(this)" />
    <datalist id="names">
        <option value="Test"></option>
    </datalist>
    <a href="#add">
        <!--id="link"-->
        <button class="sendFR">Add</button>
    </a>
</body>