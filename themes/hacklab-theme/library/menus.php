<?php

namespace hacklabr;

function register_menus() {
    register_nav_menu( 'main-menu', __( 'Menu Principal', 'hacklabr' ) );
    register_nav_menu( 'social-networks', __( 'Redes Sociais', 'hacklabr' ) );
}

add_action( 'init', 'hacklabr\\register_menus' );

function add_menu_arrow( $output, $item, $depth, $args ) {
    // Only add class to 'top level' items on the 'primary' menu.
    if ( $depth === 0 ) {
        if ( in_array( 'menu-item-has-children', $item->classes ) ) {
            $output .= '<iconify-icon icon="fa6-solid:angle-down"></iconify-icon>';
        }
    }
    return $output;
}

add_filter( 'walker_nav_menu_start_el', 'hacklabr\\add_menu_arrow', 10, 4 );
