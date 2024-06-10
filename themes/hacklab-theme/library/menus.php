<?php

namespace hacklabr;

function register_menus() {
    register_nav_menu( 'main-menu', __( 'Main menu', 'hacklabr' ) );
    register_nav_menu( 'social-networks', __( 'Social networks', 'hacklabr' ) );
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

//Hide menu item if logged
function hide_menu_item_if_logged_in_ethos($items, $menu, $args) {
    if (is_user_logged_in()) {
        // Altere 'classe-do-item-a-esconder' para a classe do item de menu que você deseja esconder
        $class_to_hide = [
            'login',
            'associar',
        ];

        foreach ($items as $key => $item) {
            foreach ($class_to_hide as $class) {
                if (in_array($class, $item->classes)) {
                    unset($items[$key]);
                    break;
                }
            }

        }
    } else {
        $class_to_hide = 'area-associado';

        foreach ($items as $key => $item) {
            if (in_array($class_to_hide, $item->classes)) {
                unset($items[$key]);
            }
        }
    }

    return $items;
}
add_filter('wp_get_nav_menu_items', 'hacklabr\\hide_menu_item_if_logged_in_ethos', 10, 3);
