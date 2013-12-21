<!-- Display Add Post Text Area -->

<h1>Farm Feed</h1>

<?php include 'v_posts_add.php' ?>

<hr class="clear" />

<!-- Loop through posts for user and all follows -->
<?php foreach($posts as $post): ?>

    <article class="posts<?php foreach($has_comment AS $show_comments): ?><?php if($show_comments['post_id'] == $post['post_id']): ?> has_comment<?php endif ?><?php endforeach; ?>">
    
		<?php if(isset($post['profile_image']) && (!$post['profile_image'] == "")): ?>
        	<img class="image posts_thumb" src="/images/profile/<?=$post['profile_image']?>" />
        <?php else: ?>
        	<img class="image posts_thumb" src="/images/profile/stick-figure.jpg" />
        <?php endif; ?>
        
        <p class="posted_by"><?=$post['first_name']?> <?=$post['last_name']?></p>
        
        <div class="user_post">
        
            <p>
				<?php if(isset($post['user_animal_id']) && (!$post['user_animal_id'] == "")): ?>
					<?php if(isset($post['adult_image']) && (!$post['adult_image'] == "")): ?>
                        <img class="image animal_thumb" src="/images/animals/<?=$post['adult_image']?>" />
                    <?php elseif(isset($post['baby_image']) && (!$post['baby_image'] == "")): ?>
                        <img class="image animal_thumb" src="/images/animals/<?=$post['baby_image']?>" />
                    <?php else: ?>
                        <img class="image animal_thumb" src="/images/animals/default/<?=$post['default_image']?>" />
                    <?php endif; ?>
                <?php endif; ?>

				<?=$post['content']?>
            </p>
            
            <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
				<?=Time::display($post['created'])?>
            </time>
            
            <div class="comment_form"><?php include 'v_posts_comment.php' ?></div>
        
        </div>
    
    </article>
 

	<?php foreach($has_comment AS $show_comments): ?>
    
		<?php if($show_comments['post_id'] == $post['post_id']): ?>
        
            <div class="comment_box">
            
                <!-- Loop through comments for each post -->
                
                <?php foreach($comments AS $comment): ?>
                
                    <?php if($comment['post_id'] == $post['post_id']): ?>
                    
                        <article class="comments">
                        
                            <?php if(isset($comment['profile_image']) && (!$comment['profile_image'] == "")): ?>
                                <img class="image comment_thumb" src="/images/profile/<?=$comment['profile_image']?>" />
                            <?php else: ?>
                                <img class="image comment_thumb" src="/images/profile/stick-figure.jpg" />
                            <?php endif; ?>
                            
                            <div class="post_comment">
                                
                                <p><span class="comment_by"><?=$comment['first_name']?> <?=$comment['last_name']?></span> &ndash; <?=$comment['comment']?></p>
                                
                                <time datetime="<?=Time::display($comment['created'],'Y-m-d G:i')?>">
                                    <?=Time::display($comment['created'])?>
                                </time>
                            
                            </div>
                        
                        </article>
                    
                    <?php endif; ?>
                
                <?php endforeach; ?>
            
            </div>
        
        <?php endif ?>
        
	<?php endforeach; ?>
    
    <hr class="clear" />

<?php endforeach; ?>
