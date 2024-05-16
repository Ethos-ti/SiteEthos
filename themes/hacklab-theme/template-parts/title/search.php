<?php

/**
 * Get the search string
 */
$search_query = get_search_query( false );

if ( ! empty( $search_query ) ) {
    $title = 'Você pesquisou por: <span class="highlighted">' . esc_attr( $search_query  ) . '</span>';
} else {
    $title = 'Pesquisar';
} ?>

<header class="search__header">
    <div class="container">
        <h1 class="search__title">
            <?php echo apply_filters( 'the_title' , $title ); ?>
        </h1>
    </div>
</header><!-- /.c-title.title-search -->
