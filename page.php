<?php get_header() ?>

        <div class="page-header">
            <h1><?php the_title() ?></h1>
        </div>

        <div class="row">
            <div class="col-md-9 blog">

                <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                <article class="post">
                    
                    <div class="post-content">
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="media image">
                            <a href="<?php the_permalink() ?>">
                                <?php the_post_thumbnail() ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php the_content() ?>
                        
                </article>

                <?php endwhile; ?>
                
                <?php endif; ?>

            </div>

            <?php get_sidebar() ?>
        </div>
    </div>
</div>

<?php get_footer() ?>