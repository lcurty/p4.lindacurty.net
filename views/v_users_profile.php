<!-- Display user profile -->
<?php foreach($profiles as $profile): ?>

    <article class="profile">
    
		<?php if(isset($profile['profile_image']) && (!$profile['profile_image'] == "")): ?>
        	<img class="circular" src="../images/profile/<?=$profile['profile_image']?>" />
        <?php else: ?>
        	<img class="circular" src="../images/profile/stick-figure.jpg" />
        <?php endif; ?>
        
        <p class="user_name"><?=$profile['first_name']?> <?=$profile['last_name']?></p>
    
    	<a href='/animals/add'>Add a New Animal</a>
    </article>

<?php endforeach; ?>
