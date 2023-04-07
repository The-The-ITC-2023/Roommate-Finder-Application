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
    <hr style="margin-top: 8%;" />
    <a href="search.php"><button class="topleft homeButton">Search</button> </a>
    <div class="topright">
        <a href="moreInfo.php"><button class="homeButton">Edit Account</button></a>
        <a href="home.html"><button class="homeButton">Sign Out</button></a>
    </div>
    <div class="greeting">
        <p class="centertext">Hello <?= $user["firstName"] ?>!</p>
    </div>
</body>

</html>