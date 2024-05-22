<?php if ( ( is_single() || is_page() ) && get_post_meta( get_the_ID(), 'show_partners_list', true ) ) : ?>
    <div class="partners-list container">
        <?php echo hacklabr\get_layout_footer( 'parceiros' ); ?>
    </div>
<?php endif; ?>
