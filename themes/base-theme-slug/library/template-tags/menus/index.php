<?php

function the_social_networks_menu( $color = true ) {
    $menu_items = get_menu_by_position( 'social-networks' );

    if ( ! $menu_items ) {
        return;
    }

    $icons_directory = get_template_directory() . '/assets/images/social-networks/';

    echo '<div class="social-menu">';

        foreach ( $menu_items as $item ) {
			$network_name = $item->post_title;
			$network_slug = sanitize_title( $network_name );
			$html = '';

            if ( $color ) {
				if ( ! file_exists( $icons_directory . $network_slug . '-color.svg' ) ) {
					continue;
				}

				$html = file_get_contents( $icons_directory . $network_slug . '-color.svg' );
            } else {
				if ( ! file_exists( $icons_directory . $network_slug . '.svg' ) ) {
					continue;
				}

				$html = file_get_contents( $icons_directory . $network_slug . '.svg' );
            }

			if ( $html ) {
				echo '<div class="social-menu__icon icon-' . $network_slug . '">';
				echo '<a href="' . $item->url . '" title="' . $network_name .'" target="_blank">' . $html . '</a>';
				echo '</div>';
			}
        }

    echo '</div>';
}

function get_menu_by_position( $slug ) {
    $theme_locations = get_nav_menu_locations();
    if ( isset( $theme_locations[$slug] ) ) {
        $menu_obj = get_term( $theme_locations[$slug], 'nav_menu' );
        if ( ! $menu_obj instanceof \WP_Error ) {
            return wp_get_nav_menu_items( $menu_obj->name );
        }
    }

    return false;
}
