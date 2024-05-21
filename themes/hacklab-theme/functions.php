<?php

namespace hacklabr;

require __DIR__ . '/library/supports.php';
require __DIR__ . '/library/sidebars.php';
require __DIR__ . '/library/menus.php';
require __DIR__ . '/library/settings.php';
require __DIR__ . '/library/assets.php';
require __DIR__ . '/library/search.php';
require __DIR__ . '/library/api/index.php';
require __DIR__ . '/library/sanitizers/index.php';
require __DIR__ . '/library/template-tags/index.php';
require __DIR__ . '/library/utils.php';
require __DIR__ . '/library/blocks/index.php';

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

// function wpdocs_unset_menu_items( $menu_objects, $args ) {

//     if ( 'main-menu' !== $args->theme_location ) {
//         return $menu_objects;
//     }

//     if ( is_user_logged_in() ) {
//         return $menu_objects;
//     }

//     $menu_items = array(
//         'entrar',
//         'associar',
//     );

//     foreach ( $menu_objects as $key => $menu_object ) {
//         if ( ! in_array( $menu_object->title, $menu_items ) ) {
//             continue;
//         }

//         unset( $menu_objects[ $key ] );
//     }

//     return $menu_objects;
// }
// add_filter( 'wp_nav_menu_objects', 'hacklabr\\wpdocs_unset_menu_items', 10, 2 );
