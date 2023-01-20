<?php require_once('includes/header.php') ?>

    <!--Navigation Bar-->
    <?php require_once('includes/nav.php') ?>

    <!--Login Form-->
    <div class="container">
        <div class="row">
            <div class="col-lg-6  m-auto">
                <div class="card bg-light mt-5 py-2">
                    <div class="card-title">
                        <?php 
                            show_msg();
                         ?>
                         
                        <h2 class="text-center mt-2"> Request Evaluation Form </h2>
                    
                        <hr>
                    </div>
         
         
                            <div class="card-body">
                                
                                <form action="pictureupload.php" method="post" enctype="multipart/form-data">
                                     <input type="text" id="description" name="description" placeholder="Item Description" class="form-control py-2 mb-2" required>
                                <br>
                                <label for = "contact_method"> Preferred method of contact:</label>
                                <select id = "contactMethod" name = "contactMethod">
                                    <option value = "Email">Email</option>
                                    <option value = "Phone Number">Phone Number</option>
                                </select> 
                                <br>
                                <br>

                                Select image to upload:
                                <br>
                                <br>
                                <input type="file" name="fileToUpload" id="fileToUpload" required>
                            </div>

                                <div class = "card-footer">
                                <input class = "btn btn-dark float-end" type="submit" value="Upload Image" name="submit">
                                </form> 
                            </div>
                </div>
            </div>
        </div>
    </div>
   

<?php require_once('includes/footer.php') ?>           