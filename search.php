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
    echo "<table border='1px solid black' class='fetch-results'>";
    echo "<tr>";
    echo "<th>Name</th><th>Gender</th><th>University</th><th>Email</th><th>Similarity</th>";
    echo "</tr>";

    // returns array of preference values
    $stmt2 = sprintf("SELECT *  FROM preferenceValues WHERE acct_id = '{$_SESSION["currentID"]}'");
    $result2 = $mysqli->query($stmt2);
    $currentUser = $result2->fetch_assoc();

    //populate table
    while ($row = $result->fetch_assoc()) {

        $foundUserID = $row['id'];
        $stmt2 = sprintf("SELECT *  FROM preferenceValues WHERE acct_id = '{$foundUserID}'");
        $result2 = $mysqli->query($stmt2);
        $foundUser = $result2->fetch_assoc();

        // print($foundUser['acct_id']);
        // foreach ($foundUser as $item) {
        //     print $item;
        // }
        // echo "<br>";

        echo "<tr>";
        echo "<td>", $row['firstName'], " ", $row['lastName'], "</td>";
        echo "<td>", $row['gender'], "</td>";
        echo "<td>", $row['university'], "</td>";
        echo "<td>", $row['email'], "</td>";
        echo "<td>", $foundUserID, "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // print($currentUser['clean']);
    // print($foundUser['clean']);
} // end if

?>

<html>

<head>
    <title>Search</title>
    <!-- <link rel="stylesheet" href="styles/search.css" /> -->
</head>

<body>
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
        <input type="submit" value="submit" />
    </form>
</body>

</html>