<?php
global $post;
$original_post = $post;
$post = $args['post'] ?? $post;

$image_size = $args['image_size'] ?? 'card-large';

$modifiers = (array) ($args['modifiers'] ?? []);
$modifiers = array_map(fn ($modifier) => "card--{$modifier}", $modifiers);
$modifiers = implode(' ', $modifiers);

$category = get_the_category();
?>
<article class="card <?=$modifiers?>">
    <header class="card__image">
        <a href="<?php the_permalink();?>"><?php the_post_thumbnail($image_size); ?></a>
    </header>

    <main class="card__content">
        <?php if (!empty($category)): ?>
            <div class="card__category">
                <a class="tag tag--solid" href="<?= get_term_link($category[0], 'category') ?>">
                    <?= $category[0]->name ?>
                </a>
            </div>
        <?php endif; ?>

        <h3 class="card__title">
            <a href="<?php the_permalink();?>"><?php the_title();?></a>
        </h3>

        <div class="card__meta">
              <div class="card__author">
                <?php the_author(); ?>
              </div>

              <time class="card__date">
                <?php echo get_the_date(); ?>
              </time>
        </div>

        <div class="card__excerpt">
            <?= get_the_excerpt(); ?>
        </div>
    </main>
</article>

<?php
$post = $original_post;
