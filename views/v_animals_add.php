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
			<label for="animal_id" class="animal_form" id="animal_id_label">Animal*</label>
			<select name="animal_id" id="animal_id" >
				<?php foreach($animal_list as $animals): ?>
            		<option value="<?=$animals['species']?>"><?=$animals['species']?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
			<label for="breed" class="animal_form" id="email_label">Breed</label>
			<input type="text" name="breed" id="breed" size="38" />
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
	</fieldset>  
</form>

<!-- Switch to Sign up Form -->
<div id="switch-link">
  <p><a href="/users/login">I have an account ... log me in!</a></p>
</div>