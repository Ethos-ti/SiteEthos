<?php
get_header();
?>


<div class="container container--wide">
    <?php get_template_part( 'template-parts/title/archive-header' ); ?>

    <main class="posts-grid__content">
        <?php
        if ( have_posts() ) {
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post-card', 'vertical' );
            endwhile;
        } else {
            get_template_part( 'template-parts/content/no-post' );
        }; ?>
    </main>

    <?php
    the_posts_pagination([
        'prev_text' => __( '<iconify-icon icon="iconamoon:arrow-left-2-bold"></iconify-icon>', 'hacklbr'),
        'next_text' => __( '<iconify-icon icon="iconamoon:arrow-right-2-bold"></iconify-icon>', 'hacklbr'),

    ]); ?>

    <aside class="">
        <?php dynamic_sidebar( 'sidebar-search' ) ?>
    </aside>
</div><!-- /.container -->


<?php get_footer();
