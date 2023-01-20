<?php 

    // Clean String Values
    function clean ($string)
    {
        return htmlentities($string);
    }


    //redirection
    function redirecting($location)
    {
        return header("location:{$location}");
    }

    // Set session Message
    

    function set_msg($msg)
   {
       if(!empty($msg))
       {
           $_SESSION['Message'] = $msg;
       }
       else
       {
           $msg="";
       }
   }

    //Display message function

    function show_msg()
   {
       if(isset($_SESSION['Message']))
       {
            echo $_SESSION['Message'];
            unset($_SESSION['Message']);
       }
   }



    // Generate Token

    function Token_Generator()
    {
        $token = $_SESSION['token']=md5(uniqid(mt_rand(),true));
        return $token;
    }


    // Send email function

    function send_email($email, $sub, $msg, $header) 
    {
       return mail($email, $sub, $msg, $header);
    }




    //***********User Validation Functions*************/

    // Error function
    function show_error($Error)
    {
        return '<div class="alert alert-danger">'.$Error.'</div>';
    }
 

    // User Validation Function
    function validate_user()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
           $FirstName = clean($_POST['FirstName']);
           $LastName = clean($_POST['LastName']);
           $UserName = clean($_POST['UserName']);
           $Email = clean($_POST['Email']);
           $Phone = clean($_POST['Phone']);
           $Pass = clean($_POST['pass']);
           $CPass = clean($_POST['cpass']);

           $Errors = [];
           $Max = 20;
           $Min = 03;


           // Check first name characters
           if(strlen($FirstName)<$Min)
           {
               $Errors[] = "First Name Cannot be less than {$Min} Characters ";

           }

           if(strlen($FirstName)>$Max)
           {
               $Errors[] = "First Name Cannot be more than {$Max} Characters ";
           }

           // Check last name characters

           if(strlen($LastName)< $Min)
           {
               $Errors[] = "Last Name Cannot be less than {$Min } Characters ";
           }

           if(strlen($LastName)>$Max)
           {
               $Errors[] = "Last Name Cannot be more than {$Max} Characters ";
           }

           // Check user characters

           if(!preg_match("/^[a-zA-Z,0-9]*$/", $UserName))
           {
               $Errors[] = "User Name can only contain lowercase letters, uppercase letters and numbers. ";

           }
           // Phone number
           if(strlen($Phone) > 15)
           {
               $Errors[] = " Please enter correct phone number.";
           }
           
           // Check password strength
           
            $uppercase = preg_match('@[A-Z]@', $Pass);
            $lowercase = preg_match('@[a-z]@', $Pass);
            $number    = preg_match('@[0-9]@', $Pass);
            $specialChars = preg_match('@[^\w]@', $Pass);
            
            if(strlen($Pass) < 8){
                $Errors[] = "Password length too short. Password should be at least 8 characters";
            }
            
            if(!$uppercase) {
                $Errors[] = "Password should contain atleast one upper case letter";
            }
            
            if(!$lowercase) {
                $Errors[] = "Password should contain atleast one lower case letter";
            } 
            if(!$specialChars) {
                $Errors[] = "Password should contain atleast one special character";
            } 
        
           // Check email if exists

           if(exists_email($Email))
           {
            $Errors[] = " Email already exists ";

           }

           // check if username is taken

           if(exists_username($UserName))
           {
            $Errors[] = " Username is taken";
           }
           
           
           // Check if passwords match

           if($Pass!=$CPass)
           {
            $Errors[] = " Passwords do not match. Please try again!";
           }

           if(!empty($Errors))
           {
               foreach($Errors as $Error)
               {
                   echo show_error($Error);
               }
           }
           else {

               if(user_register($FirstName, $LastName, $UserName, $Email,$Phone, $Pass))
               {
                   set_msg('<p class = "bg-success text-center lead"> You have registered. Check your email for activation link</p>');
                   redirecting("index.php"); 
               }
               else {
                   {
                    set_msg('<p class = "bg-danger text-center lead"> Your account has not been registered. Try again! </p>');
                    redirecting("index.php"); 
                   }
               }
           }


        }
    }

    // Existing Emails

    function exists_email($email)
    {
        $sql = " select * from LoveJoyDb where Email = '$email'";
        $result = Query($sql);
        if(fetch_data($result))
        {
            return true;
        }
        else {
            return false;
        }
    }

    // Existing Username

    function exists_username($user)
    {
        $sql = " select * from LoveJoyDb where UserName = '$user'";
        $result = Query($sql);
        if(fetch_data($result))
        {
            return true;
        }
        else {
            return false;
        }
    }

    // User registration

    function user_register($FName, $LName, $UName, $Email,$Phone, $Pass)
    {
        $FirstName = escape($FName);
        $LastName = escape($LName);
        $UserName = escape($UName);
        $Email = escape($Email);
        $Phone = escape($Phone);
        $Pass = escape($Pass);

        if (exists_email($Email)) 
        {
            return true;
        }
        else if (exists_username($UserName))
        {
           return true;
        }
        else 
        {
            $Password = md5($Pass);
            $Validation_code = md5((int)$UserName + (int)microtime());   

            $sql =  "insert into LoveJoyDb (FirstName, LastName, UserName, Email,Phone, Password, Validation_Code, Active, description, fileName, contactMethod ) values ('$FirstName', '$LastName', '$UserName', '$Email', $Phone, '$Password', '$Validation_code', '0', ' ', ' ', ' ')";

            $result = Query($sql);
            confirm($result);

            $subject = "Activate your account";
            $msg = "Please click the link below to activate your account https://lovejoyproject.000webhostapp.com/activate.php?Email=$Email&Code=$Validation_code";


            $header = "From No-Reply admin@lovejoy.com";

        
            send_email($Email, $subject, $msg, $header);
            return true;
        }
    }


    // Check if admin
    
    function adminCheck(){
        $adminEmail = 'lovejoyowner@gmail.com';
        
        if(user_loggedin() && $_SESSION['Email'] == $adminEmail){
                
                return true;
        }
        else
        {
            return false;        
        
        }
    }

    // Activation 

    function activation()
    {
        if($_SERVER['REQUEST_METHOD']=="GET")
        {
             $Email = $_GET['Email'];
             $Code = $_GET['Code'];

             $sql = "select * from LoveJoyDb where Email = '$Email' AND Validation_Code='$Code'";
             $result = Query($sql);
             confirm($result);


             if(fetch_data($result))
             {
                 $sqlquery = "update LoveJoyDb set Active = '1', Validation_Code='0' where Email='$Email' AND Validation_Code = 
                 '$Code'";
                 $result2 = Query($sqlquery);
                 confirm($result2);
                 set_msg('<p class = "bg-success text-center lead"> Your Account has successfully activated </p>');

                 redirecting('login.php');
             }
             else
             {
                echo '<p class = "bg-danger text-center lead"> Your Account has failed to activate </p>';
             }

        }
    }



