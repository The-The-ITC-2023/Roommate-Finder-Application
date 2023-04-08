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

    // echo "<form action='search.php' method='post'>";
    // echo "<select name='university'>";
    // echo "<option value = ''>Select University</option>";
    // foreach ($unique as $item) {
    //     $stmt3 = sprintf("<option value='%s'>%s</option>", $item, $item);
    //     echo $stmt3;
    // }
    // echo "</select>";
    // echo "</form>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    //$name = $_POST["firstName"];
    $university = $_POST["university"];

    $stmt = "SELECT * FROM account WHERE university = '{$university}'";
    //mysqli_stmt_bind_param($stmt, 's', $name);

    $result = $mysqli->query($stmt);

    // $user = $result->fetch_assoc();

    //init header row
    echo "<table border='1px solid black'>";
    echo "<tr>";
    echo "<th>Name</th><th>Gender</th><th>University</th><th>Email</th><th>Similarity</th>";
    echo "</tr>";

    //populate table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>", $row['firstName'], " ", $row['lastName'], "</td>";
        echo "<td>", $row['gender'], "</td>";
        echo "<td>", $row['university'], "</td>";
        echo "<td>", $row['email'], "</td>";
        echo "<td>", 0, "</td>";
        echo "</tr>";
    }
    echo "</table>";
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