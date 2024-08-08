<?php
if ( is_post_type_archive( 'tribe_events' ) || ( is_singular() && get_post_meta( get_the_ID(), 'exibir_parceiros', true ) === 'Sim, exibir parceiros' ) ) :
?>
    <div class="partners-list container container--wide">
        <?php echo hacklabr\get_layout_part_footer(); ?>
    </div>
<?php endif; ?>
