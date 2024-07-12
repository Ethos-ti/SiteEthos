<?php

namespace hacklabr;

function nome_do_gerente_shortcode ($attributes) {
    $attrs = shortcode_atts([
        'fallback' => '',
        'postid' => null,
    ], $attributes);

    if (!empty($attrs['postid'])) {
        $post_id = intval($attrs['postid']);
    } else {
        $post_id = null 
    }

    return get_manager_name($post_id) ?: $attrs['fallback'];
}

function nome_da_empresa_shortcode ($attributes) {
    $attrs = shortcode_atts([
        'fallback' => '',
        'postid' => null,
    ], $attributes);

    
    if (!empty($attrs['postid'])) {
        $post_id = intval($attrs['postid']);
    } else {
        $post_id = null;
    }

    return get_organization_name($post_id) ?: $attrs['fallback'];
}

function register_shortcodes() {
    add_shortcode( 'nome-do-gerente', 'hacklabr\\nome_do_gerente_shortcode' );
    add_shortcode( 'nome-da-empresa', 'hacklabr\\nome_da_empresa_shortcode' );
}

add_action( 'init', 'hacklabr\\register_shortcodes' );
