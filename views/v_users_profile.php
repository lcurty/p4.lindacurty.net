<!-- Display user profile -->
<div id="profile">

	<?php foreach($profiles as $profile): ?>  
    
		<?php if(isset($profile['profile_image']) && (!$profile['profile_image'] == "")): ?>
        	<img class="circular profile_image" src="../images/profile/<?=$profile['profile_image']?>" />
        <?php else: ?>
        	<img class="circular profile_image" src="../images/profile/stick-figure.jpg" />
        <?php endif; ?>
        
        <h1><?=$profile['first_name']?> <?=$profile['last_name']?>'s Farm</h1>
        
        <h2>Critter Count</h2>
    
	<?php endforeach; ?>

</div>

<hr class="clear" />

<a href='/animals/add' class="button right">Add a New Animal</a>

<hr class="clear" />

<div id="search_farm">
	Filter Inventory
</div>

<div id="display_farm">
	<!-- Display Table of Animals -->
    <table id="animal_table">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>Name</th>
                <th>Animal</th>
                <th>Breed</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($inventory as $animal): ?>  
                <tr>
                	<td>
						<a href="/animals/preview/<?=$animal['user_animal_id']?>" class="button"><img src="../images/magnifying-glass.png" alt="View Animal" /></a>
                    </td>
                    <td>
                        <?php if(isset($animal['adult_image']) && (!$animal['adult_image'] == "")): ?>
                            <img class="animal_thumb" src="../images/animals/<?=$animal['adult_image']?>" />
                        <?php elseif(isset($animal['baby_image']) && (!$animal['baby_image'] == "")): ?>
                            <img class="animal_thumb" src="../images/animals/<?=$animal['baby_image']?>" />
                        <?php else: ?>
                            <img class="animal_thumb" src="../images/animals/default/<?=$animal['default_image']?>" />
                        <?php endif; ?>
                    </td>
                    <td><?=$animal['animal_name']?></td>
                    <td><?=$animal['species']?></td>
                    <td><?=$animal['breed']?></td>
                    <td><?=$animal['age_days']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
