<?php

namespace hacklabr;

require __DIR__ . '/includes/helpers.php';

function get_blocks_list () {
    return [
        'posts-grid' => [
            'render_callback' => 'hacklabr\\render_post_grid_callback',
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

function add_dependencies_to_blocks () {
    global $wp_scripts;

    $assets_meta = require __DIR__ . '/../../dist/assets.php';
    $blocks = get_blocks_list();

    foreach ($blocks as $block_id => $block_args) {
        $script_handle = 'hacklabr-' . $block_id . '-editor-script';
        $script_path = '/blocks/' . $block_id . '/editor.js';

        if (isset($wp_scripts->registered[$script_handle]) && isset($assets_meta[$script_path])) {
            $script = $wp_scripts->registered[$script_handle];

            foreach ($assets_meta[$script_path]['dependencies'] as $dep) {
                $script->deps[] = $dep;
            }
        }
    }
}

add_action('admin_enqueue_scripts', 'hacklabr\\add_dependencies_to_blocks', 11);
add_action('init', 'hacklabr\\initialize_blocks');
