<?php

namespace BaseThemeName;

function add_image_credits($content,$attributes, $post){
    if($attributes['showImageCredit'] == true){
        $content .= '<p class="post-image-credit">Foto: '.$post['image_credit'].'</p>';
    }
    $content .= '<p class="post-authors">'.$post['meta_authors'].'</p>';
    return $content;
}

if ( ! function_exists( 'is_plugin_active' ) ) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( is_plugin_active( 'tutor/tutor.php' ) ) {
    require __DIR__ . '/library/tutorstarter.php';
}

require __DIR__ . '/library/supports.php';
require __DIR__ . '/library/sidebars.php';
require __DIR__ . '/library/menus.php';
require __DIR__ . '/library/assets.php';
require __DIR__ . '/library/search.php';
require __DIR__ . '/library/api/index.php';
require __DIR__ . '/library/sanitizers/index.php';
require __DIR__ . '/library/template-tags/index.php';
require __DIR__ . '/library/customizer/index.php';
require __DIR__ . '/library/utils.php';
require __DIR__ . '/library/hacklab-blocks/index.php';
