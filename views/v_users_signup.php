<form method='POST' class="right" name='signup_form' action='/users/p_signup' enctype="multipart/form-data"> 
	<fieldset>
		<legend>Sign Up</legend>
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
			<label for="first_name" id="first_name_label">First Name*</label><br />
			<input type="text" name="first_name" id="first_name" size="38" required="required" />
        </p>
        <p>
			<label for="last_name" id="last_name_label">Last Name</label><br />
			<input type="text" name="last_name" id="last_name" size="38" />
        </p>
        <p>
			<label for="email" id="email_label">Email*</label><br />
			<input type="text" name="email" id="email" size="38" required="required" />
        </p>
        <p>
			<label for="password" id="password_label">Password*</label><br />
			<input type="password" name="password" id="password" size="38" required="required" />
        </p>
        <p>
			<label for="profile_image" id="image_label">Upload Photo</label><br />
			<input type="file" name="profile_image" id="profile_image" />
        </p>
        <p class="center">
        	<input type="submit" class="button" id="submit_btn" value="Sign Up" />
    	</p>
        <p class="note">* Required
	</fieldset>  
</form>

<!-- Include Welcome Message -->
<div class="welcome">
	<?php include 'v_users_welcome.php' ?>
	<a href="/users/login" class="button">Login</a>
</div>