<?php

$is_invalid = false;
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
            header("Location: index.php");
            exit;
        } 
    }

    $is_invalid = true;

} 

?>

<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css">
</head>


<body>

    


    <div class=login-form>
        <h1>Log in</h1>
        <div id="error" class="error">
            <?php 
            if ($is_invalid){
                echo "<p class='error'>Invalid Login</p>"; 
            }?>
        </div>
        <form id="form" method="post">
        <p class="title">Email:</p><br>
            <input type="email" name="email" class="input" placeholder=" Enter Email"><br>
            <p class="title">Password:</p><br>
            <input type="password" name="password" class="input blue-border" placeholder=" Enter Password..."><br>
            <input class="button borderless" type="submit" value="SUBMIT" />
        </form>
        <div class="spacer"></div>
    </div>
</body>

</html>