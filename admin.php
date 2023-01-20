<?php require_once('includes/header.php') ?>
    
        <!--Navigation bar-->
        <?php require_once('includes/nav.php') ?>

        <!-- Admin Main Page-->
        <div class = "container">
            <div class = "row">
                <div class = "col">
                    <div class ="card bg-light mt-5 py-2">
                        <h3 class = text-center> 
                            <?php

                                if(user_loggedin())
                                {
                                    echo 'You are logged in';
                                }
                
                                else
                                {
                                    redirecting('login.php');
                                }
                            ?>                            
                        </h3>
                        <div class="card-footer text-center">
                        <button onclick="location.href='request.php'" type= "button"> Request </button>
                        </div>
                   
                    </div>
                    
                </div>
            </div>
        </div>
    
<?php require_once('includes/footer.php') ?>