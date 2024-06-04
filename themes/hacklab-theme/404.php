<?php get_header();

$home_url = '/home';
$contact_url = '/contato/';
?>
<div class=" container container--narrow error-404">
    <h1 class="post-header post-header__title">404</h1>
    <span class="not-found"><?php _e('Page not found', 'hacklabr'); ?></span>
    <div class="content">
        <p><?php _e('It looks like this page does not exist or has been deleted, go back to', 'hacklabr'); ?></p>
        <span><?php _e('home or let us know about the issue', 'hacklabr'); ?></span>
    </div>
    <div class="btn">
        <a href="<?php echo esc_url($home_url); ?>" class="button button--outline"><?php _e('Go to Home', 'hacklabr'); ?></a>
        <a href="<?php echo esc_url($contact_url); ?>" class="button button--outline"><?php _e('Contact', 'hacklabr'); ?></a>
    </div>
</div>

<?php get_footer(); ?>
