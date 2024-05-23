

<?php if ( ( is_single() || is_page() || is_home() ) && get_post_meta( get_the_ID(), '0', true ) ) : ?>
    <div class="partners-list container">
        <?php echo hacklabr\get_layout_footer( 'parceiros' ); ?>
    </div>
<?php endif; ?>
