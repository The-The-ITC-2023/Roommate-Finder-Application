<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    //$name = $_POST["firstName"];
    $stmt = sprintf("SELECT *  FROM account WHERE firstName='%s'", $_POST["firstName"]);
    //mysqli_stmt_bind_param($stmt, 's', $name);

    $result = $mysqli->query($stmt);
    
    // $user = $result->fetch_assoc();

    //init header row
    echo "<table border='1px solid black'>";
    echo "<tr>";
    echo "<th>Name</th><th>Email</th><th>Picture</th>";
    echo "</tr>";

    //populate table
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>",$row['firstName']," ", $row['lastName'],"</td>";
        echo "<td>",$row['email'],"</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<html>

<head>
    <title>Search</title>
    <link rel="stylesheet" href="styles/search.css" />
</head>

<body>
    <form method="post">
        <label for="firstName">First Name:</label> <br />
        <input type="text" id="firstName" name="firstName" /><br />
        <br />
        <input type="submit" value="submit" />
    </form>
</body>

</html>