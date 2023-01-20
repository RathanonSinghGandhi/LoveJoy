<?php require_once('includes/header.php');?>

    <?php require_once('includes/nav.php'); ?>

<?php

    if (user_loggedin()){
    
        $query = $con->query("SELECT * FROM LoveJoyDb ORDER BY timeStamp DESC");


    if($query->num_rows > 0){

        while($row = $query->fetch_assoc()){

            $imageURL = 'uploads/'.$row["fileName"];

?>

        <img src="<?php echo $imageURL; ?>" alt=""   width = "300" height="200" />
        <br>
        <br>    

        <p>Uploaded by <?=$row['UserName']?>, Contact method: <?=$row['contactMethod']?> </p>

        <p>Item Description: <br><?=$row['description']?></p>

   

<?php
            }

        }
        
        else{
?>

    <p>No image(s) sent for evaluation</p>

<?php 
            
        }

    }

    else

    {
    
        header("location:login.php");

    }


 

?>

 

 

<?php require_once('includes/footer.php'); ?>