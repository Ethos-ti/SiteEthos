<?php
/**
 *
 * Remove recaptcha from tainacan
 *
 */
add_action( 'init', function() {
    wp_dequeue_script( 'tainacan-google-recaptcha-script' );
}, 150 );

/**
 * Print the excerpt with limit words
 */
function get_custom_excerpt( $post_id = '', $limit = 30 ) {

    if ( empty( $post_id ) ) {
        $post_id = get_the_ID();
    }

    // If exists excerpt metadata
    $excerpt = get_post_meta( $post_id, 'excerpt', true );

    if ( empty( $excerpt ) ) {
        $excerpt = get_the_excerpt( $post_id );
    }

    if ( empty( $excerpt ) ) {
        $excerpt = wp_trim_excerpt( '', $post_id );
    }

    $excerpt = wp_strip_all_tags( $excerpt );
    $excerpt = explode( ' ', $excerpt, $limit );

    if ( count( $excerpt ) >= $limit ) {
        array_pop( $excerpt );
        $excerpt = implode( ' ', $excerpt ) . ' ...';
    } else {
        $excerpt = implode( ' ', $excerpt );
    }

    return $excerpt;

}

/**
 * Rename the defaults taxonomies
 */
function rename_taxonomies() {

    // Tags -> Temas
    $post_tag_args = get_taxonomy( 'post_tag' );

    $post_tag_args->label = 'Temas';
    $post_tag_args->labels->name = 'Temas';
    $post_tag_args->labels->singular_name = 'Tema';
    $post_tag_args->labels->search_items = 'Pesquisar tema';
    $post_tag_args->labels->popular_items = 'Temas populares';
    $post_tag_args->labels->all_items = 'Todos temas';
    $post_tag_args->labels->parent_item = 'Tema superior';
    $post_tag_args->labels->edit_item = 'Editar tema';
    $post_tag_args->labels->view_item = 'Ver tema';
    $post_tag_args->labels->update_item = 'Atualizar tema';
    $post_tag_args->labels->add_new_item = 'Adicionar novo tema';
    $post_tag_args->labels->new_item_name = 'Nome do novo tema';
    $post_tag_args->labels->separate_items_with_commas = 'Separe os temas com vírgulas';
    $post_tag_args->labels->add_or_remove_items = 'Adicionar ou remover temas';
    $post_tag_args->labels->choose_from_most_used = 'Escolha entre os temas mais usados';
    $post_tag_args->labels->not_found = 'Nenhum tema encontrado';
    $post_tag_args->labels->no_terms = 'Nenhum tema';
    $post_tag_args->labels->items_list_navigation = 'Navegação da lista de temas';
    $post_tag_args->labels->items_list = 'Lista de temas';
    $post_tag_args->labels->most_used = 'Temas mais utilizados';
    $post_tag_args->labels->back_to_items = '&larr; Ir para os temas';
    $post_tag_args->labels->item_link = 'Link do tema';
    $post_tag_args->labels->item_link_description = 'Um link para o tema';
    $post_tag_args->labels->menu_name = 'Temas';
    $post_tag_args->hierarchical = true;

    $object_type = array_merge( $post_tag_args->object_type, ['page'] );
    $object_type = array_unique( $object_type );

    register_taxonomy( 'post_tag', $object_type, (array) $post_tag_args );

    // Category -> Projetos
    $category_args = get_taxonomy( 'category' );

    $category_args->label = 'Projetos';
    $category_args->labels->name = 'Projetos';
    $category_args->labels->singular_name = 'Projeto';
    $category_args->labels->search_items = 'Pesquisar Projeto';
    $category_args->labels->popular_items = 'Projetos populares';
    $category_args->labels->all_items = 'Todos Projetos';
    $category_args->labels->parent_item = 'Projeto superior';
    $category_args->labels->edit_item = 'Editar Projeto';
    $category_args->labels->view_item = 'Ver Projeto';
    $category_args->labels->update_item = 'Atualizar Projeto';
    $category_args->labels->add_new_item = 'Adicionar novo Projeto';
    $category_args->labels->new_item_name = 'Nome do novo Projeto';
    $category_args->labels->separate_items_with_commas = 'Separe os Projetos com vírgulas';
    $category_args->labels->add_or_remove_items = 'Adicionar ou remover Projetos';
    $category_args->labels->choose_from_most_used = 'Escolha entre os Projetos mais usados';
    $category_args->labels->not_found = 'Nenhum Projeto encontrado';
    $category_args->labels->no_terms = 'Nenhum Projeto';
    $category_args->labels->items_list_navigation = 'Navegação da lista de Projetos';
    $category_args->labels->items_list = 'Lista de Projetos';
    $category_args->labels->most_used = 'Projetos mais utilizados';
    $category_args->labels->back_to_items = '&larr; Ir para os Projetos';
    $category_args->labels->item_link = 'Link do Projeto';
    $category_args->labels->item_link_description = 'Um link para o Projeto';
    $category_args->labels->menu_name = 'Projetos';

    $object_type = array_merge( $category_args->object_type, ['page'] );
    $object_type = array_unique( $object_type );

    register_taxonomy( 'category', $object_type, (array) $category_args );

}
// Descomentar para renomear as taxonomias padrão do WP
// add_action( 'init', 'rename_taxonomies', 11 );

