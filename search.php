<?php

session_start();

if (isset($_SESSION["currentID"])) {

    $mysqli = require __DIR__ . "/database.php";

    // finds unique universities
    $stmt2 = sprintf("SELECT *  FROM account");
    $result = $mysqli->query($stmt2);

    $universityArray = [];
    while ($row = $result->fetch_assoc()) {
        array_push($universityArray, $row['university']);
    }

    $unique = array_unique($universityArray);
    // end
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    //$name = $_POST["firstName"];
    $university = $_POST["university"];

    $stmt = "SELECT * FROM account WHERE university = '{$university}' AND NOT id = '{$_SESSION["currentID"]}'";

    //mysqli_stmt_bind_param($stmt, 's', $name);

    $result = $mysqli->query($stmt);

    // $user = $result->fetch_assoc();

    //init header row
    echo "<table class='fetch-results'>";
    echo "<tr>";
    echo "<th>Email</th><th>Name</th><th>Gender</th><th>University</th><th>Similarity</th>";
    echo "</tr>";

    // returns array of preference values
    $stmt2 = sprintf("SELECT *  FROM preferencevalues WHERE acct_id = '{$_SESSION["currentID"]}'");
    $result2 = $mysqli->query($stmt2);
    $currentUser = $result2->fetch_assoc();

    //populate table
    $counter = 0;
    $clicked = "";
    while ($row = $result->fetch_assoc()) {

        $foundUserID = $row['id'];
        $stmt2 = sprintf("SELECT *  FROM preferencevalues WHERE acct_id = '{$foundUserID}'");
        $result2 = $mysqli->query($stmt2);
        $foundUser = $result2->fetch_assoc();


        $sum = abs($currentUser['clean'] - $foundUser['clean']) / 2;
        $sum = $sum + abs($currentUser['smoke'] - $foundUser['smoke']) / 2;
        $sum = $sum + abs($currentUser['drugs'] - $foundUser['drugs']) / 2;
        $sum = $sum + abs($currentUser['loud'] - $foundUser['loud']) / 2;
        $sum = $sum + abs($currentUser['weekdaySleep'] - $foundUser['weekdaySleep']) / 2;
        $sum = $sum + abs($currentUser['weekendSleep'] - $foundUser['weekendSleep']) / 2;
        $sum = $sum + abs($currentUser['petPreference'] - $foundUser['petPreference']) / 2;

        $similarityValue = ceil(100 - ($sum / 7) * 4);
        echo "<br>";

        echo "<tr>";
        echo "<td>";
        echo "<a href='profile.php' id = {$counter}' onClick='getID(this)'>{$row['email']}</a>";
        echo "</td>";
        echo "<td>", $row['firstName'], " ", $row['lastName'], "</td>";
        echo "<td>", $row['gender'], "</td>";
        echo "<td>", $row['university'], "</td>";
        echo "<td>", $similarityValue . "%", "</td>";
        echo "</tr>";
        $counter = $counter + 1;
    }
    echo "</table>";

    // print($currentUser['clean']);
    // print($foundUser['clean']);
} // end if

?>

<html>

<head>
    <title>Search</title>
    <link rel="stylesheet" href="styles/search.css" />
    <script src="search.js"></script>
</head>

<body>
    <div id='nav' class='sticky'>
        <a href="home.html"><img src="ITCLogoOutline.png" class="logo fixed"></a>
        <hr class="" />
    </div>

    <div class="topright">
        <a href="index.php"><button class="acctButton">Back</button></a>
    </div>

    <div class="form">
        <form action="search.php" method="post">
            University:
            <br />
            <select name='university'>
                <option value=''>Select University</option>
                <?php
                foreach ($unique as $item) {
                    $stmt3 = sprintf("<option value='%s'>%s</option>", $item, $item);
                    echo $stmt3;
                } ?>
            </select>
            <input type="submit" value="Submit" />
        </form>
    </div>

</body>

</html>