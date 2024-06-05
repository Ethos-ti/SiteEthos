<?php
get_header();

global $wp_query;

$post_type = get_post_type() ?: 'post';

$terms = get_terms_by_use_menu( 'category', get_post_type() );

if($wp_query->get('category_name')){
    $active_tab = $wp_query->get('category_name');

}else{
    $active_tab = 'all';
}

$desired_order = [ 'DIREITOS HUMANOS', 'INTEGRIDADE', 'GESTÃO SUSTENTÁVEL', 'MEIO AMBIENTE', 'INSTITUCIONAL' ];

function custom_sort($a, $b) {
    global $desired_order;
    $pos_a = array_search($a->name, $desired_order);
    $pos_b = array_search($b->name, $desired_order);

    if ($pos_a === false && $pos_b === false) {
        return 0;
    } elseif ($pos_a === false) {
        return 1;
    } elseif ($pos_b === false) {
        return -1;
    } else {
        return $pos_a - $pos_b;
    }
}

usort($terms, 'custom_sort');

?>

    <div class="container container--wide">

        <?php echo hacklabr\get_layout_part_header(); ?>

        <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
            <div class="tabs" x-data="{ currentTab: '<?php echo $active_tab?>' }" x-bind="Tabs($data)">
                <div class="tabs__header" role="tablist">
                    <a class="tab" x-bind="TabButton('all', $data)" href="<?= esc_url( get_post_type_archive_link( $post_type ) ); ?>"><?php _e('All the areas', 'hacklabr') ?></a>
                    <?php foreach ( $terms as $term ) : ?>
                        <?php
                            $icon = get_term_meta($term->term_id, 'icon', true);
                            $icon_url = '';
                            if($icon){
                                $icon_url = wp_get_attachment_image_url($icon, 'thumbnail');
                            }
                        ?>
                        <a class="tab" x-bind="TabButton('<?= esc_attr( $term->slug ); ?>', $data)" href="<?= esc_url( get_term_link( $term->term_id, 'category' ) ); ?>?post_type=<?= $post_type; ?>">

                            <?php if($icon_url) :?>
                                <img src="<?php echo $icon_url ?>" alt="">
                            <?php endif; ?>
                            <?= esc_attr( $term->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="tabs__panels">
                    <div class="tabs__panel" x-bind="TabPanel('<?php echo $active_tab?>', $data)">
                        <main class="posts-grid__content">
                            <?php while ( have_posts() ) : the_post(); ?>
                                <?php get_template_part( 'template-parts/post-card', null, [
                                    'hide_author' => true,
                                    'hide_date' => true,
                                    'hide_excerpt' => true
                                ] ); ?>
                            <?php endwhile; ?>
                        </main>
                        <?php
                        the_posts_pagination([
                            'prev_text' => '<iconify-icon icon="fa-solid:angle-left" aria-label="' . __('Previous page') . '"></iconify-icon>',
                            'next_text' => '<iconify-icon icon="fa-solid:angle-right" aria-label="' . __('Next page') . '"></iconify-icon>',
                        ]); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div><!-- /.container -->

<?php get_footer();
