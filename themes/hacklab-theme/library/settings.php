<?php

namespace hacklabr;

function get_default_card_model () {
    return 'vertical';
}

function get_card_models () {
    return [
        'cover' => [
            'slug' => 'cover',
            'label' => __('Cover card', 'hacklabr'),
        ],
        'horizontal' => [
            'slug' => 'horizontal',
            'label' => __('Horizontal card', 'hacklabr'),
        ],
        'vertical' => [
            'slug' => 'vertical',
            'label' => __('Vertical card', 'hacklabr'),
        ],
    ];
}

function get_card_modifiers () {
    return [];
}

function register_youtube_settings () {
    register_setting(
        'general',
        'youtube_key',
        'esc_attr'
    );

    add_settings_field(
        'youtube_key',
        '<label for="youtube_key">' . __( 'YouTube Key', 'hacklabr') . '</label>',
        'hacklabr\\youtube_key_html',
        'general'
    );
}
add_action( 'admin_init', 'hacklabr\\register_youtube_settings' );

function youtube_key_html() {
    $youtube_key_option = get_option( 'youtube_key', '' );
    echo '<input type="text" name="youtube_key" id="youtube_key" value="' . $youtube_key_option . '" autocomplete="off">';
    echo '<p><i>Crie uma chave de API do YouTube em <a href="https://console.cloud.google.com/apis/credentials">https://console.cloud.google.com/apis/credentials</a></i></p>';
}

