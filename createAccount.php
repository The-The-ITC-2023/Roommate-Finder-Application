<?php
$is_invalid = false;
$errmsg = "";

$fname = $lname = $email = $password = $cpassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["fname"])) {
        $fnameErr = "Please enter your first name";
        $errmsg = $fnameErr;
        $is_invalid = true;
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["fname"])) {
        $fnameErr = "First name must have only letters and white space";
        $errmsg = $fnameErr;
        $is_invalid = true;
    } else {
        $fname = $_POST["fname"];
    }
    if (empty($_POST["lname"])) {
        $lnameErr = "Please enter your last name";
        $errmsg = $lnameErr;
        $is_invalid = true;
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["lname"])) {
        $lnameErr = "Last name must have only letters and white space";
        $errmsg = $lnameErr;
        $is_invalid = true;
    } else {
        $lname = $_POST["lname"];
    }
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $errmsg = $emailErr;
        $is_invalid = true;
    } else {
        $email = $_POST["email"];
    }
    if (strlen($_POST["password"]) < 8) {
        $passwordErr = "Password must be at least 8 characters long";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } elseif (!preg_match("#[0-9]+#", $_POST["password"])) {
        $passwordErr = "Password must contain at least 1 Number";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } elseif (!preg_match("#[A-Z]+#", $_POST["password"])) {
        $passwordErr = "Password must contain at least 1 Capital Letter";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } elseif (!preg_match("#[a-z]+#", $_POST["password"])) {
        $passwordErr = "Password must contain at least 1 Lowercase Letter";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } else if ($_POST["password"] != $_POST["cpassword"]) {
        $passwordErr = "Passwords do not match";
        $errmsg = $passwordErr;
        $is_invalid = true;
    } else {
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
    }
    if(!$is_invalid) {
        
        $mysqli = require __DIR__ . "/database.php";

        //check if email exists already
        $query = "SELECT * FROM account WHERE email = '" . $email . "'";

        $result = $mysqli->query($query);

        if ($result->fetch_assoc()) {
            //email already exists
            $is_invalid = true;
            $errmsg = "Email address taken!";
        } else {
            //add new entry to account
            $sql = "INSERT INTO account(firstName, lastName, email, passwordHash)
            VALUES(?, ?, ?, ?)";

            $stmt2 = $mysqli->stmt_init();

            if (!$stmt2->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }

            $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $stmt2->bind_param("ssss", $_POST["fname"], $_POST["lname"], $_POST["email"], $passwordHash);
            $stmt2->execute();

            // gets created user's id
            $stmt3 = sprintf("SELECT *  FROM account WHERE email='%s'", $email);
            $result = $mysqli->query($stmt3);
            $user = $result->fetch_assoc();
            $userID = $user['id'];
            // end

            $sql = "INSERT INTO preference(acct_id) VALUES(?)";
            $stmt4 = $mysqli->stmt_init();
            if (!$stmt4->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }
            $stmt4->bind_param("i", $userID);
            $stmt4->execute();

            $sql = "INSERT INTO preferencevalues(acct_id) VALUES(?)";
            $stmt5 = $mysqli->stmt_init();
            if (!$stmt5->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }
            $stmt5->bind_param("i", $userID);
            $stmt5->execute();

            $sql = "INSERT INTO images(acct_id) VALUES(?)";
            $stmt6 = $mysqli->stmt_init();
            if (!$stmt6->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }
            $stmt6->bind_param("i", $userID);
            $stmt6->execute();


            header("Location: accountCreated.html");
        }
    }
}
?>

<html>

<head>
    <title>Roommate Application</title>
    <link rel="stylesheet" href="styles/createAccount.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
</head>

<body>
    <img src="ITCLogoOutline.png" id="logo">
    <hr>
    <div class=login-form>
        <h1>Create Account</h1>
        <div class="error">
            <?php
            if ($is_invalid) {
                echo "<p class='error'>", $errmsg, "</p>";
            } ?>
        </div>
        <form id="form" method="post">
            <p class="title">Name:</p><br>
            <input type="text" name="fname" class="input blue-border" placeholder=" First Name" value="<?php echo $fname; ?>"><br>
            <input type="text" name="lname" class="input blue-border" placeholder=" Last Name" value="<?php echo $lname; ?>"><br>
            <p class="title">Email:</p><br>
            <input type="email" name="email" class="input blue-border" placeholder=" Ex: JohnDoe@gmail.com" value="<?php echo $email; ?>"><br>
            <p class="title">Password:</p><br>
            <input type="password" name="password" class="input blue-border" placeholder=" Enter Password..."><br>
            <p class="title">Confirm Password:</p><br>
            <input type="password" name="cpassword" class="input blue-border" placeholder=" Confirm Password..."><br>
            <p class="title small">*At least 8 characters with 1 uppercase, 1 number, and 1 lowercase</p><br>
            <input type="submit" name="submit" value="CREATE ACCOUNT" id="submit" onclick="changeP()" class="button borderless">
            <h2 class="small" style="margin-top: 1%; color: black;">Already have an account? <a id="log-in" href="login.php">Log in</a></h2>
        </form>
    </div>
</body>

</html>