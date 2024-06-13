<?php get_header(); ?>
<div class="error-404">
        <h1>
            <span class="error"><?php _e('error', 'hacklabr') ?></span>
            <span class="num">404</span>
        </h1>

        <p><?php _e('Page not found', 'hacklabr') ?></p>
        <a href="<?= home_url() ?>" class="button"> <span><?php _e('Return to home page', 'hacklabr') ?></span> </a>
    </div>

<?php get_footer(); ?>
