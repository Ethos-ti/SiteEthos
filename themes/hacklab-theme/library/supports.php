<?php

namespace hacklabr;

/**
 *
 * Adds theme supports
 *
 * As of version 5.8, supports for blocks must be inserted from the theme.json file in the root of the theme
 * @link https://github.com/WordPress/gutenberg/blob/trunk/docs/how-to-guides/themes/theme-json.md
 *
 */
function theme_supports() {
    add_theme_support( 'align-wide' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'core-block-patterns' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'widgets' );
}

add_action( 'after_setup_theme', 'hacklabr\\theme_supports' );

/**
 * Load the theme textdomain
 */
function theme_setup() {
    load_theme_textdomain( 'hacklabr', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'hacklabr\\theme_setup' );

/**
 * Add support to load blocks scripts only if needed
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' );
