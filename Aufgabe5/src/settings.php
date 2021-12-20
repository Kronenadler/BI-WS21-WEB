<?php 
    require("./start.php");


    $firstname = '';
    $lastname = '';
    $coffeeOrTea = 0;
    $comment = '';
    $layout = '';
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
        $user->set_comment($_POST['comment']);
        $user->set_layout($_POST['layout']);

        var_dump($user);
        $service->saveUser($user);
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
                    <input class="fixed" name="firstname" style="margin: 0 5;" type="text" value=<?=$firstname?> />
                </p>
                <p>
                    <label class="fixedlabel">Last Name</label>
                    <input class="fixed" name="lastname" type="text" value=<?=$lastname?>/> 
                </p>
                <p>Coffee or Tea
                    <select class="fixed" name="coffeeOrTea" id="beverage">
                        <option value="neither nor">Neither nor</option>
                        <option value="Coffee">Coffee</option>
                        <option value="tea">Tea</option>
                    </select>
                </p> 
            </div> 
        </fieldset>
        <fieldset style="padding: 0.7em; box-sizing: border-box;">
            <legend>Tell me Something about you:</legend>
            <textarea name="comment" class="big">
                <?php
                echo htmlspecialchars($comment);
                ?>
            </textarea>
        </fieldset>
        <fieldset>
            <legend>Präferenz</legend>
            <div class="beverageleft">
                <div class="block">
                    <input type="radio" name="layout" value="1" <?php echo ($layout=='1')?'checked':'' ?>>
                    <label for="oneline"> Username and Message in one Line</label>
                </div>
                <div class="block">
                    <input type="radio" name="layout" value="2" <?php echo ($layout=='2')?'checked':'' ?>> 
                    <label for="sepline"> Username and Message in seperate Lines</label>
                </div>               
            </div>
        </fieldset>
        <div class="align-center">
            <button>
                Cancel
            </button>
            <input class="blue" type="submit" name="submit">
            </button>
        </div>
    </form>
</body>