<?php
    get_header();
?>
<div class="container container--wide book-detail">
    <aside class="stack">
        <div class="thumbnail thumbnail--vertical">
            <?php the_post_thumbnail('card-large'); ?>
        </div>
        <div class="btn"></div>
            <a class= "button button--outline" href="">Amostra da publicação</a>
        </p>
    </aside>
    <main class="container container--wide">
        <div class="post-header post-header__title">
            <h1><?php the_title() ?></h1>
        </div>

        <div class="post-header__meta container ">
            <p class="post-header__date"><?php _e('Published in:', 'hacklabr') ?><?= get_the_date() ?></p>
            <?php get_template_part('template-parts/share-links', null, ['link'=>get_the_permalink()]) ?>
        </div>
        <div class="container">
            <p> <?php the_content() ?></p>
        </div>

    </main>
</div>

<?php get_footer() ?>
