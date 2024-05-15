<?php
get_header();

global $wp_query;
$totalposts = $wp_query->found_posts; ?>

    <div class="container container--wide">

            <?php get_template_part( 'template-parts/title/archive-header' ); ?>

            <div class="archive__infos">
                <div class="found-posts">
                    <p><?php _e('Resultados Encontrados: ', 'hacklabr');?><span><?php echo $totalposts;?></span></p>
                </div>

                <?php get_template_part( 'template-parts/filter', 'posts', ['taxonomy' => 'category'] ); ?>
            </div><!-- .infos -->

            <main class="archive__content col-md-9">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/post-card', 'vertical' ); ?>
                <?php endwhile; ?>
            </main>

            <?php the_posts_pagination([
                'prev_text' => __( '<iconify-icon icon="iconamoon:arrow-left-2-bold"></iconify-icon>', 'hacklbr'),
                'next_text' => __( '<iconify-icon icon="iconamoon:arrow-right-2-bold"></iconify-icon>', 'hacklbr'),

            ]); ?>

            <aside class="archive__sidebar col-md-3">
                <?php dynamic_sidebar( 'sidebar-default' ) ?>
            </aside>

    </div><!-- /.container -->

<?php get_footer();
