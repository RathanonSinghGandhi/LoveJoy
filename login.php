<?php require_once('includes/header.php') ?>

    <!--Navigation Bar-->
    <?php require_once('includes/nav.php') ?>

    <!--Login Form-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="container">
        <div class="row">
            <div class="col-lg-6  m-auto">
                <div class="card bg-light mt-5 py-2">
                    <div class="card-title">
                        <?php 
                            show_msg();
                         ?>
                        <h2 class="text-center mt-2"> Login Form </h2>
                        <hr>
                    </div>
                    <div class="card-body">
                       <form action = "validatecaptcha.php" method="POST">
                            <input type="email" name="Email" placeholder="User Email" class="form-control py-2 mb-2" >
                            <input type="password" name="Pass" placeholder=" Password " class="form-control py-2 mb-2" >
                            <div class = "g-recaptcha" data-sitekey="6Le8c10jAAAAABalA6nWure3ogtTFLIkNywZ6yLf"></div>
                            <button class="btn btn-dark float-end"> Login </button>
                          
                    </div>
                    
                    <div class="card-footer">
                        <input type="checkbox" name="remember"> <span> Remember Me </span> 
                        <a href="recover.php" class="float-end"> Forget Password </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once('includes/footer.php') ?>           