<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["submit"])) {
        $gender = null;
        $description = null;
        $university = null;
        $major = null;
        $clean = null;
        $smoke = null;
        $drugs = null;
        $weekdaySleep = null;
        $weekendSleep = null;
        $noise = null;
        $petPreference = null;
        $valid = true;

        if (isset($_POST["gender"])) {
            $gender = $_POST['gender'];
        } else {
            $genderErr = "Please select an option for gender<br>";
            echo "{$genderErr}";
            $valid = false;
        }

        if (empty($_POST["desc"])) {
            $descErr = "Please write a description about yourself<br>";
            echo "{$descErr}";
            $valid = false;
        } else if (strlen($_POST["desc"]) > 500) {
            $descErr = "Description too long. 500 characters max.";
            echo "{$descErr}";
            $valid = false;
        } else {
            $description = $_POST["desc"];
        }

        if (empty($_POST["university"])) {
            $uniErr = "Please enter your university<br>";
            echo "{$uniErr}";
            $valid = false;
        } else {
            $university = $_POST["university"];
        }

        if (empty($_POST["major"])) {
            $majorErr = "Please enter your major<br>";
            echo "{$majorErr}";
            $valid = false;
        } else {
            $major = $_POST["major"];
        }

        if (empty($_POST["clean"])) {
            $Err = "Please select answer for cleanliness<br>";
            echo "{$Err}";
            $valid = false;
        } else {
            $clean = $_POST["clean"];
        }

        if (empty($_POST["smoking"])) {
            $Err = "Please select answer for smoking<br>";
            echo "{$Err}";
            $valid = false;
        } else {
            $smoke = $_POST["smoking"];
        }

        if (empty($_POST["drugs"])) {
            $Err = "Please select answer for drugs<br>";
            echo "{$Err}";
            $valid = false;
        } else {
            $drugs = $_POST["drugs"];
        }

        if (empty($_POST["weekdaySleep"])) {
            $Err = "Please select answer for weekday sleeping habits<br>";
            echo "{$Err}";
            $valid = false;
        } else {
            $weekdaySleep = $_POST["weekdaySleep"];
        }

        if (empty($_POST["weekendSleep"])) {
            $Err = "Please select answer weekend sleeping habits<br>";
            echo "{$Err}";
            $valid = false;
        } else {
            $weekendSleep = $_POST["weekendSleep"];
        }

        if (empty($_POST["noise"])) {
            $Err = "Please select answer for noise preference<br>";
            echo "{$Err}";
            $valid = false;
        } else {
            $noise = $_POST["noise"];
        }

        if (empty($_POST["pets"])) {
            $Err = "Please select answer for pet preference<br>";
            echo "{$Err}";
            $valid = false;
        } else {
            $petPreference = $_POST["pets"];
        }

        if ($valid == true) {
            // save original answers
            $mysqli = require __DIR__ . "/database.php";

            $sql = "UPDATE preference
                    SET clean = '{$clean}', smoke = '{$smoke}', drugs = '{$drugs}', weekdaySleep = '{$weekdaySleep}',
                    weekendSleep = '{$weekendSleep}', loud = '{$noise}', petPreference = '{$petPreference}'
                    WHERE id = {$_SESSION["currentID"]}";
            $stmt = $mysqli->stmt_init();
            if (!$stmt->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }
            $stmt->execute();

            switch ($clean) {
                case "messy":
                    $clean = -50;
                    break;
                case "semi messy":
                    $clean = -25;
                    break;
                case "neutral":
                    $clean = 0;
                    break;
                case "semi neat":
                    $clean = 25;
                    break;
                case "neat":
                    $clean = 50;
                    break;
            }
            switch ($smoke) {
                case "Yes":
                    $smoke = 25;
                    break;
                case "No":
                    $smoke = 0;
                    break;
            }
            switch ($drugs) {
                case "Yes":
                    $drugs = 25;
                    break;
                case "No":
                    $drugs = 0;
                    break;
            }
            switch ($weekdaySleep) {
                case "8-10":
                    $weekdaySleep = -25;
                    break;
                case "10-12":
                    $weekdaySleep = 0;
                    break;
                case "12+":
                    $weekdaySleep = 25;
                    break;
            }
            switch ($weekendSleep) {
                case "8-10":
                    $weekendSleep = -25;
                    break;
                case "10-12":
                    $weekendSleep = 0;
                    break;
                case "12+":
                    $weekendSleep = 25;
                    break;
            }
            switch ($noise) {
                case "very loud":
                    $noise = -50;
                    break;
                case "loud":
                    $noise = -25;
                    break;
                case "neutral":
                    $noise = 0;
                    break;
                case "quiet":
                    $noise = 25;
                    break;
                case "silent":
                    $noise = 50;
                    break;
            }
            switch ($petPreference) {
                case "Yes":
                    $petPreference = 25;
                    break;
                case "No":
                    $petPreference = 0;
                    break;
            }

            // adds values
            $sql = "UPDATE preferenceValues
                    SET clean = '{$clean}', smoke = '{$smoke}', drugs = '{$drugs}', weekdaySleep = '{$weekdaySleep}',
                    weekendSleep = '{$weekendSleep}', loud = '{$noise}', petPreference = '{petPreference}'
                    WHERE id = {$_SESSION["currentID"]}";
            $stmt = $mysqli->stmt_init();
            if (!$stmt->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }
            $stmt->execute();

            // adds account info
            $sql = "UPDATE account 
                    SET bio = '{$description}', university = '{$university}', major = '{$major}', gender = '{$gender}'
                    WHERE id = {$_SESSION["currentID"]}";

            $stmt = $mysqli->stmt_init();

            if (!$stmt->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }

            $stmt->execute();

            header("Location: index.php");
        }
    }
}
?>

