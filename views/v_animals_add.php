<form method='POST' name='new_animal_form' action='/animals/p_add'enctype="multipart/form-data"> 
	<fieldset>
        <legend>Create New Animal</legend>
		<?php if(isset($error) && $error == 'blank-fields'): ?>
            <div class='error'>
                Signup Failed. All fields are required.
            </div>
        <?php endif; ?>
    
        <?php if(isset($error) && $error == 'email-exists'): ?>
            <div class='error'>
                There is already an account associated with this email. 
                <a href="/users/login">Login</a>
            </div>
        <?php endif; ?>  	
        <p>
			<label for="animal_id" id="animal_id_label">Animal*</label><br />
			Select Box<input type="text" name="animal_id" id="animal_id" size="38" />
        </p>
        <p>
			<label for="breed" id="email_label">Breed</label><br />
			<input type="text" name="breed" id="breed" size="38" />
        </p>
        <p>
			<label for="animal_name" id="animal_name_label">Name</label><br />
			<input type="text" name="animal_name" id="animal_name" size="38" />
        </p>
        <p>
			<label for="born_date" id="born_date_label">Born On</label><br />
			<input type="text" name="born_date" id="born_date" size="38" />
        </p>
        <p>
			<label for="age" id="age_label">Approximate Age</label><br />
			<input type="text" name="age" id="age" size="38" />
			Select Box
        </p>
        <p>
			<label for="acquired_date" id="acquired_date_label">Acquired</label><br />
			<input type="text" name="acquired_date" id="acquired_date" size="38" />
        </p>
        <p>
			<label for="baby_image" id="baby_image_label">Baby Photo</label><br />
			<input type="file" name="baby_image" id="baby_image" size="38" />
        </p>
        <p>
			<label for="adult_image" id="adult_image_label">Adult Photo</label><br />
			<input type="file" name="adult_image" id="adult_image" size="38" />
        </p>
        <p>
			<label for="notes" id="notes_label">Notes</label><br />
			<input type="text" name="notes" id="notes" size="38" />
        </p>
        <p class="center"><input type="submit" class="button" id="submit_btn" value="Sign Up" /></p>
		<p class="note">* Required
	</fieldset>  
</form>

<!-- Switch to Sign up Form -->
<div id="switch-link">
  <p><a href="/users/login">I have an account ... log me in!</a></p>
</div>