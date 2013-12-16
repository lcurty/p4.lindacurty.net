<?php foreach($animals as $animal): ?>  

    <form method='POST' name='edit_form' action='/animals/p_animal_edit' enctype="multipart/form-data"> 
        <fieldset>
            <legend>Edit Profile</legend>
        <p>
			<label for="animal_id" class="animal_form" id="animal_id_label">Animal*</label>
			<select name="animal_id" id="animal_id" >
				<?php foreach($animal_list as $animals): ?>
            		<option value="<?=$animals['animal_ID']?>"><?=$animals['species']?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
			<label for="breed" class="animal_form" id="email_label">Breed</label>
			<input type="text" name="breed" id="breed" value=<?=$animals['breed']?> size="38" />
        </p>
        <p>
			<label for="animal_name" class="animal_form" id="animal_name_label">Name</label>
			<input type="text" name="animal_name" id="animal_name" size="38" />
        </p>
        <p>
			<label for="born_date" class="animal_form" id="born_date_label">Born On</label>
			<input type="text" name="born_date" id="born_date" size="38" />
        </p>
        <p>
			<label for="age" class="animal_form" id="age_label">Approximate Age</label>
			<input type="text" name="age" id="age" size="15" />
			<select name="age_category" id="age_category">
            	<option value="days">Days</option>
            	<option value="weeks">Weeks</option>
            	<option value="months">Months</option>
            	<option value="years">Years</option>                
            </select>
            <span class="note">(If born date not entered.)</span>
        </p>
        <p>
			<label for="acquired_date" class="animal_form" id="acquired_date_label">Acquired</label>
			<input type="text" name="acquired_date" id="acquired_date" size="38" />            
        </p>
        <p>
			<label for="baby_image" class="animal_form" id="baby_image_label">Baby Photo</label>
			<input type="file" name="baby_image" id="baby_image" size="38" />
        </p>
        <p>
			<label for="adult_image" class="animal_form" id="adult_image_label">Adult Photo</label>
			<input type="file" name="adult_image" id="adult_image" size="38" />
        </p>
        <p>
			<label for="notes" class="animal_form" id="notes_label">Notes</label>
			<textarea name="notes" id="notes" cols="65" ></textarea>
        </p>
        <p class="center"><input type="submit" class="button" id="submit_btn" value="Sign Up" /></p>
		<p class="note">* Required
            
            
            
            
            
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