<html>

<head>
    <title>Edit Account</title>
    <link rel="stylesheet" href="styles/moreinfo.css">

</head>

<body>
    <a href="home.html"><img src="ITCLogoOutline.png" class="logo"></a>
    <div class="form">
        <h1>Tell us about Yourself!</h1>
        <form action="moreInfo.php" method="post" onsubmit="preventRefresh()">

            <div class="gender-container">
                <label id="gender" for="gender">Gender</label><br>
                <div class="spacer"></div>
                <div class="spacer"></div>
                <input class="midsized" type="radio" name="gender" value="female" class="gender">Female <br>
                <div class="spacer"></div>
                <input class="midsized" type="radio" name="gender" value="male" class="gender">Male <br>
                <div class="spacer"></div>
                <input class="midsized" type="radio" name="gender" value="other" class="gender">Other <br>
            </div>

            Description: Short bio (hobbies, reason for rooming, etc.) <br>
            <textarea class="midsized" name="desc" id="desc" cols="30" rows="10"></textarea> <br>
            <p class="midsized form-background">University</p> <br>
            <input class="midsized" type="text" name="university"> <br>
            <p class="midsized form-background">Major</p> <br>
            <input class="midsized" type="text" name="major"> <br>
            <div class="preferences-container">
                <label for="clean">How clean are you?</label><br>
                <select name="clean" id="clean">
                    <option value="">Select Option</option>
                    <option value="messy">Messy</option>
                    <option value="semi messy">Semi messy</option>
                    <option value="neutral">Neutral</option>
                    <option value="semi neat">Semi neat</option>
                    <option value="neat">Neat</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="smoking">Are you okay with smoking?</label><br>
                <select name="smoking" id="smoking">
                    <option value="">Select Option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="drugs">Are you okay around drugs?</label><br>
                <select name="drugs" id="drugs">
                    <option value="">Select Option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="sleep">On weekdays, at what times do you typically go to sleep?</label><br>
                <select name="weekdaySleep" id="sleep">
                    <option value="">Select Option</option>
                    <option value="8-10">8pm - 10pm</option>
                    <option value="10-12">10pm - Midnight</option>
                    <option value="12+">Past Midnight</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="sleep">On weekends, at what times do you typically go to sleep?</label><br>
                <select name="weekendSleep" id="sleep">
                    <option value="">Select Option</option>
                    <option value="8-10">8pm - 10pm</option>
                    <option value="10-12">10pm - Midnight</option>
                    <option value="12+">Past Midnight</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="noise">How loud/quiet would you like your environment to be?</label><br>
                <select name="noise" id="noise">
                    <option value="">Select Option</option>
                    <option value="very loud">Very loud</option>
                    <option value="loud">Loud</option>
                    <option value="neutral">Neutral</option>
                    <option value="quiet">Quiet</option>
                    <option value="silent">Silent</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="pets">Are you comfortable with having pets?</label><br>
                <select name="pets" id="pets">
                    <option value="">Select Option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <input type="submit" name="submit" value="Submit" class="button submit">
        </form>
    </div>

    <!-- <script src="moreInfo.js"></script> -->
</body>

</html>