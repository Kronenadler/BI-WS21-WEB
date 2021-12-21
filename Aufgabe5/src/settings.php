<?php 
    require("./start.php");


    $firstname;
    $lastname;
    $coffeeOrTea;
    $comment;
    $layout;
    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }
    $username = $_SESSION["user"];
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $user = $service->loadUser($username);

    echo "nach Laden <br/>";

    var_dump($user);

    echo "<br/> nach Speichern <br/>";

    $firstname = $user->get_firstname();
    $lastname = $user->get_lastname();
    $coffeeOrTea = $user->get_coffeeOrTea();
    $comment = $user->get_comment();
    $layout = $user->get_layout();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $user->set_firstname($_POST['firstname']);
        $user->set_lastname($_POST['lastname']);
        $user->set_coffeeOrTea($_POST['coffeeOrTea']);
        $user->set_comment(test_input($_POST["comment"]));
        $user->set_layout($_POST['layout']);

        $response = $service->saveUser($user);

        if ($response == true) {
            header("Location: friends.php");
        }
    }

    // Check if friend should be removed
    if(isset($_GET["removeFriend"])){
        $service->friendRemove($_GET["removeFriend"]);
        header("Location: friends.php");
    }


    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Nutzereinstellungen</title>
</head>

<body>
    <!--Eingabefunktion und submit mithilfe von Buttons-->
    <form name="settingsform" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h2>Profile Settings</h2>
        <fieldset title="Base Data" class="align-center">
            <legend>Base Data:</legend>
            <div class="inline">
                <p>
                    <label class="fixedlabel">First Name</label>
                    <input class="fixed" placeholder="Your Name" name="firstname" style="margin: 0 5;" type="text" value=<?php echo $firstname?> ></input>
                </p>
                <p>
                    <label class="fixedlabel">Last Name</label>
                    <input class="fixed" placeholder="Your Surname" name="lastname" type="text" value=<?php echo $user->get_lastname()?> ></input>
                </p>
                <p>Coffee or Tea
                    <select class="fixed" name="coffeeOrTea" id="beverage">
                        <option value="Neither nor" <?php echo ($user->get_coffeeOrTea()=='Neither nor')?'selected':'' ?>>Neither nor</option>
                        <option value="Coffee" <?php echo ($user->get_coffeeOrTea()=='Coffee')?'selected':'' ?>>Coffee</option>
                        <option value="Tea" <?php echo ($user->get_coffeeOrTea()=='Tea')?'selected':'' ?>>Tea</option>
                    </select>
                </p> 
            </div> 
        </fieldset>
        <fieldset style="padding: 0.7em; box-sizing: border-box;">
            <legend>Tell me Something about you:</legend>
            <textarea name="comment" class="big" rows="5" cols="40" placeholder="Some Comment here"><?php echo test_input($user->get_comment()); ?></textarea>
        </fieldset>
        <fieldset>
            <legend>Präferenz</legend>
            <div class="beverageleft">
                <div class="block">
                    <input type="radio" name="layout" value="1" <?php echo ($user->get_layout()=='1')?'checked':'' ?>>
                    <label for="oneline"> Username and Message in one Line</label>
                </div>
                <div class="block">
                    <input type="radio" name="layout" value="2" <?php echo ($user->get_layout()=='2')?'checked':'' ?>> 
                    <label for="sepline"> Username and Message in seperate Lines</label>
                </div>               
            </div>
        </fieldset>
        <div class="align-center">
            <button onclick="location.href='./friends.php'"> Cancel </button>
            <button class="blue" type="submit" name="submit">
            Save
            </button>
        </div>
    </form>
</body>