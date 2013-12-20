<!-- Display user profile -->
<div id="profile">

	<?php foreach($profiles as $profile): ?>  
        
		<?php if(isset($profile['profile_image']) && (!$profile['profile_image'] == "")): ?>
        	<img class="image profile_image" src="../images/profile/<?=$profile['profile_image']?>" />
        <?php else: ?>
        	<img class="image profile_image" src="../images/profile/stick-figure.jpg" />
        <?php endif; ?>
        
        <div>
        	
            <h1><?=$profile['first_name']?> <?=$profile['last_name']?>'s Farm</h1>
        
            <h2>Critter Count</h2>
            
            <?php foreach($categories as $category): ?>  
                <div class="category">
                    <img class="image animal_thumb" src="/images/animals/default/<?=$category['default_image']?>" />
                    <span class="bold"><?=$category['species']?>s</span>: <?=$category['animal_count']?>
                </div>
            <?php endforeach; ?>
            
		</div>
    
	<?php endforeach; ?>

</div>

<hr class="clear" />

<a href='/animals/add' class="button right">Add a New Animal</a>

<hr class="clear" />

<div id="search_farm">
	<h2>Filter Animal List</h2>
    <form name="animal_filter">
        <fieldset>
            <p><label id='animal'>Animal</label><br><input type='text' id="search" name='animal'></p>
            <p><label id='breed'>Breed</label><br><input type='text' name='breed'></p>
            <p><label id='name'>Name</label><br><input type='text' name='name'></p>
            <!--<p><label id='start_date'>Date of First Payment</label><br><input type='text' name='start_date' id="datepicker"></p>-->
            <p>Add Clear Form Button?</p>
        </fieldset>
    </form>

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
                            <img class="image animal_thumb" src="../images/animals/<?=$animal['adult_image']?>" />
                        <?php elseif(isset($animal['baby_image']) && (!$animal['baby_image'] == "")): ?>
                            <img class="image animal_thumb" src="../images/animals/<?=$animal['baby_image']?>" />
                        <?php else: ?>
                            <img class="image animal_thumb" src="../images/animals/default/<?=$animal['default_image']?>" />
                        <?php endif; ?>
                    </td>
                    <td><?=$animal['animal_name']?></td>
                    <td><?=$animal['species']?></td>
                    <td><?=$animal['breed']?></td>
                    <td><?=$animal['age']?> <?=$animal['age_category']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
