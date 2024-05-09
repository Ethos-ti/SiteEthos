<?php

namespace BaseThemeName;

function register_menus() {
    register_nav_menu( 'main-menu', __( 'Menu Principal', 'base-textdomain' ) );
    register_nav_menu( 'social-networks', __( 'Redes Sociais', 'base-textdomain' ) );
}

add_action( 'init', 'BaseThemeName\\register_menus' );

function add_menu_arrow( $output, $item, $depth, $args ) {
    // Only add class to 'top level' items on the 'primary' menu.
    if ( $depth === 0 ) {
        if ( in_array( 'menu-item-has-children', $item->classes ) ) {
            $output .= '<i class="arrow--down"></i>';
        }
    }
    return $output;
}

add_filter( 'walker_nav_menu_start_el', 'BaseThemeName\\add_menu_arrow', 10, 4 );

// Descomente para adicionar css para top menu (WIP)
// add_filter('css_files_before_output','BaseThemeName\\add_top_menu', 10, 1);
function add_top_menu($files){
    $files['top-menu'] = array(
        'file' => '_c-top-menu.css',
        'global' => true,
        'inline' => true,
    );
    return $files;
}
// Descomente para alterar menu para sempre funcionar como hamburguer
// add_filter('css_files_before_output','BaseThemeName\\sempre_hamburguer', 10, 1);
function sempre_hamburguer($files){
    $files['sempre-hamburguer'] = array(
        'file' => 'menu-sempre-hamburguer.css',
        'global' => true,
        'inline' => true,
    );
    return $files;
}

