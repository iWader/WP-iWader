<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
            die('You can not access this page directly!');
?>

<?php if (post_password_required()) { return; } ?>

<div class="comments">
    <div class="underline-heading">
        <h3>Comments</h3>
    </div>
    
    <?php if (have_comments()) : ?>
    
    <ul>
        <?php wp_list_comments(array('callback' => 'iwader_comments_callback')) ?>
    </ul>
        
    <?php else : ?>
    
    <h5>No comments have been made. Be the first to comment below!</h5>
    
    <?php endif; ?>
</div>

<div class="comment-form" id="respond">
    <div class="underline-heading">
        <h3><?php comment_form_title('Leave a Comment', 'Leave a Comment on %s') ?></h3>
    </div>
    
    <?php if (comments_open()) : ?>
    
        <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
    
        <h5>You must be <a href="<?php wp_login_url( get_permalink() ) ?>">logged in</a> to leave a comment</h5>
    
        <?php else : ?>
        
            <?php if (is_user_logged_in()) { global $current_user; get_currentuserinfo(); } ?>
        
        <form action="<?php bloginfo('siteurl') ?>/wp-comments-post.php" method="post" role="form">
            <div class="form-group">
                <label for="author">Name <?php ($req ? '<span class="required">*</span>' : '') ?></label>
                <input type="text" id="author" name="author" class="form-control" placeholder="Name" length="30" value="<?php echo (is_user_logged_in() ? $current_user->display_name : '') ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email <?php ($req ? '<span class="required">*</span>' : '') ?></label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" length="64" value="<?php echo (is_user_logged_in() ? $current_user->user_email : '') ?>">
            </div>
            
            <div class="form-group">
                <label for="url">Website <?php ($req ? '<span class="required">*</span>' : '') ?></label>
                <input type="text" id="url" name="url" class="form-control" placeholder="Website URL" length="64" value="<?php echo (is_user_logged_in() ? $current_user->user_url : '') ?>">
            </div>
            
            <div class="form-group">
                <label for="comment">Comment <?php ($req ? '<span class="required">*</span>' : '') ?></label>
                <textarea name="comment" id="comment" class="form-control" rows="5" placeholder="Leave your comment here..."></textarea>
            </div>
            
            <button type="submit" class="btn btn-success pull-right">Post Comment</button>
            <div class="clearfix"></div>
            <?php comment_id_fields() ?>
        </form>
        
        <?php do_action('comment_form', $post->ID) ?>
        
        <?php endif; ?>
    
    <?php else : ?>
    
    <h5>Comments are disabled, please check back later</h5>
    
    <?php endif; ?>
</div>