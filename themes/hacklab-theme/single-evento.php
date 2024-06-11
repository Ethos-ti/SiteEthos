<?php
get_header();
the_post();
$category = get_the_category();
$excerpt = !empty($post->post_excerpt) ? wp_kses_post($post->post_excerpt) : '';

?>

<header class="post-header container container--wide">

    <h1 class="post-header__title"> <?php the_title(); ?> </h1>

    <?php if ( $excerpt ) : ?>
        <p class="post-header__excerpt container--narrow"><?= get_the_excerpt() ?></p>
    <?php endif; ?>

    <div class="post-header__meta container">
        <p class="post-header__date"><?php _e('Published in ', 'hacklabr') ?><?= get_the_date() ?></p>
        <?php get_template_part('template-parts/share-links', null, ['link' => get_the_permalink()]) ?>
    </div>

</header>

<main class="post-content stack container">
    <?php the_content() ?>
</main>





<?php get_footer() ?>
