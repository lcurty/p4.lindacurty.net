<!-- Display animal preview -->

<?php foreach($animals as $animal): ?>  
    
    <h1>
		<?php if(isset($animal['animal_name']) && (!$animal['animal_name'] == "")): ?>
        	<?=$animal['animal_name']?>
		<?php else: ?>
			<?=$animal['species']?>
			<?php if(isset($animal['breed']) && (!$animal['breed'] == "")): ?>
				: <?=$animal['breed']?>
			<?php endif; ?>
		<?php endif; ?>
	</h1>
    
	<p><span class="label">Animal: </span><?=$animal['species']?></p>
	<p><span class="label">Breed: </span><?=$animal['breed']?></p>
	<p><span class="label">Name: </span><?=$animal['animal_name']?></p>
	<p>
    	<span class="label">Born On: </span>
		<?php if(isset($animal['born_date']) && (!$animal['born_date'] == "0000-00-00")): ?>
			<?=$animal['born_date']?>
		<?php elseif(isset($animal['estimated_born_date']) && (!$animal['estimated_born_date'] == "0000-00-00")): ?>
			<?=$animal['estimated_born_date']?> (estimated)
		<?php endif; ?>
    </p>
	<p>
    	<span class="label">Age: </span>
		<?php if(isset($animal['age_days']) && (!$animal['age_days'] >= 365)): 
			$calc_age = $animal['age_days'] / 365; 
			$display_age = $calc_age.' months';
			echo($display_age);
		endif; ?>
        	<?php echo $display_age ?>
    </p>
	<p>
    	<span class="label">Acquired: </span>
		<?php if(isset($animal['estimated_born_date']) && (!$animal['estimated_born_date'] == "0000-00-00")): ?>
			<?=$animal['acquired_date']?>
		<?php endif; ?>
	</p>
	<p>
		<?php if(isset($animal['adult_image']) && (!$animal['adult_image'] == "")): ?>
			<img class="animal_thumb" src="/images/animals/<?=$animal['adult_image']?>" />
		<?php else: ?>
			<img class="animal_thumb" src="/images/animals/default/<?=$animal['default_image']?>" />
		<?php endif; ?>
	</p>
	<p>
		<?php if(isset($animal['baby_image']) && (!$animal['baby_image'] == "")): ?>
			<img class="animal_thumb" src="/images/animals/<?=$animal['baby_image']?>" />
		<?php else: ?>
			<img class="animal_thumb" src="/images/animals/default/<?=$animal['default_image']?>" />
		<?php endif; ?>
	</p>
	<p>
    	<span class="label">Notes: </span><br />
		<?=$animal['notes']?>
    </p>
    
    <div class="center">
        <a href="/animals/animal_edit/<?=$animal['user_animal_ID']?>" class="button">Edit Record</a>
        <a href="/users/profile" class="button">Back To Profile</a>
	</div>
    
	<hr class="clear" />
<?php endforeach; ?>