// Page Slug Body Class
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

/**
 * Return the structure HTML of the posts separetade by month
 *
 * @param array $args use params of the class WP_Query
 * @link https://developer.wordpress.org/reference/classes/wp_query/#parameters
 *
 * @return array months|slider
 */
function get_posts_by_month( $args = [] ) {

    $args['orderby'] = 'date';

    $items = new WP_Query( $args );

    if( $items->have_posts() ) :

        $month_titles   = [];
        $close_ul       = false;
        $content_slider = '';

        while( $items->have_posts() ) : $items->the_post();

            $month_full = [
                'Jan' => 'Janeiro',
                'Feb' => 'Fevereiro',
                'Mar' => 'Marco',
                'Apr' => 'Abril',
                'May' => 'Maio',
                'Jun' => 'Junho',
                'Jul' => 'Julho',
                'Aug' => 'Agosto',
                'Nov' => 'Novembro',
                'Sep' => 'Setembro',
                'Oct' => 'Outubro',
                'Dec' => 'Dezembro'
            ];

            $year = date( 'Y', strtotime( get_the_date( 'Y-m-d H:i:s' ) ) );
            $month = date( 'M', strtotime( get_the_date( 'Y-m-d H:i:s' ) ) );

            $month_title = $month_full[$month] . ' ' . $year;

            if ( ! in_array( $month_title, $month_titles ) ) :
                if ( $close_ul ) $content_slider .= '</ul>';
                $content_slider .= '<ul id="items-' . sanitize_title( $month_title ) . '" class="item-slider">';
                $month_titles[] = $month_title;
                $close_ul = true;
            endif;

            $thumbnail = ( has_post_thumbnail( get_the_ID() ) ) ? get_the_post_thumbnail( get_the_ID() ) : '<img src="' . get_stylesheet_directory_uri() . '/assets/images/default-image.png">';

            $content_slider .= sprintf(
                '<li id="item-%1$s" class="item item-month-%2$s"><a href="%3$s"><div class="thumb">%4$s</div><div class="title"><h3>%5$s</h3></div></a></li>',
                get_the_ID(),
                $month_title,
                get_permalink( get_the_ID() ),
                $thumbnail,
                get_the_title( get_the_ID() )
            );

        endwhile;

        if ( $close_ul ) $content_slider .= '</ul>';
    endif;

    return [
        'months' => $month_titles,
        'slider' => $content_slider
    ];

}

function allow_svg_uploads( $file_types ){
	$file_types['svg'] = 'image/svg+xml';
	return $file_types;
}
add_filter( 'upload_mimes', 'allow_svg_uploads' );

function archive_filter_posts( $query ) {
    // Apply filter of the archives
    if ( $query->is_main_query() && ! is_admin() ) {

        $is_blog = false;
        $page_for_posts = get_option( 'page_for_posts' );

        if ( $query->is_home() && isset( $query->get_queried_object()->ID ) && $query->get_queried_object()->ID == $page_for_posts ) {
            $is_blog = true;
        }

        if ( is_archive() || $is_blog ) {
            if ( isset( $_GET['filter_term'] ) && 'all' !== $_GET['filter_term'] ) {
                $term = get_term_by_slug( $_GET['filter_term'] );

                if ( $term && ! is_wp_error( $term ) ) {
                    $tax_query = [
                        [
                            'field'    => 'slug',
                            'taxonomy' => $term->taxonomy,
                            'terms'    => [ $term->slug ]
                        ]
                    ];

                    $query->set( 'tax_query', $tax_query );
                }
            }
        }
    }
}
add_action( 'pre_get_posts', 'archive_filter_posts' );
