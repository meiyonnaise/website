<div class = "container-fluid">
    <div class = "row">
        <div class = "col-md-4">
            <p> Profile pic </p>
            <img src="<?php echo "/demo/writable/uploads/".$id['profilePicture']; ?>" alt="profile picture">
            <p> Username: <?php echo $id['username']; ?> </p>
            <?php echo form_open_multipart(base_url()."profile/imageUpload")?>
            <div class="form-group">
                <label for="image">Update profile picture</label>
                <input type="file" name="image" id="image">
            </div>
            <button type="submit">Upload</button>
            <?php echo form_close() ?>

            <button id = "edit-profile-button"> Edit profile </button>
            <div class="form-group">
					<?php echo $id['error']; ?>
					</div>
            <div id = "edit-profile-form", style = "display: none;"> 
                <?php echo form_open(base_url().'profile/update'); ?>
                    <div class = "form-group">
                        <input type = "email" class = "form-control" placeholder = "email" name = "email">
                    </div>
                    <div class="form-group">
						<input type="text" class="form-control" placeholder="phone number"  name="phoneNumber">
					</div>
                    <div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Update</button>
					</div>
                <?php echo form_close(); ?>
        </div>
    </div>


        <div class = "col-md-8">
            <p> <b>Name: </b><?php echo $id['firstName']." ". $id['lastName']; ?></p>
            <p> <b>Sex: </b><?php echo $id['sex']; ?> </p>
            <p> <b>Email: </b><?php echo $id['email']; ?></p>
            <p> <b>Phone Number: </b><?php echo $id['phoneNumber']; ?></p>
            <p> <b>Verified: </b> <?php echo $id['emailVerifiedString']; ?> </p>

            <?php  //if email has not been verified
            if (!$id['emailVerified']) {
                echo view('verifyEmailForm');
            }
            
            ?>
        </div>
    </div>
</div>



<script>
    const editProfileButton = document.getElementById("edit-profile-button");
    const editProfileForm   = document.getElementById("edit-profile-form");

    editProfileButton.addEventListener("click", function() {
        if (editProfileForm.style.display === "none") {
            editProfileForm.style.display = "block";
        } else {
            editProfileForm.style.display ="none";
        }
    });
</script>


