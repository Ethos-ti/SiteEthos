<?php

/**
 * Get term by slug
 */
function get_term_by_slug( $term_slug ) {
    $term_object = "";
    $taxonomies = get_taxonomies();
    foreach ( $taxonomies as $tax_type_key => $taxonomy ) {
        // If term object is returned, break out of loop. (Returns false if there's no object);
        if ( $term_object = get_term_by( 'slug', $term_slug, $taxonomy ) ) {
            break;
        } else {
            $term_object = false;
        }
    }

    return $term_object;
}

/**
 *
 * Create list of the terms by taxonomy
 *
 * @param int $post_id Post ID
 * @param string $tax Slug tax to get terms
 * @param bool $use_link Define if is use link to the terms
 *
 * @link https://developer.wordpress.org/reference/functions/get_the_terms/
 * @link https://developer.wordpress.org/reference/functions/sanitize_title/
 * @link https://developer.wordpress.org/reference/functions/esc_url/
 * @link https://developer.wordpress.org/reference/functions/get_term_link/
 *
 * @return string $html
 *
 */
function get_html_terms( int $post_id, string $tax, bool $use_link = false ) {

    $terms = get_the_terms( $post_id, sanitize_title( $tax ) );

    if ( ! $terms || is_wp_error( $terms ) ) {
        return false;
    }

    $html = '<ul class="list-terms tax-' . sanitize_title( $tax ) . '">';

    foreach ( $terms as $term ) {

        $html .= '<li class="term-' . sanitize_title( $term->slug ) . '">';

        if ( $use_link ) {
            $html .= '<a href="' . esc_url( get_term_link( $term->term_id, $tax ) ) . '">';
        }

        $html .= esc_attr( $term->name );

        if ( $use_link ) {
            $html .= '</a>';
        }

        $html .= '</li>';

    }

    $html .= '</ul>';

    return $html;

}

/**
 * Return string of the terms to use on html class
 *
 * @param int $post_id Post ID
 * @param string $tax Slug tax to get terms
 * @param string $prefix Set prefix to each term
 *
 * @link https://developer.wordpress.org/reference/functions/get_the_terms/
 * @link https://developer.wordpress.org/reference/functions/sanitize_title/
 */
function get_terms_like_class( int $post_id, string $tax, string $prefix = '' ) {

    $terms = get_the_terms( $post_id, sanitize_title( $tax ) );
    $class = '';

    if ( $terms && ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            $class .= ( $prefix ) ? $prefix . $term->slug : $term->slug;
            $class .= ' ';
        }

        return sanitize_title( substr( $class, 0, -1 ) );
    }

    return '';

}

/**
 * Get terms by post type
 */
function get_terms_by_post_type( $taxonomy, $post_type ) {

    // Get all terms that have posts
    $terms = get_terms( [
        'hide_empty' => true,
        'taxonomy'   => $taxonomy
    ] );

    // Remove terms that don't have any posts in the current post type
    $terms = array_filter( $terms, function ( $term ) use ( $post_type, $taxonomy ) {
        $posts = get_posts( [
            'fields'      => 'ids',
            'numberposts' => 1,
            'post_type'   => $post_type,
            'tax_query'   => [
                [
                    'taxonomy' => $taxonomy,
                    'terms'    => $term,
                ]
            ]
        ]) ;

        return ( count( $posts ) > 0 );
    } );

    return $terms;

}
