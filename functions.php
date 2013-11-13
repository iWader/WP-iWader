<?php

    add_theme_support('post-thumbnails');
    
    function iwader_excerpt_length()
    {
        return 100;
    }
    
    add_filter('excerpt_length', 'iwader_excerpt_length', 999);
    
    function iwader_excerpt_more($more)
    {
        return ' ...';
    }
    
    add_filter('excerpt_more', 'iwader_excerpt_more');
    
    function iwader_comments_callback($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class() ?> id="comment-<?php comment_ID() ?>">
            <div class="photo">
                <?php echo get_avatar( get_comment_author_email() , 80 ) ?>
            </div>
            
            <div class="body clearfix">
                <div class="head">
                    <div class="name">
                        <?php comment_author_link() ?>
                        <?php if (($args['max_depth'] != $depth) && is_user_logged_in()) : ?>
                            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="fa fa-share"></i>'))) ?>
                        <?php endif; ?>
                    </div>
                    <div class="date"><?php comment_date() ?> at <?php comment_time() ?></div>
                </div>
                
                <?php if ($comment->comment_approved == '0') : ?>
                
                <p>Your comment is awaiting approval</p>
                
                <?php else : ?>
                
                <p><?php comment_text() ?></p>
                
                <?php endif; ?>
            </div>
        </li>
    <?php }
    
?>
