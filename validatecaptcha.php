<?php require_once('includes/header.php') ?>

     <!--Navigation Bar-->
    <?php require_once('includes/nav.php') ?>


<?php
$Errors = [];

if(($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['g-recaptcha-response']))){
     $UserEmail = clean($_POST['Email']);
     $UserPass = clean($_POST['Pass']);
     $Rememberme = isset($_POST['remember']);
       
     $secret = '6Le8c10jAAAAAAsczulDDIif8XeRNanns2-M-suS';
     $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
     $responseData = json_decode($verifyResponse);
    
    if(empty($UserEmail))
        {
            $Errors[] = " Enter Your Email";
        }

        if(empty($UserPass))
        {
            $Errors[] = "  Enter your Password! ";
        }
            
           

        if(!empty($Errors))
        {
            foreach ($Errors as $Error)
            {
                echo show_error($Error);                
            
            }
        }
        
          if($responseData->success==false){
            
            echo show_error("Please tick box");
        }
        
        else
            {
               
                if(logging_in($UserEmail, $UserPass,$Rememberme))
                
                {
                    
                    redirecting("admin.php");
              
                }
                else
                {
              
                    echo show_error("Your email or password is incorrect");
                }

            }
    
   }
    
?>
<?php require_once('includes/footer.php') ?>


