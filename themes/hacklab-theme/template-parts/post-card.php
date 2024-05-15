<?php
global $post;
$original_post = $post;
$post = $args['post'] ?? $post;

$image_size = $args['image_size'] ?? 'card-large';

$modifiers = (array) ($args['modifiers'] ?? []);
$modifiers = array_map(fn ($modifier) => "card--{$modifier}", $modifiers);
$modifiers = implode(' ', $modifiers);

$categories = get_the_category();
?>
<article class="card <?=$modifiers?>">
    <header class="card__image">
        <a href="<?php the_permalink();?>"><?php the_post_thumbnail($image_size); ?></a>
    </header>

    <main class="card__content">
        <?php if (!empty($categories)): ?>
            <div class="card__category">
                <?php foreach ($categories as $category): ?>
                    <a class="tag tag--solid tag--category-<?= $category->slug ?>" href="<?= get_term_link($category, 'category') ?>">
                        <?= $category->name ?>
                    </a>
                <?php endforeach; ?>
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
