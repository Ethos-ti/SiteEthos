<?php
get_header();

global $wp_query;
$post_type = get_queried_object()->name;

?>

    <div class="container container--wide">

        <?php
        if ( $post_type === 'publicacao' ) :
            echo hacklabr\get_layout_part( 'publicacoes', 'header' );
        elseif ( $post_type === 'iniciativa' ) :
            echo hacklabr\get_layout_part( 'atuacao', 'header' );
        elseif( $post_type === 'tribe_events' ) :
            echo hacklabr\get_layout_part( 'agenda', 'header' );
        elseif( is_tax('tipo_post', 'opinioes-e-analises') ) :
            echo hacklabr\get_layout_part( 'opiniao', 'header' );
        elseif( is_tax('tipo_post', 'posicionamento-institucional') ) :
            echo hacklabr\get_layout_part( 'posicionamentos-institucionais', 'header' );
        elseif( is_tax('tipo_post', 'novidades') ) :
            echo hacklabr\get_layout_part( 'novidades', 'header' );
        endif;
        ?>

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

    </div><!-- /.container -->

<?php get_footer();
