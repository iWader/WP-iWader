<?php

    // Add support for featured images
    add_theme_support('post-thumbnails');
    
    // Register our nav menues
    register_nav_menu('main-navigation', 'Main Navigation');
    register_nav_menu('footer-navigation', 'Footer Navigation');
    
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
    
    // Create our settings pages within the WP dashboard
    function iwader_setup_theme_menus()
    {
        add_submenu_page('themes.php', 'Social Footer Icons', 'Social Footer', 'manage_options', 'social-footer', 'iwader_social_footer_settings');
    }
    
    add_action('admin_menu', 'iwader_setup_theme_menus');
    
    function iwader_social_footer_settings()
    {
        if (!current_user_can('manage_options'))
            wp_die('You do not have sufficient permission to access this page.');
        
        if (isset($_POST['update_settings']))
        {
            update_option('iwader_sf_bitbucket', $_POST['sf_bitbucket']);
            update_option('iwader_sf_facebook', $_POST['sf_facebook']);
            update_option('iwader_sf_flickr', $_POST['sf_flickr']);
            update_option('iwader_sf_foursquare', $_POST['sf_foursquare']);
            update_option('iwader_sf_github', $_POST['sf_github']);
            update_option('iwader_sf_googleplus', $_POST['sf_googleplus']);
            update_option('iwader_sf_instagram', $_POST['sf_instagram']);
            update_option('iwader_sf_linkedin', $_POST['sf_linkedin']);
            update_option('iwader_sf_pinterest', $_POST['sf_pinterest']);
            update_option('iwader_sf_skype', $_POST['sf_skype']);
            update_option('iwader_sf_stackexchange', $_POST['sf_stackexchange']);
            update_option('iwader_sf_stackoverflow', $_POST['sf_stackoverflow']);
            update_option('iwader_sf_tumblr', $_POST['sf_tumblr']);
            update_option('iwader_sf_twitter', $_POST['sf_twitter']);
            update_option('iwader_sf_youtube', $_POST['sf_youtube']);
        }
        
        ?>
        
        <div class="wrap">
            <?php screen_icon('themes') ?> <h2>Social Footer Settings</h2>
            
            <form method="POST" action="">
                <table class="form-table">
                    <tr>
                        <th style="text-align: right; width: 250px;">
                            <label for="sf_bitbucket">
                                BitBucket - <small>https://bitbucket.org/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_bitbucket" placeholder="BitBucket Username" value="<?php echo get_option('iwader_sf_bitbucket') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_facebook">
                                Facebook - <small>https://www.facebook.com/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_facebook" placeholder="Facebook URL Handle" value="<?php echo get_option('iwader_sf_facebook') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_flickr">
                                Flickr - <small>http://www.flickr.com/photos/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_flickr" placeholder="Flickr URL Handle" value="<?php echo get_option('iwader_sf_flickr') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_foursquare">
                                Foursquare - <small>https://foursquare.com/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_foursquare" placeholder="Foursquare Username" value="<?php echo get_option('iwader_sf_foursquare') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_github">
                                GitHub - <small>https://github.com/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_github" placeholder="GitHub Username" value="<?php echo get_option('iwader_sf_github') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_googleplus">
                                Google+ - <small>https://plus.google.com/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_googleplus" placeholder="G+ Account #" value="<?php echo get_option('iwader_sf_googleplus') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_instagram">
                                Instagram - <small>http://instagram.com/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_instagram" placeholder="Instagram Username" value="<?php echo get_option('iwader_sf_instagram') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_linkedin">
                                LinkedIn - <small>http://www.linkedin.com/in/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_linkedin" placeholder="LinkedIn Username" value="<?php echo get_option('iwader_sf_linkedin') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_pinterest">
                                Pinterest - <small>http://www.pinterest.com/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_pinterest" placeholder="Pinterest Username" value="<?php echo get_option('iwader_sf_pinterest') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_skype">
                                Skype
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_skype" placeholder="Skype Handle" value="<?php echo get_option('iwader_sf_skype') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_stackexchange">
                                Stack Exchange - <small>http://stackexchange.com/users/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_stackexchange" placeholder="StackExchange User #" value="<?php echo get_option('iwader_sf_stackexchange') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_stackoverflow">
                                Stack Overflow - <small>http://stackoverflow.com/users/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_stackoverflow" placeholder="StackOverflow User #" value="<?php echo get_option('iwader_sf_stackoverflow') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_tumblr">
                                Tumblr - <small>http://[username].tumblr.com/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_tumblr" placeholder="Tumblr Username" value="<?php echo get_option('iwader_sf_tumblr') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_twitter">
                                Twitter - <small>https://twitter.com/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_twitter" placeholder="Twitter Username" value="<?php echo get_option('iwader_sf_twitter') ?>">
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            <label for="sf_youtube">
                                YouTube - <small>http://www.youtube.com/user/</small>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="sf_youtube" placeholder="YouTube Username" value="<?php echo get_option('iwader_sf_youtube') ?>">
                        </td>
                    </tr>
                </table>
                
                <p>
                    <input type="hidden" name="update_settings" value="true">
                    <input type="submit" value="Save settings" class="button-primary">
                </p>
            </form>
        </div>
        
        <?php
    }
    
    function iwader_social_footer_output()
    {
        $output = '';
        
        if (get_option('iwader_sf_bitbucket'))
            $output .= '<a href="https://bitbucket.org/' . get_option('iwader_sf_bitbucket') . '" class="social-icon"><i class="fa fa-bitbucket fa-3x"></i></a>';
        
        if (get_option('iwader_sf_facebook'))
            $output .= '<a href="https://www.facebook.com/' . get_option('iwader_sf_facebook') . '" class="social-icon"><i class="fa fa-facebook fa-3x"></i></a>';
        
        if (get_option('iwader_sf_flickr'))
            $output .= '<a href="http://www.flickr.com/photos/' . get_option('iwader_sf_flickr') . '" class="social-icon"><i class="fa fa-flickr fa-3x"></i></a>';
        
        if (get_option('iwader_sf_foursquare'))
            $output .= '<a href="https://foursquare.com/' . get_option('iwader_sf_foursquare') . '" class="social-icon"><i class="fa fa-foursquare fa-3x"></i></a>';
        
        if (get_option('iwader_sf_github'))
            $output .= '<a href="https://github.com/' . get_option('iwader_sf_github') . '" class="social-icon"><i class="fa fa-github fa-3x"></i></a>';
        
        if (get_option('iwader_sf_googleplus'))
            $output .= '<a href="https://plus.google.com/' . get_option('iwader_sf_googleplus') . '" class="social-icon"><i class="fa fa-google-plus fa-3x"></i></a>';
        
        if (get_option('iwader_sf_instagram'))
            $output .= '<a href="http://instagram.com/' . get_option('iwader_sf_instagram') . '" class="social-icon"><i class="fa fa-instragram fa-3x"></i></a>';
        
        if (get_option('iwader_sf_linkedin'))
            $output .= '<a href="http://www.linkedin.com/in/' . get_option('iwader_sf_linkedin') . '" class="social-icon"><i class="fa fa-linkedin fa-3x"></i></a>';
        
        if (get_option('iwader_sf_pinterest'))
            $output .= '<a href="http://www.pinterest.com/' . get_option('iwader_sf_pinterest') . '" class="social-icon"><i class="fa fa-pinterest fa-3x"></i></a>';
        
        if (get_option('iwader_sf_skype'))
            $output .= '<a href="skype:' . get_option('iwader_sf_skype') . '" class="social-icon"><i class="fa fa-skype fa-3x"></i></a>';
        
        if (get_option('iwader_sf_stackexchange'))
            $output .= '<a href="http://stackexchange.com/users/' . get_option('iwader_sf_stackexchange') . '" class="social-icon"><i class="fa fa-stack-exchange fa-3x"></i></a>';
        
        if (get_option('iwader_sf_stackoverflow'))
            $output .= '<a href="http://stackoverflow.com/users/' . get_option('iwader_sf_stackoverflow') . '" class="social-icon"><i class="fa fa-stack-overflow fa-3x"></i></a>';
        
        if (get_option('iwader_sf_tumblr'))
            $output .= '<a href="http://' . get_option('iwader_sf_tumblr') . '.tumblr.com/" class="social-icon"><i class="fa fa-tumblr fa-3x"></i></a>';
        
        if (get_option('iwader_sf_twitter'))
            $output .= '<a href="https://twitter.com/' . get_option('iwader_sf_twitter') . '" class="social-icon"><i class="fa fa-twitter fa-3x"></i></a>';
        
        if (get_option('iwader_sf_youtube'))
            $output .= '<a href="http://www.youtube.com/user/' . get_option('iwader_sf_youtube') . '" class="social-icon"><i class="fa fa-youtube fa-3x"></i></a>';
        
        return $output;
    }
    
?>
