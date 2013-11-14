<?php
/*
Template Name: Portfolio Project
*/
?>

<?php get_header() ?>

        <div class="page-header">
            <h1><?php the_title() ?></h1>
        </div>

        <div class="row">
            <div class="col-md-9">

                <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>
                
                <div class="row portfolio">
                    <div class="col-md-9">
                        
                        <?php the_content() ?>
                        
                    </div>
                    
                    <div class="col-md-3">
                        <div class="underline-heading">
                            <h2>Scope</h2>
                        </div>
                        
                        <?php the_field('project_scope') ?>
                        
                        <div class="portfolio-meta">
                            <span>
                                <i class="fa fa-clock-o"></i>
                                <?php the_field('time_spent') ?>
                            </span>
                            
                            <?php if (get_field('launch_url')) : ?>
                            <span>
                                <i class="fa fa-link"></i>
                                <a href="<?php the_field('launch_url') ?>" title="View this project live">Launch</a>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="underline-heading">
                            <h3>The Challenge</h3>
                        </div>
                        
                        <?php the_field('the_challenge') ?>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="underline-heading">
                            <h3>The Outcome</h3>
                        </div>
                        
                        <?php the_field('the_outcome') ?>
                    </div>
                </div>
                
                <?php get_template_part('portfolio-carousel') ?>

                <?php endwhile; ?>
                
                <?php endif; ?>

            </div>

            <?php get_sidebar() ?>
        </div>
    </div>
</div>

<?php get_footer() ?>