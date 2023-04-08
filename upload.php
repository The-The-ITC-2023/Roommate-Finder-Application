<?php 

    if (isset($_POST['submit']) && isset($_FILES['my_image'])) {
        echo "<pre>";
        print_r($_FILES['my_image']);
        echo "</pre>";

        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];

        $mysqli = require __DIR__ . "/database.php";
        $sql = "SELECT * FROM account WHERE id = 1";
        $result1 = $mysqli->query($sql);
        $user = $result1->fetch_assoc();

        $validImageExtension = ['jpg', 'png', 'jpeg'];
        $imageExtension = explode('.', $img_name);
        $imageExtension = strtolower(end($imageExtension));
        $newImageName = $user["email"] . $img_name;


        if (!in_array($imageExtension, $validImageExtension)) {
            echo "Invalid image extension";
        } else if ($img_size > 2000000) {
                echo "too big";
        } else if ($user["email"] != "") {

            $mysqli = require __DIR__ . "/database.php";
            $sql = "SELECT * FROM account WHERE id = 1";
            $result1 = $mysqli->query($sql);
            $user = $result1->fetch_assoc();
            $oldImage = $user["picture"];

            $file_pointer = "pictures/$oldImage";
  
            // Use unlink() function to delete a file
            if (!unlink($file_pointer)) {
                echo ("$file_pointer cannot be deleted due to an error");
            }
            else {
                echo ("$file_pointer has been deleted");
            }
            
            move_uploaded_file($tmp_name, 'pictures/' . $newImageName);
            $mysqli = require __DIR__ . "/database.php";
            $sql = "UPDATE account SET picture = '$newImageName'WHERE id = 1";

            $stmt = $mysqli->stmt_init();
            if (!$stmt->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }
            $stmt->execute();
           
        } else {
            move_uploaded_file($tmp_name, 'pictures/' . $newImageName);

            $mysqli = require __DIR__ . "/database.php";
            $sql = "UPDATE account SET picture = '$newImageName'WHERE id = 1";

            $stmt = $mysqli->stmt_init();
            if (!$stmt->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }
            $stmt->execute();
            }
        }

?>

<html>
    <?php 
        $mysqli = require __DIR__ . "/database.php";
        $sql = "SELECT * FROM account WHERE id = 1";
        $result1 = $mysqli->query($sql);
        $user = $result1->fetch_assoc();

    ?>
    <body>
    </body>
    <img src = "pictures/<?php echo $user['picture']?>">
</html>