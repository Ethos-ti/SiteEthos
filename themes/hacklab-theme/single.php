<?php
/**
 * The template for displaying all single posts
 */

get_header();
the_post();
$category = get_the_category();
?>

<div class="container container--wide single">
    <div class="featured-image">
        <?= get_the_post_thumbnail(null, 'post-thumbnail',['class'=>'featured-image']); ?>
    </div>

    <div class="tags">
        <a class="tag tag--category-<?= $category[0]->slug ?>" href="<?= get_term_link($category[0], 'category') ?>">
            <?= $category[0]->name ?>
        </a>
    </div>

    <h1 class="single--title"> <?php the_title(); ?> </h1>

</div>

<?php get_footer();
