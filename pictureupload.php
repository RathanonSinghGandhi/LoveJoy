<?php require_once('includes/header.php');?>


    <?php require_once('includes/nav.php'); ?>

 
<?php

$email_sesh = $_SESSION['Email'];

$directory = "./uploads/";

$fileName = ($_FILES["fileToUpload"]["name"]);

$target_file = $directory . $fileName;

$uploadOk = 1;

$extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$maxFilesize = 499999;

$Errors=[];
global $con; 


// Check if file already exists
if (file_exists($target_file)) {
  $Errors []= "Please choose another image. This image has already been uploaded";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > $maxFilesize) {
  $Errors []= "This image size is too large. Please choose an image with a smaller size";
  $uploadOk = 0;
}

// Allow certain file formats
if($extension != "jpg" && 
   $extension != "png" && 
   $extension != "jpeg" && 
   $extension != "gif" && 
   $extension != "img" ) 
   {
  $Errors []=  "Image type not accepted.Accepted file types are jpg, png, jpeg, gif or img.";
  $uploadOk = 0;
}

if(!empty($Errors))
  {
    foreach($Errors as $display)
      {
         echo show_error($display);
       }
  }


if ($uploadOk != 1) {
  $Errors []= "Sorry, there was a problem uploading your file. Please try again!";
} else 
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

    echo '<div class="alert alert-success"> "Your evaluation has been submitted. Thank you!" </div>';
    $sql = "UPDATE LoveJoyDb SET fileName='$fileName' WHERE Email = '$email_sesh'";
    mysqli_query($con, $sql);

     }
 else {
$Errors []=  "Sorry, there was an error uploading your file.";
}

   
if(isset($_POST['contactMethod']))
{
    $contactMethod = $_POST['contactMethod'];
    $sql = "UPDATE LoveJoyDb SET contactMethod = '$contactMethod' WHERE Email = '$email_sesh'";
    mysqli_query($con, $sql);
}

if(isset($_POST['description']))
{
    $description = escape($_POST['description']);
    $sql = "UPDATE LoveJoyDb SET description = '$description' WHERE Email = '$email_sesh'";
    mysqli_query($con, $sql);
}

?>


<?php require_once('includes/footer.php'); ?>
