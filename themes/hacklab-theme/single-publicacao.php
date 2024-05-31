<?php
    get_header();
    $categories = get_the_category();
?>
<div class="container container--wide book-detail">
    <aside class="stack">
        <div class="thumbnail thumbnail--vertical">
            <?php the_post_thumbnail('card-large'); ?>
        </div>
        <div>
            <a class= "button button--outline" href="">Amostra da publicação</a>
        </div>
    </aside>
    <main class="container container--wide">
        <?php if (!empty($categories)): ?>
            <div class="post-card__category">
                <?php foreach ($categories as $category): ?>
                    <a class="tag tag--solid tag--<?= $category->slug ?>" href="<?= get_term_link($category, 'category') ?>">
                        <?= $category->name ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="post-header post-header__title">

            <h1><?php the_title() ?></h1>
        </div>

        <div class="post-header__meta container ">
            <p class="post-header__date"><?php _e('Published in:', 'hacklabr') ?><?= get_the_date() ?></p>
            <?php get_template_part('template-parts/share-links', null, ['link'=>get_the_permalink()]) ?>
        </div>
        <div class="container">
            <p> <?php the_content() ?></p>

            <div class="form-book">
                <div class="form-book form-book__title">
                    <div class="icon">icone</div>
                    <h2>Solicite download gratuito</h2>
                </div>
                <div class="form-book--form-field">
                    <label for="fname"><?php _e('name', 'hacklabr') ?></label>
                    <input type="text" name="" class="text-input  form-book--input">
                    <label for="fname"><?php _e('e-mail', 'hacklabr') ?></label>
                    <input type="text" name="" class="text-input form-book--input">

                    <label class="form-book__check">
                        <input type="checkbox"><?php _e('I agree to receive newsletters from Instituto Ethos ', 'hacklabr') ?>
                    </label>
                    <label class="form-book__check">
                        <input type="checkbox"><?php _e('I agree to be contacted by Instituto Ethos ', 'hacklabr') ?>
                    </label>

                    <div class="button form-book--book-button"><a class= "button button--outline" href="">enviar</a></div>
                </div>
            </div>


        </div>

    </main>

</div>
<?php get_template_part('template-parts/content/related-posts-book') ?>


<?php get_footer() ?>