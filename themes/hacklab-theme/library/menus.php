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


//Hide menu item if logged
function hide_menu_item_if_logged_in_ethos($items, $menu, $args) {
    if (is_user_logged_in() && !is_admin() ) {
        $class_to_hide = [
            'entrar',
            'quero-me-associar',
        ];

        $hiden_itens = [];

        foreach ($items as $item) {
            foreach ($item->classes as $class) {
                if (in_array($class, $class_to_hide)) {
                    $hiden_itens[] = $item->ID;
                }
            }

            if (in_array($item->menu_item_parent, $hiden_itens)) {
                $hiden_itens[] = $item->ID;
            }

        }

        foreach ($items as $key => $item) {
            if (in_array($item->ID, $hiden_itens)) {
                unset($items[$key]);
            }
        }

    } else {
        if ( !is_admin() ) {
            $class_to_hide = ['area-do-associado'];
            $hiden_itens = [];

            foreach ($items as $item) {
                foreach ($item->classes as $class) {
                    if (in_array($class, $class_to_hide)) {
                        $hiden_itens[] = $item->ID;
                    }
                }

                if (in_array($item->menu_item_parent, $hiden_itens)) {
                    $hiden_itens[] = $item->ID;
                }
            }

            foreach ($items as $key => $item) {
                if (in_array($item->ID, $hiden_itens)) {
                    unset($items[$key]);
                }
            }
        }
    }

    return $items;
}
add_filter('wp_get_nav_menu_items', 'hacklabr\\hide_menu_item_if_logged_in_ethos', 10, 3);
