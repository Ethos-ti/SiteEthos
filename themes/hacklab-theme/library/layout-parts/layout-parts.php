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
 * Get the layout part
 */
function get_layout_part( $position ) {

    $stack = [$position];

    $queried_object = get_queried_object();

    if ( is_archive() || is_home() ) {

        $stack[] = "{$position}--archive";

        if ( is_home() ) {

            $stack[] = "{$position}--home";

        } else if ( is_author() ) {

            /**
             * @var \WP_User $queried_object
             */

            $stack[] = "{$position}--author";
            $stack[] = "{$position}--author-{$queried_object->ID}";
            $stack[] = "{$position}--author-{$queried_object->user_nicename}";

        } else if ( is_category() || is_tag() || is_tax() ) {

            /**
             * @var \WP_Term $queried_object
             */

            $stack[] = "{$position}--taxonomy";

            if ( is_category() ) {

                $stack[] = "{$position}--category";
                $stack[] = "{$position}--category-{$queried_object->term_id}";
                $stack[] = "{$position}--category-{$queried_object->slug}";;

            } else if ( is_tag() ) {

                $stack[] = "{$position}--tag";
                $stack[] = "{$position}--tag-{$queried_object->term_id}";
                $stack[] = "{$position}--tag-{$queried_object->slug}";;

            } else if ( is_tax() ) {

                $stack[] = "{$position}--taxonomy-{$queried_object->taxonomy}";
                $stack[] = "{$position}--taxonomy-{$queried_object->taxonomy}-{$queried_object->term_id}";
                $stack[] = "{$position}--taxonomy-{$queried_object->taxonomy}-{$queried_object->slug}";

            }

        } else if ( is_post_type_archive() ) {

            /**
             * @var \WP_Post_Type $queried_object
             */

            $stack[] = "{$position}--archive-{$queried_object->name}";

        } else if ( is_date() ) {

            $stack[] = "{$position}--date";

        }

    } else if ( is_front_page() ) {

        /**
         * @var \WP_Post $queried_object
         */

        $stack[] = "{$position}--front-page";
        $stack[] = "{$position}--front-page-{$queried_object->ID}";
        $stack[] = "{$position}--front-page-{$queried_object->post_name}";

    } else if ( is_single() ) {

        /**
         * @var \WP_Post $queried_object
         */

        $stack[] = "{$position}--single";
        $stack[] = "{$position}--single-{$queried_object->ID}";
        $stack[] = "{$position}--single-{$queried_object->post_name}";

        if ( ! is_singular( 'post' ) ) {

            $stack[] = "{$position}--single-{$queried_object->post_type}";
            $stack[] = "{$position}--single-{$queried_object->post_type}-{$queried_object->ID}";
            $stack[] = "{$position}--single-{$queried_object->post_type}-{$queried_object->post_name}";

        }

    } else if ( is_page() ) {

        /**
         * @var \WP_Post $queried_object
         */

        $stack[] = "{$position}--page";
        $stack[] = "{$position}--page-{$queried_object->ID}";
        $stack[] = "{$position}--page-{$queried_object->post_name}";

        if ( is_page_template() ) {

            $template = get_page_template_slug();
            $template = str_replace( '.php', '', $template );

            $stack[] = "{$position}--page-template";
            $stack[] = "{$position}--page-template-{$template}";
            $stack[] = "{$position}--page-template-{$template}-{$queried_object->ID}";
            $stack[] = "{$position}--page-template-{$template}-{$queried_object->post_name}";

        }

    } else if ( is_404() ) {

        $stack[] = "{$position}--404";

    } else if ( is_search() ) {

        /**
         * @var \WP_Query $wp_query
         */

        global $wp_query;

        $stack[] = "{$position}--search";
        $stack[] = "{$position}--search-{$wp_query->query_vars['s']}";

        if ( ! $wp_query->post_count ) {
            $stack[] = "{$position}--search-no-results";
            $stack[] = "{$position}--search-no-results-{$wp_query->query_vars['s']}";
        }

    }

    $stack = array_reverse( $stack );

    $layout_part = get_posts( [
        'post_type'      => 'layout-part',
        'post_name__in'  => $stack,
        'order'          => 'post_name__in',
        'posts_per_page' => 1
    ] );
        
	if ( $layout_part ) {

        /**
         * @var \WP_Post $layout_part
         */
        $layout_part = $layout_part[0];

        $html = '<div class="layout-part layout-part--' . $layout_part->post_name . ' layout-part--position-' . $position . '">';
		$html .= apply_filters( 'the_content', $layout_part->post_content );
		$html .=  '</div>';

	} else {

        $html = '';

    }

	wp_reset_postdata();

	return $html;

}

function get_layout_part_header() {
	return get_layout_part( 'header' );
}

function get_layout_part_footer() {
	return get_layout_part( 'footer' );
}

function get_layout_part_sidebar() {
	return get_layout_part( 'sidebar' );
}
