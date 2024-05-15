<?php
/**
 * The template for displaying all single posts
 */

get_header();
the_post();
$category = get_the_category();
?>

<div class="container container--wide single">
    <div class="post-header">
        <div class="post-header__featured-image">
            <?= get_the_post_thumbnail(null, 'post-thumbnail',['class'=>'post-header__featured-image']); ?>
        </div>

        <div class="post-header__tags">
            <a class="tag tag--category-<?= $category[0]->slug ?>" href="<?= get_term_link($category[0], 'category') ?>">
                <?= $category[0]->name ?>
            </a>
        </div>

        <h1 class="post-header__title"> <?php the_title(); ?> </h1>

        <p class="post-header__excerpt container container--narrow"><?= get_the_excerpt() ?></p>

        <div class="post-header__meta container container--narrow">
            <p class="post-header__date"><?= _e('Publicado em: ') ?><?= get_the_date() ?></p>
            <?php get_template_part('template-parts/share-links', null, ['link'=>get_the_permalink()]) ?>
        </div>

        <div class="post-header__author container container--narrow">
            <p class="post-header__author-name"><?= _e('Publicado por: ') ?><?= get_the_author() ?></p>
        </div>

        <div class="post-content container container--narrow">
            <?php the_content() ?>
        </div>

    </div>

</div>
<?php get_footer();
