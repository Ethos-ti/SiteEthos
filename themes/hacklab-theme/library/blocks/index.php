<?php

namespace hacklabr;

require __DIR__ . '/includes/helpers.php';

function get_blocks_list () {
    return [
        'posts-grid' => [
            'render_callback' => 'hacklabr\\render_posts_grid_callback',
        ],
    ];
}

function initialize_blocks () {
    $blocks_folder = get_stylesheet_directory() . '/library/blocks';

    $blocks = get_blocks_list();

    foreach ($blocks as $block_id => $block_args) {
        $args = [];

        if ($block_args) {
            include $blocks_folder . '/' . $block_id . '/' . $block_id . '.php';
            foreach ($block_args as $key => $value) {
                $args[$key] = $value;
            }
        }

        register_block_type($blocks_folder . '/' . $block_id, $args);
    }
}

add_action('init', 'hacklabr\\initialize_blocks');
