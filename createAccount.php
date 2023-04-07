<html>

<head>
    <title>Roommate Application</title>
    <link rel="stylesheet" href="styles/createAccount.css">
</head>

<body>
    <img src="ITCLogoOutline.png" id="logo">
    <form method="post">
        First Name:<br>
        <input type="text" name="fname"><br>
        Last Name:<br>
        <input type="text" name="lname"><br>
        Email:<br>
        <input type="email" name="email"><br>
        Password:<br>
        <input type="password" name="password"><br>
        Confirm Password:<br>
        <input type="password" name="cpassword"><br>
        <input type="submit" name="submit" value="Submit" id="submit" onclick="changeP()">
    </form>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if (empty($fname)) {
        $fnameErr = "Please enter your first name";
        echo "{$fnameErr}";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
        $fnameErr = "First name must have only letters and white space";
        echo "{$fnameErr}";
    } else if (empty($lname)) {
        $lnameErr = "Please enter your last name";
        echo "{$lnameErr}";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
        $lnameErr = "Last name must have only letters and white space";
        echo "{$lnameErr}";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        echo "{$emailErr}";
    } else if ($password < 8) {
        $passwordErr = "Password must be at least 8 characters long";
        echo "{$passwordErr}";
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $passwordErr = "Password must contain at least 1 Number";
        echo "{$passwordErr}";
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $passwordErr = "Password must contain at least 1 Capital Letter";
        echo "{$passwordErr}";
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $passwordErr = "Password must contain at least 1 Lowercase Letter";
        echo "{$passwordErr}";
    } else if ($password != $cpassword) {
        $passwordErr = "Passwords do not match";
        echo "{$passwordErr}";
    } else {
        $mysqli = require __DIR__ . "/database.php";

        $sql = "INSERT INTO account(firstName, lastName, email, passwordHash)
        VALUES(?, ?, ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL Error: " .  $mysqli->error);
        }

        $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $stmt->bind_param("ssss", $_POST["fname"], $_POST["lname"], $_POST["email"], $passwordHash);
        $stmt->execute();

        header("Location: home.html");
    }
}
?>