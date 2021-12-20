<?php

require("./start.php");
$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

$bool_name_empty = false;
$bool_name_exists = false;
$bool_pw_empty = false;
$bool_pw_different = false;

if (isset($_POST["username"])) {

    // Checks if password is ok

    // check username length
    (strlen($_POST["username"]) < 3) ? $bool_name_empty = true : $bool_name_empty = false;

    // check username existence
    ($service->userExists($_POST["username"])) ? $bool_name_exists = true : $bool_name_exists = false;

    // check password length
    (strlen($_POST["password"]) < 8) ? $bool_pw_empty = true : $bool_pw_empty = false;

    // check second password
    (strcmp($_POST["password"], $_POST["password2"]) !== 0) ? $bool_pw_different = true : $bool_pw_different = false;

    // Post Register message if every input is ok
    if (!$bool_name_empty && !$bool_name_exists && !$bool_pw_empty && !$bool_pw_different){
        $response = $service->register($_POST["username"], $_POST["password"]);
        if ($response == true) {
            header("Location: friends.php");
        } else {
            $bool_name_exists = true;
        }
    }
}
?>





<!DOCTYPE html>

<!-- 
    Header 
-->
<header>
    <link rel="stylesheet" href="../styles/styles_general_nick.css">
    <link rel="stylesheet" href="../styles/styles_login_nick.css">
    <title>Register</title>
</header>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
</head>

<!--
    Body
-->
<body class="full-screen">
    <img src="../images/user.png">

    <h1 class="title">Register yourself</h1>

    <form name="myForm" id="form" action="register.php" method="post">
        <fieldset class="box" method="get">
            <legend class="legend_login">Register</legend>

            <p class="max-small">
                <label for="Username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" value="<?php if(isset($_POST["username"])) { echo $_POST["username"];}?>">
                <?php
                    if($bool_name_empty){
                        echo "<br><label style='color:red'>The username must have at least 3 characters!</label>";
                    }
                    if($bool_name_exists){
                        echo "<br><label style='color:red'>This username already exists!</label>";
                    }
                ?>
            </p>
            <p class="max-small">
                <label for="Password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password">
                <?php
                    if($bool_pw_empty){
                        echo "<br><label style='color:red'>The password must have at least 8 characters!</label>";
                    }
                ?>
            </p>
            <p class="max-small">
                <label for="Password">Confirm Password</label>
                <input type="password" id="password2" name="password2" placeholder="Repeat Password">
                <?php
                    if($bool_pw_different){
                        echo "<br><label style='color:red'>Entered passwords don't match!</label>";
                    }
                ?>
            </p>

        </fieldset>
        <div id="bottom_btns">
            <button class="btn" onclick="location.href='./login.php'" type="button">Cancel</button>
            <button class="btn" type="submit" value="Submit">Create Account</button>
        </div>
    </form>

    <!--script src="../scripts/registration.js"></script-->


</body>