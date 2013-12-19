<hr class="clear" />

<h1>Follow Other Farmers</h1>

<?php foreach($users as $user): ?>

	<div class="users_users">
    
		<?php if(isset($user['profile_image']) && (!$user['profile_image'] == "")): ?>
        	<img class="image users" src="/images/profile/<?=$user['profile_image']?>" />
        <?php else: ?>
        	<img class="image users" src="/images/profile/stick-figure.jpg" />
        <?php endif; ?>
        
        <br />
		
		<?=$user['first_name']?> <?=$user['last_name']?>
        
        <br />
        
		<?php if(isset($connections[$user['user_id']])): ?>
        	<a class='button follow_button' href='/posts/unfollow/<?=$user['user_id']?>'>Remove Follow</a>
        <?php else: ?>
        	<a class='button follow_button' href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
        <?php endif; ?>
        
    </div>
    
<?php endforeach ?>
