<?php

/**
 * Mount the title
 */
$title = '';
$search_query = get_search_query( false );

$is_curation = isset( $_GET['curadoria'] );

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
        <h1 class="archive-header__title-text">
            <?php if ( $is_curation ) : ?>
                <?= __( 'Selected content', 'hacklabr' ); ?>
            <?php else : ?>
                <?= __( 'Search results', 'hacklabr' ); ?>
            <?php endif; ?>
        </h1>
        <p>
            <?php echo apply_filters( 'the_title' , $title ); ?>
        <p>
        <?php
        if ( is_search() && ! $is_curation ) :
            get_search_form();
        endif; ?>
    </div>

</header><!-- /.c-title.title-default -->
