<aside id="sidebar" class="col-md-3">
    <section>
        <form class="form-search">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </section>
    
    <section>
        <div class="underline-heading">
            <h3>Categories</h3>
        </div>
        
        <ul class="arrow-list">
            <?php $categories = get_categories(array('orderby' => 'name', 'order' => 'DESC', 'hide_empty' => 1)) ?>
            
            <?php foreach ($categories as $category) : ?>
            <li>
                <a href="<?php echo get_category_link($category->term_id) ?>">
                    <?php echo $category->name ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    
    <section>
        <div class="underline-heading">
            <h3>Archives</h3>
        </div>
        
        <ul class="arrow-list">
            <?php $archives = wp_get_archives(array('type' => 'monthly', 'format' => 'custom', 'before' => '<li>', 'after' => '</li>', 'show_post_count' => true)) ?>
            
            <?php print_r($archives); ?>
        </ul>
    </section>
</aside>