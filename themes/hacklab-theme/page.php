<?php
get_header();
$excerpt = !empty( $post->post_excerpt ) ? wp_kses_post( $post->post_excerpt ) : '';
?>
    <div class="container">
        <div class="post-header">
            <h1 class="post-header__title alignwide"><?php the_title() ?></h1>
            <?php if( $excerpt ) : ?>
                <p class="post-header__excerpt container container--normal"><?= get_the_excerpt() ?></p>
            <?php endif; ?>
        </div>
        <div class="post-content content stack">
            <?php the_content() ?>
        </div>
    </div>
<?php get_footer();
