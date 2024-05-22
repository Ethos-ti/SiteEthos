<?php

namespace hacklabr;

/**
 * Redirect access to single Layout Archive to home
 */
function redirect_single_layout_archive() {
	if ( is_singular( 'layout-part' ) ) {
		$redirect_url = home_url();
		wp_redirect( $redirect_url );
		exit;
	}
}

add_action( 'template_redirect', 'hacklabr\\redirect_single_layout_archive' );

/**
 * Get the layout of the archive
 */
function get_layout_part( $slug, $position = 'header' ) {

    $return = false;
	$html = '';

	$args = [
		'post_type'  => 'layout-parts',
		'meta_key'   => 'archive',
		'meta_query' => [
			[
				'key'   => 'archive',
				'value' => $slug
            ],
            [
                'key'   => 'position',
                'value' => $position
            ]
		]
	];

	$wp_query = new \WP_Query( $args );

	if ( $wp_query && ! is_wp_error( $wp_query ) && $wp_query->post_count ) {
		$return =  $wp_query->posts[0];
	}

	if ( $return ) {
		$html .= '<div class="layout-part post-header position-' . $position . '">';
		$html .= apply_filters( 'the_content', $return->post_content );
		$html .=  '</div>';

		wp_reset_postdata();

		return $html;
	}

	wp_reset_postdata();

	return $return;

}

function get_layout_header( $slug ) {
	return get_layout_part( $slug, 'header' );
}

function get_layout_footer( $slug ) {
	return get_layout_part( $slug, 'footer' );
}
