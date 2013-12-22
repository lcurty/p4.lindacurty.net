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
    
    <?php if(isset($animal['is_deleted']) && ($animal['is_deleted'] == 1)): ?>
    	<p>This animal has been deleted by the user. Return to <a href="/posts/index">Farm Feed</a></p>
    <?php else: ?>
    
        <div id="animal_photos">
        
                <?php if(isset($animal['baby_image']) && (!$animal['baby_image'] == "")): ?>
                    <img class="image" src="/images/animals/<?=$animal['baby_image']?>" alt="Baby Image" />
                <?php endif; ?>
                <?php if(isset($animal['adult_image']) && (!$animal['adult_image'] == "")): ?>
                    <img class="image" src="/images/animals/<?=$animal['adult_image']?>" alt="Adult Image" />
                <?php endif; ?>
                <?php if((!isset($animal['baby_image']) || ($animal['baby_image'] == "")) && (!isset($animal['adult_image']) || ($animal['adult_image'] == ""))): ?>
                    <img class="image" src="/images/animals/default/<?=$animal['default_image']?>" alt="Default Animal Image" />
                <?php endif; ?>
        </div>
        
        <p><span class="label">Animal: </span><?=$animal['species']?></p>
        <p><span class="label">Breed: </span><?=$animal['breed']?></p>
        <p><span class="label">Name: </span><?=$animal['animal_name']?></p>
        <p>
            <span class="label">Born On: </span> 
            <?php if(isset($animal['born_date']) && ($animal['born_date'] !== "00/00/0000")): ?>
                <?=$animal['born_date']?>
            <?php elseif(isset($animal['estimated_born_date']) && ($animal['estimated_born_date'] !== "00/00/0000")): ?>
                <?=$animal['estimated_born_date']?> (estimated)
            <?php endif; ?>
        </p>
        <p>
            <span class="label">Age: </span><?=$animal['age']?> <?=$animal['age_category']?>
        </p>
        <p>
            <span class="label">Acquired: </span>
            <?php if(isset($animal['acquired_date']) && ($animal['acquired_date'] !== "00/00/0000")): ?>
                <?=$animal['acquired_date']?>
            <?php endif; ?>
        </p>
        <p>
            <span class="label">Notes: </span><br />
            <?=$animal['notes']?>
        </p>
        
        <div class="center">
			<?php if(isset($edit_rights) && $edit_rights == "Yes"): ?>
            	<a href="/animals/animal_edit/<?=$animal['user_animal_ID']?>" class="button">Edit Animal</a>
            	<a href="/animals/p_animal_delete/<?=$animal['user_animal_ID']?>" class="button">Delete Animal</a>
            <?php endif; ?>
            <a href="/users/profile/<?= $is_user ?>" class="button">Back To Profile</a>

        </div>
        
        <hr class="clear" />
        
      <?php endif; ?>
      
<?php endforeach; ?>


