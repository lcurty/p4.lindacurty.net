<!-- Display user profile -->
<div id="profile">

	<?php foreach($profiles as $profile): ?>  
        
        <div id="critter_categories">
        	
            <h1><?=$profile['first_name']?> <?=$profile['last_name']?>'s Farm</h1>

        	<?php if(isset($inventory_count) && $inventory_count > 0): ?>

                <h2>Critter Count</h2>
                
                <?php foreach($categories as $category): ?>  
                    <div class="category">
                        <img class="image animal_thumb" src="/images/animals/default/<?=$category['default_image']?>" alt="Default <?=$category['species']?> Image" />
                        <span class="bold"><?=$category['species']?>s</span>: <?=$category['animal_count']?>
                    </div>
                <?php endforeach; ?>
                
            <?php endif; ?>
		</div>
    
		<?php if(isset($profile['profile_image']) && (!$profile['profile_image'] == "")): ?>
        	<img class="image profile_image" src="/images/profile/<?=$profile['profile_image']?>" alt="Profile Image" />
        <?php else: ?>
        	<img class="image profile_image" src="/images/profile/stick-figure.jpg" alt="Default Profile Image" />
        <?php endif; ?>
        
	<?php endforeach; ?>

</div>

<hr class="clear" />

<?php if(isset($edit_rights) && $edit_rights == "Yes"): ?>
    <a href='/animals/add' class="button right">Add a New Animal</a>
    
    <hr class="clear" />
<?php endif ?>

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
        	<?php if(isset($inventory_count) && $inventory_count > 0): ?>
				<?php foreach($inventory as $animal): ?>  
                    <tr>
                        <td>
                            <a href="/animals/preview/<?=$animal['user_animal_id']?>" class="button"><img src="/images/magnifying-glass.png" alt="View Animal" /></a>
                        </td>
                        <td>
                            <?php if(isset($animal['adult_image']) && (!$animal['adult_image'] == "")): ?>
                                <img class="image animal_thumb" src="/images/animals/<?=$animal['adult_image']?>" alt="Adult Animal Image" />
                            <?php elseif(isset($animal['baby_image']) && (!$animal['baby_image'] == "")): ?>
                                <img class="image animal_thumb" src="/images/animals/<?=$animal['baby_image']?>" alt="Baby Animal Image" />
                            <?php else: ?>
                                <img class="image animal_thumb" src="/images/animals/default/<?=$animal['default_image']?>" alt="Default Animal Image" />
                            <?php endif; ?>
                        </td>
                        <td><?=$animal['animal_name']?></td>
                        <td><?=$animal['species']?></td>
                        <td><?=$animal['breed']?></td>
                        <td><?=$animal['age']?> <?=$animal['age_category']?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
            	<tr><td colspan="6"><?=$profile['first_name']?> <?=$profile['last_name']?> doesn't have any animals added to the farm yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div id="search_farm">
        <h2>Filter Animal List</h2>
        <p>Enter any term that you would like to filter on. The animal table will filter based on a match in any part of the row. Deleting any text in the filter box will reset the table &ndash; displaying all animals.</p>
        <form name="animal_filter">
            <fieldset>
                <p><label id='filter_label'>Filter Terms</label><input type='text' id="search" name='filter'></p>
            </fieldset>
        </form>
    </div>
    
    <div id="follow_list">
        <h2>Following</h2>
        <?php if(isset($connections_count) && $connections_count > 0): ?>
        
			<?php foreach($connections as $connection): ?>
    
                <div>
                    <a href="/users/profile/<?=$connection['user_id']?>">
                        <?php if(isset($connection['profile_image']) && (!$connection['profile_image'] == "")): ?>
                            <img class="image users" src="/images/profile/<?=$connection['profile_image']?>" alt="Profile Image" />
                        <?php else: ?>
                            <img class="image users" src="/images/profile/stick-figure.jpg" alt="Default Profile Image" />
                        <?php endif; ?>
                    </a>
                    &nbsp;
                    <a href="/users/profile/<?=$connection['user_id']?>">                   
                        <?=$connection['first_name']?> <?=$connection['last_name']?>
                    </a>                                     
                </div>
                
            <?php endforeach ?>
        <?php else: ?>
        	<p><?=$profile['first_name']?> <?=$profile['last_name']?> isn't following any other farmers.</p>
        <?php endif; ?>
            
    </div>

</div>
