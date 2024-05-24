<?php

namespace hacklabr;

function add_associates_rewrite_rule() {
    add_rewrite_rule(
        '^associados/([^/]*)/?',
        'index.php?pagename=$matches[1]',
        'top'
    );
}
add_action( 'init', 'hacklabr\\add_associates_rewrite_rule' );

function modify_associates_permalink( $url, $post_id ) {
    if ( is_page() && get_page_template_slug( $post_id ) == 'template-associates-area.php' ) {
        $post_name = get_post_field( 'post_name', $post_id );

        if ( $post_name && strpos( $url, '/associados/' . $post_name ) === false ) {
            $url = home_url( '/associados/' . $post_name );
        }
    }

    return $url;
}
add_filter( 'page_link', 'hacklabr\\modify_associates_permalink', 10, 2 );

function redirect_associates_template() {
    if ( is_page() && get_page_template_slug() == 'template-associates-area.php' ) {

        /**
         * Redirects non-logged-in users to the login page
         * using the `pmpro_url()` function if available, or the home URL if not.
         */
        if ( ! is_user_logged_in() ) {
            $login_url = \function_exists( 'pmpro_url' ) && ( $pmpro_url = pmpro_url( 'login' ) ) ? $pmpro_url : home_url();

            wp_redirect( $login_url, 301 );
            exit;
        }

        $current_url = untrailingslashit( $_SERVER['REQUEST_URI'] );
        $new_url = home_url( '/associados/' . get_post_field( 'post_name', get_queried_object_id() ) );

        if ( strpos( $current_url, '/associados/' ) === false ) {
            wp_redirect( $new_url, 301 );
            exit;
        }
    }
}
add_action( 'template_redirect', 'hacklabr\\redirect_associates_template' );

function pmpro_login_redirect_url( $redirect_to, $request, $user ) {
    if ( ! \function_exists( 'pmpro_url' ) || empty( $user->ID ) ) {
        return $redirect_to;
    }

    global $wpdb;

    $is_member = $wpdb->get_var( "SELECT membership_id FROM $wpdb->pmpro_memberships_users WHERE status = 'active' AND user_id = '" . esc_sql( $user->ID ) . "' LIMIT 1" );
    if ( $is_member ) {

        $get_welcome_page = get_page_by_path( 'boas-vindas', OBJECT, 'page' );

        if ( $get_welcome_page ) {
            $template = get_page_template_slug( $get_welcome_page->ID );
            if ( $template == 'template-associates-area.php' ) {
                $redirect_to = get_permalink( $get_welcome_page->ID );
            }
        }

    }

    return $redirect_to;
}
add_filter( 'pmpro_login_redirect_url', 'hacklabr\\pmpro_login_redirect_url', 20, 3 );
