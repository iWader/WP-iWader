<?php get_header() ?>

        <div class="row">
            <div class="col-md-9 blog blog-index">

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

                            <?php if (has_post_thumbnail()) : ?>
                            <div class="media image">
                                <a href="<?php the_permalink() ?>">
                                    <?php the_post_thumbnail() ?>
                                </a>
                            </div>
                            <?php endif; ?>

                            <p><?php if (is_category() || is_archive() || is_home()) {
                                         the_excerpt();
                                     } else {
                                         the_content('');
                                     }
                               ?></p>
                        </div>

                        <?php if (!is_single()) : ?>
                        <div class="read-more">
                            <a href="<?php the_permalink() ?>">Read More</a>
                        </div>
                        <?php endif; ?>

                        <div class="clearfix"></div>
                    </div>
                </article>

                <?php endwhile; ?>

                <?php else : ?>

                <div class="page-header">
                    <h1>Nothing Found</h1>
                    <p>The site owner hasn't made any posts yet!</p>
                </div>

                <?php endif; ?>

                <?php iwader_pagination() ?>

            </div>

            <?php get_sidebar() ?>
        </div>
    </div>
</div>

<?php get_footer() ?>