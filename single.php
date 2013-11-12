<?php get_header() ?>

        <div class="page-header">
            <h1>Blog
                <small><?php the_title() ?></small>
            </h1>
        </div>

        <div class="row">
            <div class="col-md-9 blog">

                <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                <article class="post">
                    <div class="side">
                        <div class="post-type">

                            <?php if (has_post_thumbnail()) : ?>
                            <i class="fa fa-picture-o fa-3x"></i>
                            <?php else : ?>
                            <i class="fa fa-pencil fa-3x"></i>
                            <?php endif; ?>

                        </div>
                        <div class="post-date">
                            <span class="day"><?php the_time('j') ?></span>
                            <span class="month"><?php the_time('M') ?></span>
                        </div>
                    </div>

                    <div class="post-wrap">
                        <div class="post-content">
                            <h2 class="title">
                                <a href="<?php the_permalink() ?>">
                                    <?php the_title() ?>
                                </a>
                            </h2>

                            <ul class="meta">
                                <li>
                                    <i class="fa fa-user"></i>
                                    <?php the_author() ?>
                                </li>
                                <li>
                                    <i class="fa fa-comments"></i>
                                    <?php comments_number('No Comments', '1 Comment', '% Comments') ?>
                                </li>
                                <li>
                                    <i class="fa fa-tag"></i>
                                    <?php the_category(', ') ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
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
                    
                    <div class="author">
                        <div class="underline-heading">
                            <h3>About The Author</h3>
                        </div>

                        <div class="photo">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 128) ?>
                        </div>

                        <div class="info">
                            <div class="name">
                                <a href="<?php the_author_meta('user_url') ?>"><?php the_author_meta('display_name') ?></a>
                                <small><?php the_author_meta('occupation') ?></small>
                            </div>
                            <p><?php the_author_meta('description') ?></p>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    
                    <?php comments_template() ?>
                        
                </article>

                <?php endwhile; ?>
                
                <?php endif; ?>

            </div>

            <?php get_sidebar() ?>
        </div>
    </div>
</div>

<?php get_footer() ?>