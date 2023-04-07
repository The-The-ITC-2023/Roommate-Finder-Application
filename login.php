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
</head>


<body>

    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>

    <form method="post">
        <label for="email">email</label> <br />
        <input type="text" id="firstName" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"/><br />
        <br />
        <label for="password">password</label> <br />
        <input type="password" id="password" name="password" /><br />
        <br />
        <input type="submit" value="submit" />
    </form>
</body>

</html>