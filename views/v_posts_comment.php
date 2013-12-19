<form class='addComment' method='POST' action='/posts/p_comment'>

    <p><label for='comment'>Comment:</label><br>
    <textarea name='comment' id='content' cols='50' rows="1"></textarea></p>
    <input type='hidden' value='<?=$post['post_id']?>' name="post_id" id="post_id" />
    <p><input type='submit' class="button" value='Comment' /></p>

</form> 