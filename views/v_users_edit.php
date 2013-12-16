<?php foreach($profiles as $profile): ?>  

    <form method='POST' name='edit_form' action='/users/p_edit' enctype="multipart/form-data"> 
        <fieldset>
            <legend>Edit Profile</legend>
            <p>
                <label for="first_name" id="first_name_label">First Name*</label>
                <input type="text" name="first_name" id="first_name" value="<?=$profile['first_name']?>" size="38" required="required" message="Please enter a first name." />
            </p>
            <p>
                <label for="last_name" id="last_name_label">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="<?=$profile['last_name']?>" size="38" />
            </p>
            <p>
                <?php if(isset($profile['profile_image']) && (!$profile['profile_image'] == "")): ?>
                    <img class="circular edit_image" src="../images/profile/<?=$profile['profile_image']?>" />
                <?php else: ?>
                    <img class="circular edit_image" src="../images/profile/stick-figure.jpg" />
                <?php endif; ?>
                <label for="profile_image" id="image_label">Upload New Photo</label><br />
                <input type="file" name="profile_image" id="profile_image" size="38" />
                <hr class="clear" />
            </p>
            <p class="center"><input type="submit" class="button" id="submit_btn" value="Update" /></p>
            <p class="note">* Required
        </fieldset>  
    </form>

<?php endforeach; ?>