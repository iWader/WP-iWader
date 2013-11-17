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
                <?php echo iwader_social_footer_output() ?>
            </div>

            <div class="copyright pull-right">
                <a href="http://www.iwader.co.uk/">&copy; Wade Urry</a> <?php /* Feel free to change the copyright notice, but please leave the html comment */ ?>
                <!-- Theme created by Wade Urry - http://www.iwader.co.uk/ -->
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
