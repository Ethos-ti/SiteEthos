<?php
get_header();

global $wp_query;

$post_type = get_post_type() ?: 'post';

// Obter o termo atual da taxonomia 'tipo_post'
$tipo_post_term = get_queried_object();
$tipo_post_slug = $tipo_post_term->slug;

// Obter termos da taxonomia 'category'
$terms = get_terms_by_use_menu('category', get_post_type());

$active_tab = isset($wp_query->query['category']) ? $wp_query->query['category'] : 'all';


if($wp_query->get('category')){
    $active_tab = $wp_query->get('category');
} else {
    $active_tab = 'all';
}

$desired_order = [ 'DIREITOS HUMANOS', 'INTEGRIDADE', 'GESTÃO SUSTENTÁVEL', 'MEIO AMBIENTE', 'INSTITUCIONAL' ];

function custom_sort($a, $b) {
    global $desired_order;
    $pos_a = array_search($a->name, $desired_order);
    $pos_b = array_search($b->name, $desired_order);

    if ($pos_a === false && $pos_b === false) {
        return 0;
    } elseif ($pos_a === false) {
        return 1;
    } elseif ($pos_b === false) {
        return -1;
    } else {
        return $pos_a - $pos_b;
    }
}

usort($terms, 'custom_sort');

?>
<div class="container container--wide">

    <?php echo hacklabr\get_layout_part_header(); ?>

    <?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
        <div class="tabs" x-data="{ currentTab: '<?php echo esc_attr($active_tab); ?>' }" x-bind="Tabs($data)">
            <div class="tabs__header" role="tablist">
                <a class="tab" x-bind="TabButton('all', $data)" href="<?= esc_url(add_query_arg(array('post_type' => $post_type, 'tipo_post' => $tipo_post_slug), get_post_type_archive_link($post_type))); ?>"><?php _e('All the themes', 'hacklabr') ?></a>
                <?php foreach ( $terms as $term ) : ?>
                    <a class="tab" x-bind="TabButton('<?= esc_attr($term->slug); ?>', $data)" href="<?= esc_url(add_query_arg(array('post_type' => $post_type, 'tipo_post' => $tipo_post_slug, 'category' => $term->slug), get_post_type_archive_link($post_type))); ?>">
                        <?= esc_attr($term->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="tabs__panels">
                <div class="tabs__panel" x-bind="TabPanel('<?php echo esc_attr($active_tab); ?>', $data)">
                    <main class="posts-grid__content">
                        <?php
                        // Verificação dos parâmetros
                        $current_category = get_query_var('category');
                        $current_tipo_post = get_query_var('tipo_post');

                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                        $args = array(
                            'post_type' => 'post',
                            'tax_query' => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy' => 'tipo_post',
                                    'field' => 'slug',
                                    'terms' => $current_tipo_post,
                                ),
                            ),
                            'paged' => $paged,
                        );

                        // Adicionar filtro de categoria se estiver presente
                        if ($current_category) {
                            $args['tax_query'][] = array(
                                'taxonomy' => 'category',
                                'field' => 'slug',
                                'terms' => $current_category,
                            );
                        }

                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post();
                                get_template_part('template-parts/post-card', null, [
                                    'hide_author' => true,
                                    'hide_date' => true,
                                    'hide_excerpt' => true,
                                    'show_taxonomies' => ['tipo_iniciativa'],
                                ]);
                            endwhile;
                            wp_reset_postdata();

                        endif;
                        ?>
                    </main>

                    <?php
                    the_posts_pagination([
                        'prev_text' => '<iconify-icon icon="fa-solid:angle-left" aria-label="' . __('Previous page') . '"></iconify-icon>',
                        'next_text' => '<iconify-icon icon="fa-solid:angle-right" aria-label="' . __('Next page') . '"></iconify-icon>',
                    ]); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div><!-- /.container -->

<?php get_footer(); ?>
