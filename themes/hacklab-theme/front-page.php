<?php
get_header();
?>

<div class="index-wrapper">
    <div class="container container--wide">
        <div class="row">
            <?php get_template_part( 'template-parts/title/blog' ); ?>

            <div class="infos">
                <?php get_template_part( 'template-parts/filter', 'posts', ['taxonomy' => 'category'] ); ?>
            </div><!-- .infos -->

            <main class="">
                <?php dynamic_sidebar('widget-parceiros') ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content/post' ); ?>
                <?php endwhile; ?>

                <?php get_template_part( 'template-parts/content/pagination' ); ?>
            </main>

            <aside class="">
                <?php dynamic_sidebar( 'sidebar-posts' ) ?>
            </aside>
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.index-wrapper -->

<?php get_footer();
