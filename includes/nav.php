<nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class = "container">
                <a href="index.php" class = "navbar navbar-brand"><h3>Love Joy Antique Dealer</h3></a>
                <ul class="navbar-nav">
                    
                    
                    
                    
                 
                    <?php
    
                        if(isset($_SESSION['Email']) || isset($_COOKIE['email'])) //check if login
                        {

                    ?>
                     <li class = "nav-item">
                        <a href="request.php" class = "nav-link">Request</a>
                    </li>
                        <li class = "nav-item">
                            <a href="logout.php" class = "nav-link">Logout</a>
                        </li>
                       
                    <?php    
                        }
                        else                    // when logged out
                        {
                    ?>
                        <li class = "nav-item">
                            <a href="login.php" class = "nav-link">Login</a>
                        </li>
                        <li class = "nav-item">
                            <a href="register.php" class = "nav-link">Register</a>
                        </li>
                    <?php
                        }
                        
                    ?>
                    <?php 
                        if(adminCheck())    // check if user is admin
                        {
                    ?>
                        <li class = "nav-item">
                            <a href="evallist.php" class = "nav-link">Evaluation List</a>
                        </li>
                        <?php
                        
                            
                        }    
                    
                    ?>
                    
                    
                </ul> 
            
            </div>
        </nav>


        

