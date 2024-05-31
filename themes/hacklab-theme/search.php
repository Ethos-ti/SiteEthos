<?php
get_header();
global $wp_query;

$post_type = (isset($wp_query->query_vars['post_type']) && !empty($wp_query->query_vars['post_type']) ) ? $wp_query->query_vars['post_type'] : ['post', 'page', 'publicacao', 'iniciativa'];

if($post_type == 'any'){
    $post_type = ['post', 'page', 'publicacao', 'iniciativa'];
}

if(!is_array($post_type)){
    $post_type = [$post_type];
}

$terms = get_terms_by_use_menu( 'category', ['iniciativa', 'post', 'publicacao'] );

$permalink = home_url( '?s=' . get_search_query( true ) );

$selected = '';

if ( isset( $_GET['post_type'] ) ) {
    $selected = sanitize_title( $_GET['post_type'] );
}

if($wp_query->get('category_name')){
    $active_tab = $wp_query->get('category_name');

}else{
    $active_tab = 'all';
}
?>


<div class="container container--wide">
    <?php get_template_part( 'template-parts/title/archive-header' ); ?>

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
                    <a class="tab" x-bind="TabButton('<?= esc_attr( $term->slug ); ?>', $data)" href="<?= esc_url( $permalink . '&category=' . $term->slug . '&post_type=' . implode(',', $post_type)); ?>">

                        <?php if($icon_url) :?>
                            <img src="<?php echo $icon_url ?>" alt="">
                        <?php endif; ?>
                        <?= esc_attr( $term->name ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="search__results">
                <div class="search__results__found">
                    <p  class="search__results__found-has-results"><?php _e('We found ', 'hacklabr');?><span><?= $wp_query->found_posts;?></span><?php _e(' results for this search.', 'hacklabr');?></p>
                    <?php if ( $wp_query->found_posts == 0 ) : ?>
                        <p class="search__results__found-no-results"><?php _e('This search yielded no results, do you want to perform a <span>new search</span>?', 'hacklabr');?></p>
                    <?php endif; ?>
                </div>
                <div class="search__results__filter">
                    <label for="tipo"><?php _e('', 'hacklabr'); ?></label>
                    <div class="custom-select-wrapper-opinion">
                        <?php
                        $current_permalink = $permalink;
                        if ( isset( $_GET['category'] ) && ! empty( $_GET['category'] ) ) {
                            $current_permalink .= '&category=' . esc_attr( $_GET['category'] );
                        }

                        ?>
                         <form name="search__results__filter__filering">
                            <select class="search__results__filter__filering__select-form" name="select" size="1" onChange="go()">
                                <option class="search__results__filter__filering__select-form__option" <?= ( $selected == 'any' ) ? 'selected' : '' ?> class="select-form-item" value="<?= $current_permalink; ?>"><?= __( '<span>Showing:</span> &nbsp &nbsp all contents', 'hacklabr' ) ?></option>
                                <?php foreach( ['iniciativa', 'post', 'publicacao'] as $post_type ) : ?>
                                    <option class="search__results__filter__filering__select-form__option" <?= ( $selected == $post_type ) ? 'selected' : '' ?> class="select-form-item" value="<?= $current_permalink; ?>&post_type=<?= $post_type; ?>"><?= $post_type; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <script type="text/javascript">
                                function go() {
                                    location = document.filering.select.options[document.filering.select.selectedIndex].value
                                }
                            </script>
                        </form>
                        <div class="select-icon-opinion"></div>
                    </div>
                </div>
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
        </div>
    <?php endif; ?>

</div><!-- /.container -->

<?php get_footer();
