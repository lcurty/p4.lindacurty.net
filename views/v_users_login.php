<!-- Submitted Sign Up Form Success -->
    <?php if(isset($error) && $error == 'signed-up'): ?>
        <div class="error">
            Registration succeeded. Please log in.
        </div>
        <br>
    <?php endif; ?>

<p>
  Welcome to the The Chipper Chirpper: A place to discuss all things happy.<br />
  Now with ability to comment to posts and upload profile pictures.
</p>
    
<!-- Login Form -->
<form method='POST' name='login_form' action='/users/p_login'> 
  <fieldset>
  	<legend>Login</legend>
    
    <p>
      <label for="email" id="email_label">Email</label><br />
      <input type="text" name="email" id="email" size="38"  class="text-input" />
    </p>
    
    <p>
      <label for="password" id="password_label">Password</label><br />
      <input type="password" name="password" id="password" size="38"  class="text-input" />
    </p>

<!-- Submitted Error -->
    <?php if(isset($error) && $error == 'login-failed'): ?>
        <div class="error">
            Login failed. Please double check your email and password.
        </div>
        <br>
    <?php endif; ?>
    
    <p class="center"><input type="submit" class="button" id="submit_btn" value="Login" /></p>
  </fieldset>  
</form>

<!-- Switch to Sign up Form -->
<div id="switch-link">
  <p><a href="/users/signup">I want to join ... sign me up!</a></p>
</div>

