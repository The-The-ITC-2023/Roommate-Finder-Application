<?php

$is_invalid = false;
$errmsg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM account WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    #gets data from entry with matching email. if email entered does not have matching entry in table,
    #user will have nothing in it.
    $user = $result->fetch_assoc();

    #if user has stuff in it, now we check if the password they entered matches up
    if ($user) {

        if (password_verify($_POST["password"], $user["passwordHash"])) {

            session_start();

            $_SESSION["currentID"] = $user["id"];

            $query = "SELECT * FROM preference WHERE id = '{$_SESSION["currentID"]}'";
            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();
            if ($row['clean'] == "") {
                header("Location: moreInfo.php");
            } else {
                header("Location: index.php");
            }

            exit;
        } else {
            $errmsg = "Incorrect Password!";
            $is_invalid = true;
        }
    } else {
        $errmsg = "Email address doesn't exist!";
        $is_invalid = true;
    }
}

?>

<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css">
</head>


<body>

    <img src="ITCLogoOutline.png" class="logo">

    <hr> 

    <div class=login-form>
        <h1>Log in</h1>
        <div id="error" class="error">
            <?php
            if ($is_invalid) {
                echo "<p class='error'>", $errmsg, "</p>";
            } ?>
        </div>
        <form id="form" method="post">
            <p class="title">Email:</p><br>
            <input type="email" name="email" class="input blue-border" placeholder=" Enter Email"><br>
            <p class="title">Password:</p><br>
            <input type="password" name="password" class="input blue-border" placeholder=" Enter Password..."><br>
            <input class="button borderless" type="submit" value="SUBMIT" />
        </form>
        <img src="ITCLogoOutline.png" id="logo">
        <h2 class="small" style="margin-top: 1%; color: black;">Don't have an account? <a id="create" href="createAccount.php">Create One Here</a></h2>
    </div>
</body>

</html>