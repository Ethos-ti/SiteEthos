<?php
/**
 * The template for displaying all single posts
 */

get_header();
the_post();
?>

<div class="container container--wide single">
    <div class="featured-image">
        <?= get_the_post_thumbnail(null, 'post-thumbnail',['class'=>'featured-image']); ?>
    </div>

    <h1> <?php the_title(); ?> </h1>

</div>

<?php get_footer();
