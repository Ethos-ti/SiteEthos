<?php

namespace hacklabr;

function register_shortcodes() {
    add_shortcode( 'nome-do-gerente', 'get_manager_name' );
    add_shortcode( 'nome-da-empresa', 'get_organization_name' );
}

add_action( 'init', 'hacklabr\\register_shortcodes' );

