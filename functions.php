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
    
    /* Create a nice sliding gallery with flex slider */
    remove_shortcode('gallery', 'gallery_shortcode'); // Remove wordpress' default gallery shortcode
    add_shortcode('gallery', 'iwader_gallery_flexslider_shortcode'); // Add our own gallery shortcode
    
    function iwader_gallery_flexslider_shortcode($attr)
    {
        /* Start - wp-includes/media.php */
        $post = get_post();
        
        static $instance = 0;
        $instance++;
        
        if ( ! empty( $attr['ids'] ) ) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if ( empty( $attr['orderby'] ) )
                $attr['orderby'] = 'post__in';
            $attr['include'] = $attr['ids'];
        }

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        }
        
        extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post ? $post->ID : 0,
            'itemtag'    => '',
            'icontag'    => '',
            'captiontag' => '',
            'columns'    => 1,
            'size'       => 'full',
            'include'    => '',
            'exclude'    => '',
            'link'       => ''
        ), $attr, 'gallery'));
        
        $id = intval($id);
        if ( 'RAND' == $order )
    		$orderby = 'none';
        
        if ( !empty($include) ) {
            $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( !empty($exclude) ) {
            $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        } else {
            $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        }

        if ( empty($attachments) )
            return '';

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment )
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            return $output;
        }
        /* End - wp-includes/media.php */
        
        // Past this point we're going to use flexslider, so enqueue our styles and js
        wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/plugins/flexslider/flexslider.css');
        wp_enqueue_script('flexslider_js_min', get_template_directory_uri() . '/plugins/flexslider/jquery.flexslider-min.js');
        
        $output = '<div class="flexslider"><ul class="slides">';
        
        foreach ($attachments AS $id => $attachment)
        {
            $image_url = wp_get_attachment_image_src($id, $size);
            
            $output .= '<li><img src="' . $image_url[0] . '"></li>';
        }
        
        $output .= '</ul></div>';
        
        return $output;
    }
    
    function iwader_portfolio_index_post_callback($post)
    {
        ?>
        
        <div class="row portfolio-row">
            <div class="col-md-8">
                <?php echo do_shortcode($post->post_content) ?>
            </div>
            
            <div class="col-md-4">
                <div class="underline-heading">
                    <h2><?php echo $post->post_title ?></h2>
                </div>
                
                <p><?php echo iwader_truncate(get_field('the_challenge', $post->ID), 200) ?></p>
                
                <div class="underline-heading">
                    <h4>Technologies</h4>
                </div>
                
                <?php the_field('project_scope', $post->ID) ?>
                
                <div class="read-more">
                    <a href="<?php the_permalink($post->ID) ?>">
                        <i class="fa fa-link"></i>
                        Read More
                    </a>
                </div>
            </div>
        </div>
        
        <?php
    }
    
    // Credit to Justin Kelly for this truncate function - http://blog.justin.kelly.org.au/php-truncate/
    function iwader_truncate($string, $limit, $break = '.', $pad = '...')
    {
        // return with no change if string is shorter than $limit
        if (strlen($string) <= $limit) return $string;
        
        // is $break present between $limit and the end of the string?
        if (false !== ($breakpoint = strpos($string, $break, $limit)))
            if ($breakpoint < strlen($string) - 1)
                $string = substr($string, 0, $breakpoint) . $pad;
            
        return $string;
    }
    
    function iwader_pagination($older = '&larr; Older', $newer = 'Newer &rarr;')
    { ?>
        <ul class="pager">
            <?php if (get_next_posts_link($older)) : ?>
            <li class="previous">
                <?php next_posts_link($older) ?>
            </li>
            <?php else : ?>
            <li class="previous disabled">
                <a href="#"><?php echo $older ?></a>
            </li>
            <?php endif; ?>
            
            <?php if (get_previous_posts_link($newer)) : ?>
            <li class="next">
                <?php previous_posts_link($newer) ?>
            </li>
            <?php else : ?>
            <li class="next disabled">
                <a href="#"><?php echo $newer ?></a>
            </li>
            <?php endif; ?>
        </ul>
    <?php }
    
?>
