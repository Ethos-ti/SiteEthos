<article class="card card--horizontal">
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

        <p class="card__excerpt">
            <?php the_excerpt(); ?>
        </p>
    </main>
</article>

<article class="card card--vertical">
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

        <p class="card__excerpt">
            <?php the_excerpt(); ?>
        </p>
    </main>
</article>

<article class="card card--cover">
    <header class="card__image">
        <a href="<?php the_permalink();?>"><?php the_post_thumbnail();?></a>
    </header>

    <main class="card__content">
        <h3 class="card__title">
            <a href="<?php the_permalink();?>"><?php the_title();?></a>
        </h3>

        <div class="card__meta">
              <div class="card__author">
                <?php the_author();?>
              </div>

              <time class="card__date">
                <?php echo get_the_date(); ?>
              </time>
        </div>

        <p class="card__excerpt">
            <?php the_excerpt(); ?>
        </p>
    </main>
</article>
