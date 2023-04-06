<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM account WHERE firstName = '%s'", $_POST["firstName"]);

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    session_start();

    $_SESSION["currentID"] = $user["id"];

    header("Location: index.php");
    exit;
}

?>

<html>

<head>
    <title>Search</title>
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