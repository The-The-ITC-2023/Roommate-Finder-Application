
<?php

session_start();

$gender = "";

if (isset($_SESSION["currentID"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM account WHERE email = '{$_COOKIE['email']}'";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    $gender = $user["gender"];

    $sql = "SELECT * FROM preference WHERE acct_id = '{$user['id']}'";
    $result2 = $mysqli->query($sql);
    $userPreferences = $result2->fetch_assoc();

    $sql = "SELECT * FROM images WHERE id = {$user['id']}";
    $result1 = $mysqli->query($sql);
    $result = $result1->fetch_assoc();
}
?>

<html>

<head>
    <title>User</title>
    <link rel="stylesheet" href="styles/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
</head>

<body>
    <!-- <a href="home.html"><img src="ITCLogoOutline.png" class="logo"></a>
    <hr />
    <div class="parent">
        <a href="search.php"><button class="topleft searchButton">Search</button> </a>
        <div class="topright">
            <a href="moreInfo.php"><button class="acctButton">Edit Account</button></a> <a href="home.html"><button class="acctButton">Sign Out</button></a>
        </div>
        <div class="greeting">
            <p class="centertext">Hello <?= $user["firstName"] ?>!</p>
        </div>
    </div> -->

    <img src="ITCLogoOutline.png" class="logo">
    <hr />
    <div class="parent">
        <div class="topleft">
        </div>
        <div class="topright">
            <a href="search.php"><button class="button">Back</button></a>
        </div>
        <div class="greeting">
            <p class="centertext"><?= $user["firstName"] ?>'s Profile</p>
        </div>

        <div class ="profileDiv">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($result['image']); ?>" class="profilePic" alt="None"/> 
        </div> 

        <div class="bioDiv">
            <h1 class="divHeader">Biography</h1>
            <textarea disabled class="bioText" name="desc" id="desc" cols="30" rows="10"><?=$user["bio"] ?></textarea>

            <p class="genderP">Gender: <?php if ($gender == "male") {
                echo "Male";} elseif ($gender == "female") {echo "Female";} elseif ($gender == "other") {
                    echo "Other";
                } ?></p>
            <p class="universityP">University: <?= $user["university"] ?></p>
            <p class="majorP">Major: <?= $user["major"] ?></p>

        </div>

        <div class="preferenceDiv">
            <div class = "innerFlex">
            <h1 class="divHeader">Preferences</h1>
            <div class="preferenceBox">Cleanliness: <?= $userPreferences["clean"] ?></div>
            <div class="preferenceBox">Pets:  <?= $userPreferences["petPreference"] ?></div>
            <div class="preferenceBox">Smoking: <?= $userPreferences["smoke"] ?></div>
            <div class="preferenceBox">Drugs: <?= $userPreferences["drugs"] ?></div>
            <div class="preferenceBox">Weekday Sleep: <?= $userPreferences["weekdaySleep"] ?></div>
            <div class="preferenceBox">Weekend Sleep: <?= $userPreferences["weekendSleep"] ?></div>
            <div class="preferenceBox bottom">Noise: <?=$userPreferences["loud"] ?></div>
        </div>

    </div>
</body>
</html>




