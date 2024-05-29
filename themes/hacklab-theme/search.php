<?php
get_header();
global $wp_query;

$total_results = $wp_query->found_posts;

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
            <div class="search__results">
                <div class="search__results__found">
                    <p><?php _e('We found ', 'hacklabr');?><span><?= $wp_query->found_posts;?></span><?php _e(' results for this search.', 'hacklabr');?></p>
                </div>
                <div class="search__results__filter">
                    <label for="tipo"><?php _e('', 'hacklabr'); ?></label>
                    <div class="custom-select-wrapper-opinion">
                        <select name="tipo" id="tipo">
                            <option value="all" <?php selected($_GET['tipo'], 'all') ?>><?php _e('SHOWING: all contents', 'hacklabr'); ?></option>
                            <option value="post" <?php selected($_GET['tipo'], 'iniciativa') ?>><?php _e('Performance', 'hacklabr'); ?></option>
                            <option value="post" <?php selected($_GET['tipo'], 'post') ?>><?php _e('News', 'hacklabr'); ?></option>
                            <option value="opiniao" <?php selected($_GET['tipo'], 'publicacao') ?>><?php _e('Publications', 'hacklabr'); ?></option>
                        </select>
                        <div class="select-icon-opinion"></div>
                    </div>
                </div>
            </div>
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
