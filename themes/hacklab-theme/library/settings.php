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
