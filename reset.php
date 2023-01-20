<?php require_once('includes/header.php') ?>

        <div class = "container">
            <div class = "row">
                <div class = "col-lg-6 m-auto">
                    <div class ="card bg-light mt-5 py-2">
                        <div class="card-title">
                            <h2 class = "text-center mt-2"> Enter Your New Password </h2>
                            <hr>
                            <?php 
                                pass_reset();
                                show_msg();
                            ?>
                        </div>
                        <div class = "card-body">
                            <form method="POST">
                            <input type="password" name="reset-pass" placeholder="Password" class="form-control py-2 mb-2">
                            <input type="password" name="reset-c-pass" placeholder="Confirm Password" class="form-control py-2 mb-2">
                            <input type="hidden" name = "token" value = "<?php echo Token_Generator(); ?>">
                        </div>
                        <div class="card-footer">
                        <a href = "login.php" class="btn btn-danger float-end">Cancel</a>
                        <button class="btn btn-success float-start">Send Password</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once('includes/footer.php') ?>