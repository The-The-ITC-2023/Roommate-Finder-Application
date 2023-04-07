<?php

session_start();

if (isset($_SESSION["currentID"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM account WHERE id = {$_SESSION["currentID"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}
?>

<html>

<head>
    <title>User</title>
    <link rel="stylesheet" href="styles/index.css">
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

    <a href="home.html"><img src="ITCLogoOutline.png" class="logo"></a>
    <hr />
    <div class="parent"></div>
</body>

</html>