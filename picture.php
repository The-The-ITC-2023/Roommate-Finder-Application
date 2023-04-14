<?php 

session_start();

if (isset($_SESSION["currentID"])) {
    $mysqli = require __DIR__ . "/database.php";

    //get current user's value in image column in images table to see if it is null or not
    //if it is null, they have to upload a picture. if it isnt, they can press the "Done" button
    $sql = "SELECT * FROM images WHERE id = {$_SESSION["currentID"]}";
    $result1 = $mysqli->query($sql);
    $result = $result1->fetch_assoc();
}
 
// If file upload form is submitted 
$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 

            $mysqli = require __DIR__ . "/database.php";

            $sql = "UPDATE images SET image = '$imgContent' WHERE id = {$_SESSION["currentID"]}";
            //$sql = "INSERT into images (image, created) VALUES ('$imgContent', NOW())";
            $stmt4 = $mysqli->stmt_init();
            if (!$stmt4->prepare($sql)) {
                die("SQL Error: " .  $mysqli->error);
            }
            $stmt4->execute();
            header("Location: index.php");

            
        }
    }
} 
 
// Display status message 
echo $statusMsg; 
?>

<html>
    <head>
    <link rel="stylesheet" href="styles/picture.css">

    </head>
    <body>
        <img src="ITCLogoOutline.png" class="logo">
        <hr>
        <div class="photo">
            <div id="title">Last Step: Add Profile Photo</div>
            <form action="picture.php" method="post" enctype="multipart/form-data" class="photo-form">
                <label id="image-header">Select Your Profile Image:</label>
                <input type="file" name="image" id="file-select">
                <img src="ImageError.png" id="profile">
                <div id="warning">*Only file types .jpg .png & .jpeg are accepted</div>
                <input type="submit" name="submit" value="Confirm Photo" id="upload-button" class="button">
            </form>
            <div class="submit-button">
                <a href="index.php"><button class="button" <?php if ($result['image'] == null) {echo "disabled";} ?> >Finish Setting Profile</button></a>
            </div>
        </div>
    </body>
</html>