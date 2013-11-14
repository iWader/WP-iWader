<?php

/* Enqueue our carouFredSel plugin scripts here */
wp_enqueue_script('caroufredsel_jquery_packed', get_template_directory_uri() . '/plugins/caroufredsel/jquery.caroufredsel-6.2.1-packed.js');

?>

<div class="row">
    <div class="portfolio-carousel clearfix">
        <div class="underline-heading">
            <h3>More Works</h3>
        </div>

        <ul class="carousel-nav">
            <li>
                <a href="#" id="portfolio-carousel-prev">
                    <
                </a>
            </li>
            <li>
                <a href="#" id="portfolio-carousel-next">
                    >
                </a>
            </li>
        </ul>

        <div class="portfolio-items">
            <?php
            
                $pages = get_pages(array(
                    'sort_order'  => 'DESC',
                    'exclude'     => get_the_ID(),
                    'post_type'   => 'page',
                    'meta_key'    => '_wp_page_template',
                    'meta_value'  => 'page-portfolio-single.php',
                    'post_status' => 'publish'
                ));
                
                foreach ($pages as $page)
                { ?>
                    <div class="item col-md-4">
                        <div class="image">
                            <?php if (has_post_thumbnail($page->ID) && $image = wp_get_attachment_url( get_post_thumbnail_id($page->ID) )) : ?>
                            <img src="<?php echo $image ?>">
                            <?php else : ?>
                            <img src="<?php echo get_template_directory_uri() ?>/img/placeholder.jpg">
                            <?php endif; ?>
                            
                            <a href="<?php echo get_permalink($page->ID) ?>" class="overlay">
                                <ul class="actions">
                                    <li class="view">
                                        <i class="fa fa-search"></i>
                                    </li>
                                    <li class="details">
                                        <div class="name"><?php echo get_the_title($page->ID) ?></div>
                                    </li>
                                </ul>
                            </a>
                        </div>
                    </div>
          <?php } ?>
        </div>
    </div>
</div>