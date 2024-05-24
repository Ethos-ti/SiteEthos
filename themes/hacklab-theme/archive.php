<?php
get_header();

global $wp_query;

$post_type = get_post_type() ?: 'post';

$terms = get_terms_by_use_menu( 'category', get_post_type() );

?>

    <div class="container container--wide">

        <?php
        if ( $post_type === 'publicacao' ) :
            echo hacklabr\get_layout_part( 'publicacoes', 'header' );
        elseif ( $post_type === 'iniciativa' ) :
            echo hacklabr\get_layout_part( 'atuacao', 'header' );
        elseif( is_tax('tipo_post', 'opinioes-e-analises') ) :
            echo hacklabr\get_layout_part( 'opiniao', 'header' );
        elseif( is_tax('tipo_post', 'posicionamento-institucional') ) :
            echo hacklabr\get_layout_part( 'posicionamentos-institucionais', 'header' );
        elseif( is_tax('tipo_post', 'novidades') ) :
            echo hacklabr\get_layout_part( 'novidades', 'header' );
        endif;
        ?>

        <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
            <ul class="archive-menu list-terms">
                <li class="archive-menu list-terms__term">
                    <a href="<?= esc_url( get_post_type_archive_link( $post_type ) ); ?>"><?php _e('All the areas', 'hacklabr') ?></a>
                </li>
                <?php foreach ( $terms as $term ) : ?>
                    <?php
                        $icon = get_term_meta($term->term_id, 'icon', true);
                        $icon_url = '';
                        if($icon){
                            $icon_url = wp_get_attachment_image_url($icon, 'thumbnail');
                        }
                    ?>
                    <li class="archive-menu list-terms__term archive-menu list-terms__term-<?= sanitize_title( $term->slug ); ?>">
                        <a href="<?= esc_url( get_term_link( $term->term_id, 'category' ) ); ?>?post_type=<?= $post_type; ?>">
                            <?php if($icon_url) :?>
                                <img src="<?php echo $icon_url ?>" alt="">
                            <?php endif; ?>
                            <?= esc_attr( $term->name ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

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
