<?php
/**
 * The template for displaying all single posts
 */

get_header();
the_post();
$category = get_the_category();
$excerpt = !empty( $post->post_excerpt ) ? wp_kses_post( $post->post_excerpt ) : '';
?>

<header class="post-header container">
    <div class="post-header__featured-image">
        <?= get_the_post_thumbnail(null, 'post-thumbnail',['class'=>'post-header__featured-image']); ?>
    </div>

    <div class="post-header__tags">
        <a class="tag tag--<?= $category[0]->slug ?>" href="<?= get_term_link($category[0], 'category') ?>">
            <?= $category[0]->name ?>
        </a>
    </div>

    <h1 class="post-header__title"> <?php the_title(); ?> </h1>

    <?php if( $excerpt ) : ?>
        <p class="post-header__excerpt"><?= get_the_excerpt() ?></p>
    <?php endif; ?>

    <div class="post-header__meta container">
        <p class="post-header__date"><?php _e('Published in ', 'hacklabr') ?><?= get_the_date() ?></p>
        <?php get_template_part('template-parts/share-links', null, ['link'=>get_the_permalink()]) ?>
    </div>

    <div class="post-header__author container">
        <p class="post-header__author-name"><?php _e('Published by ', 'hacklabr') ?><?= get_the_author() ?></p>
    </div>
</header>

<main class="post-content container">
    <?php the_content() ?>
</main>

<?php get_template_part('template-parts/content/related-posts') ?>

<?php get_footer();
