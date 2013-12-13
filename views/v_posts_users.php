<table class="users_table">
	<tbody>
		<?php foreach($users as $user): ?>
      <tr>
      	<td>
					<?php if(isset($user['profile_image']) && (!$user['profile_image'] == "")): ?>
            <img class="circular" src="../images/profile/<?=$user['profile_image']?>" />
          <?php else: ?>
            <img class="circular" src="../images/profile/stick-figure.jpg" />
          <?php endif; ?>
        </td>
        <td>
					<?=$user['first_name']?> <?=$user['last_name']?>
        </td>
        <td>
					<?php if(isset($connections[$user['user_id']])): ?>
            <a class='button' href='/posts/unfollow/<?=$user['user_id']?>'>Remove Follow</a>
          <?php else: ?>
            <a class='button' href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
          <?php endif; ?>
        </td>
      </tr>      
    <?php endforeach ?>
	</tbody>
</table>