// Login Function

function logging_in($Email, $Pass, $Rememberme)
{
    $query = "select * from LoveJoyDb where Email='$Email' and Active = '1'";
    $result = Query($query);
    
    if($row=fetch_data($result))
    {
        $db_pass = $row['Password'];
        if(md5($Pass)==$db_pass)
        {
            if($Rememberme == true)
            {
                setcookie('email', $Email, time() + 86400);
            }
            $_SESSION['Email'] = $Email;
            return true;
        }
        else
        {
            return false;
        }
    }

}


// Logged in

function user_loggedin()
{
    if(isset($_SESSION['Email']) || isset($_COOKIE['email']))
    {
        return true;
    }
    else
    {
        return false;

    }
}


//////////////Recover password////////////
function get_pass()
{
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token'])
        {
           global $con;
           $Email = mysqli_real_escape_string($con,$_POST['Email']);
           
           

           if(exists_email($Email))
           {
               
                $code = md5((int)$Email+(int)microtime());
                setcookie('temp_code',$code, time()+300);

                $sql = "update LoveJoyDb set Validation_Code='$code' where Email='$Email'";
                Query($sql);

                $Subject = "Reset Your Password";
                
                $Message = "Use the link below https://lovejoyproject.000webhostapp.com/reset.php?Email=$Email&&Code=$code"; 
                $header = "noreply@lovejoy.com";

                if(send_email($Email,$Subject,$Message,$header))
                {
                    echo '<div class="alert alert-success"> Please check your email </div>';
                }
                else
                {
                    echo show_error("There was a problem sending you an email. Please try again!");
                }
           }
           else
           {
                echo show_error("This Email is not registered");
           }
        }
        else{
            redirecting("index.php");
        }
    }
}





/////////////////// Reset Password ///////////


function pass_reset()
{
    if(isset($_COOKIE['temp_code']))
    {
         if(isset($_GET['Email']) && isset($_GET['Code']))
         {
             if(isset($_SESSION['token']) && isset($_POST['token']))
             {
                 if($_SESSION['token'] == $_POST['token'])
                 {
                      if($_POST['reset-pass'] === $_POST['reset-c-pass'])
                      {

                             $Password = md5($_POST['reset-pass']);
                             $query2 = "update LoveJoyDb set Password='".$Password."', Validation_Code=0 where Email='".$_GET['Email']."'";
                             $result = Query($query2);

                             if($result)
                             {
                                 set_msg('<div class="alert alert-success"> Your Password Has changed. </div>');
                                 redirecting("login.php");
                             }
                             else
                             {
                                 set_msg('<div class="alert alert-danger"> Please try again! </div>');
                             }


                      }
                      else
                      {
                         set_msg('<div class="alert alert-danger"> Password does not match </div>');
                      }
                 }

             }

         }
         else
         {
             set_msg('<div class="alert alert-danger"> Your Code or Your Email does Not match. Please try again! </div>');
         }
    }
    else
    {
        set_msg('<div class="alert alert-danger"> Your Time Period Has Expired, please try again! </div>');
    }
}

 

    
?>