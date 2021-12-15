<?php 
    require("./start.php");
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="../../styles/styles.css">
    <title>Nutzereinstellungen</title>
</head>

<body>
    <!--Eingabefunktion und submit mithilfe von Buttons-->
    <form>
        <h2>Profile Settings</h2>
        <fieldset title="Base Data" class="align-center">
            <legend>Base Data:</legend>
            <div class="inline">
                <p>
                    <label class="fixedlabel">First Name</label>
                    <input class="fixed" style="margin: 0 5;" placeholder="Your Name" type="text" value=""/>
                </p>
                <p>
                    <label class="fixedlabel">Last Name</label>
                    <input class="fixed" placeholder="Your Surname" type="text" value=""/> 
                </p>
                <p>Coffee or Tea
                    <select class="fixed" name="hotbeverage" id="beverage">
                        <option value="neither nor">Neither nor</option>
                        <option value="Coffee">Coffee</option>
                        <option value="tea">Tea</option>
                    </select>
                </p> 
            </div> 
        </fieldset>
        <fieldset style="padding: 0.7em; box-sizing: border-box;">
            <legend>Tell me Something about you:</legend>
            <textarea class="big"  placeholder="Some Comment here"></textarea>
        </fieldset>
        <fieldset>
            <legend>Präferenz</legend>
            <div class="beverageleft">
                <div class="block">
                    <input type="radio" id="oneline" name="displaymethod">
                    <label for="oneline"> Username and Message in one Line</label>
                </div>
                <div class="block">
                    <input type="radio" id="sepline" name="displaymethod">
                    <label for="sepline"> Username and Message in seperate Lines</label>
                </div>               
            </div>
        </fieldset>
        <div class="align-center">
            <button>
                Cancel
            </button>
            <button class="blue">
                Save
            </button>
        </div>
    </form>
</body>