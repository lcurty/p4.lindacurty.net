<?php foreach($animals as $animal): ?>  

	<?php if(!isset($edit_rights) || $edit_rights !== "Yes"): ?>
    
        <h1>Edit Animal Profile</h1>
        
        <p>You do not have rights to edit information about this animal.</p>
    
    <?php else: ?>

        <form method='POST' name='edit_form' action='/animals/p_animal_edit/<?=$animal['user_animal_ID']?>' enctype="multipart/form-data"> 
            <fieldset>
                <legend>Edit Animal Profile</legend>
            <p>
                <label for="animal_id" class="animal_form" id="animal_id_label">Animal*</label>
                <select name="animal_id" id="animal_id" >
                    <?php foreach($animal_list as $animal_list): ?>
                        <option value="<?=$animal_list['animal_ID']?>" <?php if(isset($animal['animal_ID']) && ($animal['animal_ID'] == $animal_list['animal_ID'])): ?>selected<?php endif; ?>><?=$animal_list['species']?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="breed" class="animal_form" id="email_label">Breed</label>
                <input type="text" name="breed" id="breed" value="<?=$animal['breed']?>" size="38" />
            </p>
            <p>
                <label for="animal_name" class="animal_form" id="animal_name_label">Name</label>
                <input type="text" name="animal_name" id="animal_name" value="<?=$animal['animal_name']?>" size="38" />
            </p>
            <p>
                <label for="born_date" class="animal_form" id="born_date_label">Born On</label>
                <input type="text" name="born_date" id="born_date" value="<?php if($animal['born_date'] !== '00/00/0000'): ?><?=$animal['born_date']?><?php endif; ?>" size="38" />
            </p>
            <p>
                <label for="age" class="animal_form" id="age_label">Approximate Age</label>
                <input type="text" name="age" id="age" value="<?php if($animal['born_date'] == '00/00/0000'): ?><?=$animal['age']?><?php endif; ?>" size="15" />
                <select name="age_category" id="age_category">
                    <option value="days" <?php if(($animal['born_date'] == '00/00/0000') && ($animal['age_category'] == "Day(s)")): ?>selected<?php endif; ?>>Days</option>
                    <option value="weeks" <?php if(($animal['born_date'] == '00/00/0000') && ($animal['age_category'] == "Week(s)")): ?>selected<?php endif; ?>>Weeks</option>
                    <option value="months" <?php if(($animal['born_date'] == '00/00/0000') && ($animal['age_category'] == "Month(s)")): ?>selected<?php endif; ?>>Months</option>
                    <option value="years" <?php if(($animal['born_date'] == '00/00/0000') && ($animal['age_category'] == "Year(s)")): ?>selected<?php endif; ?>>Years</option>              
                </select>
                <span class="note">(If born date not entered.)</span>
            </p>
            <p>
                <label for="acquired_date" class="animal_form" id="acquired_date_label">Acquired</label>
                <input type="text" name="acquired_date" id="acquired_date" value="<?php if($animal['acquired_date'] !== '00/00/0000'): ?><?=$animal['acquired_date']?><?php endif; ?>" size="38" />            
            </p>
            <p>
                <label for="baby_image" class="animal_form" id="baby_image_label">Update Baby Photo</label>
                <input type="file" name="baby_image" id="baby_image" size="38" /><br />
                <?php if(isset($animal['baby_image']) && (!$animal['baby_image'] == "")): ?>
                    <img class="image edit_image" src="/images/animals/<?=$animal['baby_image']?>" alt="Baby Image" />
                <?php else: ?>
                    <img class="image edit_image" src="/images/animals/default/<?=$animal['default_image']?>" alt="Default Animal Image" />
                <?php endif; ?>
                <hr class="clear" />
            </p>
            <p>
                <label for="adult_image" class="animal_form" id="adult_image_label">Update Adult Photo</label>
                <input type="file" name="adult_image" id="adult_image" size="38" /><br />
                <?php if(isset($animal['adult_image']) && (!$animal['adult_image'] == "")): ?>
                    <img class="image edit_image" src="/images/animals/<?=$animal['adult_image']?>" alt="Adult Image" />
                <?php else: ?>
                    <img class="image edit_image" src="/images/animals/default/<?=$animal['default_image']?>" alt="Default Animal Image" />
                <?php endif; ?>
                <hr class="clear" />
            </p>
            <p>
                <label for="notes" class="animal_form" id="notes_label">Notes</label>
                <textarea name="notes" id="notes" cols="65" ><?=$animal['notes']?></textarea>
            </p>
            <p class="center">
                <input type="submit" class="button" id="submit_btn" value="Update" />
                <a href="/users/profile" class="button">Back To Profile</a>
            </p>
            <p class="note">* Required
                
            </fieldset>  
        </form>

	<?php endif; ?>

<?php endforeach; ?>