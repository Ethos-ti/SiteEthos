<?php

namespace hacklabr;

require __DIR__ . '/includes/helpers.php';

function get_blocks_list () {
    return [
        'banner-with-image' => null,
        'card' => null,
        'card-body' => null,
        'card-header' => null,
        'posts-grid' => [
            'render_callback' => 'hacklabr\\render_posts_grid_callback',
        ],
        'read-more' => null,
        'video-playlist' => [
           'render_callback' => 'hacklabr\\render_video_playlist_callback',
        ]
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

function localize_block_scripts () {
    $blocks = get_blocks_list();

    $language_path = get_stylesheet_directory() . '/languages';

    if (is_admin()) {
        $fields = ['script', 'editorScript'];
    } else {
        $fields = ['script', 'viewScript'];
    }

    foreach ($blocks as $block_id => $block_args) {
        foreach ($fields as $field) {
            $handle = generate_block_asset_handle('hacklabr/' . $block_id, $field);
            wp_set_script_translations($handle, 'hacklabr', $language_path);
        }
    }
}

add_action('wp_enqueue_scripts', 'hacklabr\\localize_block_scripts', 12);
add_action('admin_enqueue_scripts', 'hacklabr\\localize_block_scripts', 12);
