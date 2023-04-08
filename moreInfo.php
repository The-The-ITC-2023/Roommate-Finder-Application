<?php

session_start();

$gender_ = $description_ = $university_ = $major_ = null;
$clean_ = $smoke_ = $drugs_ = $loud_ = $weekdaySleep_ = $weekendSleep_ = $petPreference_ = null;

if (isset($_SESSION["currentID"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM account WHERE id = {$_SESSION["currentID"]}";
    $result1 = $mysqli->query($sql);
    $user = $result1->fetch_assoc();

    $sql = "SELECT * FROM preference WHERE acct_id = {$_SESSION["currentID"]}";
    $result2 = $mysqli->query($sql);
    $userPreferences = $result2->fetch_assoc();



    $gender_ = $user["gender"];
    $description_ = $user["bio"];
    $university_ = $user["university"];
    $major_ = $user["major"];

    $clean_ = $userPreferences["clean"];
    $smoke_ = $userPreferences["smoke"];
    $drugs_ = $userPreferences["drugs"];
    $loud_ = $userPreferences["loud"];
    $weekdaySleep_ = $userPreferences["weekdaySleep"];
    $weekendSleep_ = $userPreferences["weekendSleep"];
    $petPreference_ = $userPreferences["petPreference"];
}

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
            $valid = false;
        }

        if (empty($_POST["desc"])) {
            $descErr = "Please write a description about yourself<br>";
            $valid = false;
        } else if (strlen($_POST["desc"]) > 500) {
            $descErr = "Description too long. 500 characters max.";
            $valid = false;
        } else {
            $description = $_POST["desc"];
        }

        if (empty($_POST["university"])) {
            $uniErr = "Please enter your university<br>";
            $valid = false;
        } else {
            $university = $_POST["university"];
        }

        if (empty($_POST["major"])) {
            $majorErr = "Please enter your major<br>";
            $valid = false;
        } else {
            $major = $_POST["major"];
        }

        if (empty($_POST["clean"])) {
            $Err = "Please select answer for cleanliness<br>";
            $valid = false;
        } else {
            $clean = $_POST["clean"];
        }

        if (empty($_POST["smoking"])) {
            $Err = "Please select answer for smoking<br>";
            $valid = false;
        } else {
            $smoke = $_POST["smoking"];
        }

        if (empty($_POST["drugs"])) {
            $Err = "Please select answer for drugs<br>";
            $valid = false;
        } else {
            $drugs = $_POST["drugs"];
        }

        if (empty($_POST["weekdaySleep"])) {
            $Err = "Please select answer for weekday sleeping habits<br>";
            $valid = false;
        } else {
            $weekdaySleep = $_POST["weekdaySleep"];
        }

        if (empty($_POST["weekendSleep"])) {
            $Err = "Please select answer weekend sleeping habits<br>";
            $valid = false;
        } else {
            $weekendSleep = $_POST["weekendSleep"];
        }

        if (empty($_POST["noise"])) {
            $Err = "Please select answer for noise preference<br>";
            $valid = false;
        } else {
            $noise = $_POST["noise"];
        }

        if (empty($_POST["pets"])) {
            $Err = "Please select answer for pet preference<br>";
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
    <?php if (!empty($gender_)) {
        echo "<a href='home.html'>";
    } ?> <img src="ITCLogoOutline.png" class="logo"><?php if (!is_null($gender_)) {
                                                        echo "</a>";
                                                    } ?>
    <div class="form">
        <h1>Tell us about Yourself!</h1>
        <form action="moreInfo.php" method="post" onsubmit="preventRefresh()">

            <div class="gender-container">
                <label id="gender" for="gender">Gender</label><br>
                <div class="spacer"></div>
                <div class="spacer"></div>
                <input <?php if (!(is_null($gender_)) && $gender_ == "female") {
                            echo 'checked';
                        } ?> class="midsized" type="radio" name="gender" value="female" class="gender" required>Female <br>
                <div class="spacer"></div>
                <input <?php if (!(is_null($gender_)) && $gender_ == "male") {
                            echo 'checked';
                        } ?> class="midsized" type="radio" name="gender" value="male" class="gender" required>Male <br>
                <div class="spacer"></div>
                <input <?php if (!(is_null($gender_)) && $gender_ == "other") {
                            echo 'checked';
                        } ?> class="midsized" type="radio" name="gender" value="other" class="gender" required>Other <br>
            </div>

            <p class="midsized form-background">Description: Short bio (hobbies, reason for rooming, etc.)</p> <br>
            <textarea class="midsized" name="desc" id="desc" cols="30" rows="10" required><?php if (!(is_null($description_))) {
                                                                                                echo "{$description_}";
                                                                                            } ?></textarea> <br>

            <p class="midsized form-background">University</p> <br>
            <input class="midsized" required type="text" name="university" <?php if (!(is_null($university_))) {
                                                                                echo "value='{$university_}'>";
                                                                            } ?>> <br>

            <p class="midsized form-background">Major</p> <br>
            <input class="midsized" required type="text" name="major" <?php if (!(is_null($major_))) {
                                                                            echo "value='{$major_}'>";
                                                                        } ?>> <br>

            <div class="preferences-container">
                <label for="clean">How clean are you?</label><br>
                <select required name="clean" id="clean">
                    <option value="">Select Option</option>
                    <option value="messy" <?php if (!(is_null($clean_)) && $clean_ == "messy") {
                                                echo 'selected';
                                            } ?>>Messy</option>
                    <option value="semi messy" <?php if (!(is_null($clean_)) && $clean_ == "semi messy") {
                                                    echo 'selected';
                                                } ?>>Semi messy</option>
                    <option value="neutral" <?php if (!(is_null($clean_)) && $clean_ == "neutral") {
                                                echo 'selected';
                                            } ?>>Neutral</option>
                    <option value="semi neat" <?php if (!(is_null($clean_)) && $clean_ == "semi neat") {
                                                    echo 'selected';
                                                } ?>>Semi neat</option>
                    <option value="neat" <?php if (!(is_null($clean_)) && $clean_ == "neat") {
                                                echo 'selected';
                                            } ?>>Neat</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="smoking">Are you okay with smoking?</label><br>
                <select required name="smoking" id="smoking">
                    <option value="">Select Option</option>
                    <option value="Yes" <?php if (!(is_null($smoke_)) && $smoke_ == "Yes") {
                                            echo 'selected';
                                        } ?>>Yes</option>
                    <option value="No" <?php if (!(is_null($smoke_)) && $smoke_ == "No") {
                                            echo 'selected';
                                        } ?>>No</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="drugs">Are you okay around drugs?</label><br>
                <select name="drugs" id="drugs" required>
                    <option value="">Select Option</option>
                    <option value="Yes" <?php if (!(is_null($drugs_)) && $drugs_ == "Yes") {
                                            echo 'selected';
                                        } ?>>Yes</option>
                    <option value="No" <?php if (!(is_null($drugs_)) && $drugs_ == "No") {
                                            echo 'selected';
                                        } ?>>No</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="sleep">On weekdays, at what times do you typically go to sleep?</label><br>
                <select name="weekdaySleep" id="sleep" required>
                    <option value="">Select Option</option>
                    <option value="8-10" <?php if (!(is_null($weekdaySleep_)) && $weekdaySleep_ == "8-10") {
                                                echo 'selected';
                                            } ?>>8pm - 10pm</option>
                    <option value="10-12" <?php if (!(is_null($weekdaySleep_)) && $weekdaySleep_ == "10-12") {
                                                echo 'selected';
                                            } ?>>10pm - Midnight</option>
                    <option value="12+" <?php if (!(is_null($weekdaySleep_)) && $weekdaySleep_ == "12+") {
                                            echo 'selected';
                                        } ?>>Past Midnight</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="sleep">On weekends, at what times do you typically go to sleep?</label><br>
                <select name="weekendSleep" id="sleep" required>
                    <option value="">Select Option</option>
                    <option value="8-10" <?php if (!(is_null($weekendSleep_)) && $weekendSleep_ == "8-10") {
                                                echo 'selected';
                                            } ?>>8pm - 10pm</option>
                    <option value="10-12" <?php if (!(is_null($weekendSleep_)) && $weekendSleep_ == "10-12") {
                                                echo 'selected';
                                            } ?>>10pm - Midnight</option>
                    <option value="12+" <?php if (!(is_null($weekendSleep_)) && $weekendSleep_ == "12+") {
                                            echo 'selected';
                                        } ?>>Past Midnight</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="noise">How loud/quiet would you like your environment to be?</label><br>
                <select name="noise" id="noise" required>
                    <option value="">Select Option</option>
                    <option value="very loud" <?php if (!(is_null($loud_)) && $loud_ == "very loud") {
                                                    echo 'selected';
                                                } ?>>Very loud</option>
                    <option value="loud" <?php if (!(is_null($loud_)) && $loud_ == "loud") {
                                                echo 'selected';
                                            } ?>>Loud</option>
                    <option value="neutral" <?php if (!(is_null($loud_)) && $loud_ == "neutral") {
                                                echo 'selected';
                                            } ?>>Neutral</option>
                    <option value="quiet" <?php if (!(is_null($loud_)) && $loud_ == "quiet") {
                                                echo 'selected';
                                            } ?>>Quiet</option>
                    <option value="silent" <?php if (!(is_null($loud_)) && $loud_ == "silent") {
                                                echo 'selected';
                                            } ?>>Silent</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="pets">Are you comfortable with having pets?</label><br>
                <select name="pets" id="pets" required>
                    <option value="">Select Option</option>
                    <option value="Yes" <?php if (!(is_null($petPreference_)) && $petPreference_ == "Yes") {
                                            echo 'selected';
                                        } ?>>Yes</option>
                    <option value="No" <?php if (!(is_null($petPreference_)) && $petPreference_ == "No") {
                                            echo 'selected';
                                        } ?>>No</option>
                </select>
            </div>
            <input type="submit" name="submit" value="Submit" class="button submit">
        </form>
    </div>

    <!-- <script src="moreInfo.js"></script> -->
</body>

</html>