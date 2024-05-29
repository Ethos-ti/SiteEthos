<?php

/**
 * Mount the title
 */
$title = '';
$search_query = get_search_query( false );

// if ( is_category() ) {
//     $title = single_cat_title( '', false );
// } else {
//     $title = get_the_title();
// };

// if ( ! empty( $search_query ) ) {
//     $title = 'Termo buscado: <span class="highlighted">' . esc_attr( $search_query  ) . '</span>';
// } else {
//     $title = 'Pesquisar';
// };?>

<header class="archive-header__content">
    <div class="archive-header__title">
        <h1>
            <?php _e('Search results', 'hacklabr');?>
        </h1>
        <p>
            <?php echo apply_filters( 'the_title' , $title ); ?>
        <p>
        <?php
        if ( is_search() ) :
            get_search_form();
        endif; ?>
    </div>

    <div class="archive-header__excerpt">
        <?php the_archive_description(); ?>
    </div>

    <div class="archive-header__results">
        <p><?php _e('We found ', 'hacklabr');?><span><?= $wp_query->found_posts;?></span><?php _e(' results for this search.', 'hacklabr');?></p>
    </div>
</header><!-- /.c-title.title-default -->
