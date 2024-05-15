<?php

/**
 * Mount the title
 */
$title = '';

if ( is_category() ) {
    $title = single_cat_title( '', false );
} else {
    $title = get_the_title();
} ?>

<header class="archive__header">
    <div class="archive__title">
        <h1>
            <?php echo apply_filters( 'the_title' , $title ); ?>
        </h1>
    </div>
    <div class="archive__excerpt">
        <?php the_excerpt(); ?>
    </div>
</header><!-- /.c-title.title-default -->
