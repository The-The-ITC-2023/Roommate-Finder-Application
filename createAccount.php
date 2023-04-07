<?php
$is_invalid = false;
$errmsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if (empty($fname)) {
        $fnameErr = "Please enter your first name";
        $errmsg = $fnameErr;
        $is_invalid = true;
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
        $fnameErr = "First name must have only letters and white space";
        $errmsg = $fnameErr;
        $is_invalid = true;
    } else if (empty($lname)) {
        $lnameErr = "Please enter your last name";
        $errmsg = $lnameErr;
        $is_invalid = true;
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
        $lnameErr = "Last name must have only letters and white space";
        $errmsg = $lnameErr;
        $is_invalid = true;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $errmsg = $emailErr;
        $is_invalid = true;
    } else if ($password < 8) {
        $passwordErr = "Password must be at least 8 characters long";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $passwordErr = "Password must contain at least 1 Number";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } elseif (!preg_match("#[A-Z]+#", $password)) {
        $passwordErr = "Password must contain at least 1 Capital Letter";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } elseif (!preg_match("#[a-z]+#", $password)) {
        $passwordErr = "Password must contain at least 1 Lowercase Letter";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } else if ($password != $cpassword) {
        $passwordErr = "Passwords do not match";
        $errmsg = $passwordErr;
        $is_invalid = true;
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

<html>

<head>
    <title>Roommate Application</title>
    <link rel="stylesheet" href="styles/createAccount.css">
</head>

<body>
    <a href="home.html"><img src="ITCLogoOutline.png" id="logo"></a>
    <div class=login-form>
        <h1>Create Account</h1>
        <div class="error">
            <?php
                if ($is_invalid){
                    echo "<p class='error'>",$errmsg,"</p>";
                }?>
        </div>
        <form id="form" method="post">
            <p class="title">Name:</p><br>
            <input type="text" name="fname" class="input" placeholder=" First Name"><br>
            <input type="text" name="lname" class="input" placeholder=" Last Name"><br>
            <p class="title">Email:</p><br>
            <input type="email" name="email" class="input blue-border" placeholder=" Ex: JohnDoe@gmail.com"><br>
            <p class="title">Password:</p><br>
            <input type="password" name="password" class="input red-border" placeholder=" Enter Password..."><br>
            <p class="title">Confirm Password:</p><br>
            <input type="password" name="cpassword" class="input red-border" placeholder=" Confirm Password..."><br>
            <p class="title small">*At least 8 characters, 1 uppercase, 1 number</p><br>
            <input type="submit" name="submit" value="CREATE ACCOUNT" id="submit" onclick="changeP()" class = "button borderless">
            <h2>Already have an account?</h2>
            <a id="log-in" href="login.php" class = "button">LOG IN</a>
        </form>
    </div>
</body>

</html>