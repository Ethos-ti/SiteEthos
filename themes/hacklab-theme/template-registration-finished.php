<?php
/**
 * Template Name: Member registration finished
 */

get_header();
$excerpt = !empty( $post->post_excerpt ) ? wp_kses_post( $post->post_excerpt ) : '';
?>
    <div class="container">
        <div class="post-header">
            <h1 class="post-header__title alignwide"><?php the_title() ?></h1>
        </div>
        <div class="post-content content stack">
            <?php the_content() ?>
        </div>
    </div>
<?php get_footer();
