<footer>
    <div id="twitter-footer">
        <div class="container">
            <a class="logo" href="#">
                <img src="<?php bloginfo('template_url') ?>/img/twitter-bird-inverse.png">
            </a>
        </div>
    </div>

    <div id="bottom-footer">
        <div class="container">
            <div class="footer-nav pull-left hidden-phone">
                <?php echo strip_tags(wp_nav_menu(array(
                          'menu'       => 'footer-navigation',
                          'container'  => false,
                          'depth'      => 0,
                          'items_wrap' => '%3$s',
                          'echo'       => false
                      )), '<a>') ?>
            </div>

            <div class="social hidden-phone hidden-tablet">
                <a href="#" class="social-icon">
                    <i class="fa fa-bitbucket fa-3x"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fa fa-github fa-3x"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fa fa-twitter fa-3x"></i>
                </a>
            </div>

            <div class="copyright pull-right">
                &copy; Wade Urry
            </div>
        </div>
    </div>
</footer>

<?php wp_footer() ?>
<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/setup.js"></script>

<?php if (current_user_can('manage_options')) : ?>
<!-- <?php echo get_num_queries() ?> queries. <?php timer_stop(1); ?> seconds. -->
<?php endif; ?>
