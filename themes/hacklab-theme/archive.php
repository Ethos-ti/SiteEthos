<?php
get_header(); ?>

    <div class="container container--wide">

            <?php get_template_part( 'template-parts/title/archive-header' ); ?>

            <div class="archive-header__infos">
                <?php get_template_part( 'template-parts/filter', 'posts', ['taxonomy' => 'category'] ); ?>
            </div><!-- .infos -->

            <main class="posts-grid__content">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/post-card', 'vertical' ); ?>
                <?php endwhile; ?>
            </main>

            <?php
            the_posts_pagination([
                'prev_text' => __( '<iconify-icon icon="iconamoon:arrow-left-2-bold"></iconify-icon>', 'hacklbr'),
                'next_text' => __( '<iconify-icon icon="iconamoon:arrow-right-2-bold"></iconify-icon>', 'hacklbr'),

            ]); ?>

            <aside class="archive__sidebar">
                <?php dynamic_sidebar( 'sidebar-default' ) ?>
            </aside>

    </div><!-- /.container -->

<?php get_footer();
