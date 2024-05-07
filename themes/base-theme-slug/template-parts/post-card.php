<?php
global $post;
$original_post = $post;
$post = $args['post'] ?? $post;

$modifiers = (array) $args['modifiers'] ?? [];
$modifiers = array_map(function ($modifier) { return "card--{$modifier}"; }, $modifiers);
$modifiers = implode(' ', $modifiers); ?>

<article class="card <?=$modifiers?>">
    <header class="card__image">
        <a href="<?php the_permalink();?>"><?php the_post_thumbnail();?></a>
    </header>

    <main class="card__content">
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
            <?php the_excerpt(); ?>
        </div>
    </main>
</article>

<?php
$post = $original_post; ?>
