<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT email FROM account WHERE firstName = '%s'", $_POST["firstName"]);

    if ($stmt = $mysqli->prepare($sql)) {
        //echo "Hi ", $_POST["firstName"], "! Your email is: <br />";
        echo "Your results: <br />";

        //execute statement /
        $stmt->execute();

        // bind result variables /
        $stmt->bind_result($email);
        
        // fetch values /
        while ($stmt->fetch()) {
            echo $email;
            echo "<br />";
        }

        /* close statement*/
        $stmt->close();
    }

    
/*
    session_start();

    $_SESSION["currentID"] = $user["id"];

    header("Location: index.php");
    exit; 
*/
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