<?php
/*
Template Name: Portfolio Index
*/

// Get our pagination details
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Setup our query
$args = array(
    'orderby'        => 'post_date',
    'order'          => 'DESC',
    'post_type'      => 'page',
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'page-portfolio-single.php',
    'post_status'    => 'publish',
    //'posts_per_page' => 6, // Use the default from WP Reading Preferences for better customisation
    'paged'          => $paged
);

$postslist = query_posts($args);
?>

<?php get_header() ?>

        <div class="page-header">
            <h1><?php the_title() ?></h1>
        </div>

        <div class="row">
            <div class="col-md-9">
                
                <?php if (count($postslist) > 0) : ?>

                    <?php foreach($postslist as $post) { iwader_portfolio_index_post_callback($post); } ?>
                
                    <?php iwader_pagination() ?>
                
                <?php else : ?>
                
                    <h2>No Pages Found!</h2>
                
                <?php endif; ?>

            </div>

            <?php get_sidebar() ?>
        </div>
    </div>
</div>

<?php get_footer() ?>