<?php

namespace hacklabr;

/**
 * Exemplo para filtrar blocos do plugin Hacklab Blocks
 *
 * Descomente a linha abaixo e filtre os blocos na função `active_hacklab_blocks`
 */
//add_filter( 'hacklab_blocos_ativos', 'hacklabr\\active_hacklab_blocks' );

function active_hacklab_blocks( $active_blocks ){
    // unset( $active_blocks['sample-block'] );
    return $active_blocks;
}


/**
 * Exemplo de como adicionar elementos nos filtros do bloco Posts via API
 *
 * Descomente a linha abaixo para adicionar, por exemplo, para adicionar os atributos (image_credits e meta_authors) à resposta da API **no projeto de onde vem os posts**.
 */
// add_filter('hacklab-fetch-posts-api-before-excerpt-embed_post','hacklabr\\add_image_credits',10,3);

function add_image_credits( $content, $attributes, $post ) {
    if ( $attributes['showImageCredit'] == true ) {
        $content .= '<p class="post-image-credit">Foto: ' . $post['image_credit'] . '</p>';
    }
    $content .= '<p class="post-authors">' . $post['meta_authors'] . '</p>';
    return $content;
}
