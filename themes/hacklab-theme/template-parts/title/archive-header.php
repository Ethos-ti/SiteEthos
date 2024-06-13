<?php

/**
 * Mount the title
 */
$title = '';
$search_query = get_search_query( false );

if ( is_category() ) {
    $title = single_cat_title( '', false );
} else {
    $title = get_the_title();
};

if ( ! empty( $search_query ) ) {
    $title = 'Você pesquisou por: <span class="highlighted">' . esc_attr( $search_query  ) . '</span>';
} else {
    $title = 'Pesquisar';
};?>

<header class="archive-header__content">
    <div class="archive-header__title">
        <h1>
            <?php echo apply_filters( 'the_title' , $title ); ?>
        </h1>
        <?php
        if ( is_search() ) :
            get_search_form();
        endif; ?>
    </div>

    <div class="archive-header__excerpt">
        <?php the_archive_description(); ?>
    </div>

    <div class="archive-header__results">
        <p><span><?= $wp_query->found_posts;?></span><?php _e(' Results Found', 'hacklabr');?></p>
    </div>
</header><!-- /.c-title.title-default -->
