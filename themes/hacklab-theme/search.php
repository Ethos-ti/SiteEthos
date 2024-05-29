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
?>


<div class="container container--wide">
    <?php get_template_part( 'template-parts/title/archive-header' ); ?>

    <div class="tabs__header" role="tablist">
        <a class="tab" x-bind="TabButton('all', $data)" href="<?= esc_url( get_post_type_archive_link( $post_type ) ); ?>"><?php _e('All the areas', 'hacklabr') ?></a>

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
                'prev_text' => __( '<iconify-icon icon="iconamoon:arrow-left-2-bold"></iconify-icon>', 'hacklbr'),
                'next_text' => __( '<iconify-icon icon="iconamoon:arrow-right-2-bold"></iconify-icon>', 'hacklbr'),

            ]); ?>
        </div>
    </div>
</div><!-- /.container -->


<?php get_footer();
