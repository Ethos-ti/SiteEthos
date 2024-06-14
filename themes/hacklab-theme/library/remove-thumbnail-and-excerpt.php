<?php

class RemoveThumbnailAndExcerpt {

    public static function init() {
        add_action( 'init', 'RemoveThumbnailAndExcerpt::remove_content_items' );
    }

    public static function remove_content_items() {

        if ( ! is_user_logged_in() ) {
            return;
        }

        if ( isset( $_GET['REMOVE_THUMBNAIL_AND_EXCERPT'] ) ) {
            global $wpdb;
            $post_id = false;

            $log = fopen( wp_upload_dir()['basedir'] . "/thumbnail_excerpt_removal_status.html", "a" );

            if ( isset( $_GET['post_id'] ) && is_numeric( $_GET['post_id'] ) ) {
                $post_id = intval( $_GET['post_id'] );
            }

            $count = 0;

            if ( $post_id ) {
                $query = $wpdb->prepare(
                    "SELECT DISTINCT
                        ID, post_content, post_title
                    FROM {$wpdb->posts}
                    WHERE post_type IN ('post', 'publicacao', 'iniciativa')
                    AND post_status = 'publish'
                    AND ID = %d
                    ORDER BY post_date DESC",
                    $post_id
                );
            } else {
                if ( ! get_option( 'remove-thumbnail-and-excerpt-option' ) ) {
                    add_option( 'remove-thumbnail-and-excerpt-option', true );
                } else {
                    return;
                }

                ini_set( 'max_execution_time', 0 );
                ini_set( 'memory_limit', '-1' );

                $query = "SELECT DISTINCT
                    ID, post_content, post_title
                    FROM {$wpdb->posts}
                    WHERE post_type IN ('post', 'publicacao', 'iniciativa')
                    AND post_status = 'publish'
                    ORDER BY post_date DESC";
            }

            $posts = $wpdb->get_results( $query );

            fwrite( $log, "<html><body><p>Total rows: " . count( $posts ) . "</p>" );

            $start_time = microtime( true );

            foreach ( $posts as $post ) {
                if ( empty( $post->post_content ) ) continue;

                $thumbnail_id = get_post_thumbnail_id( $post->ID );
                $thumbnail_urls = self::get_thumbnail_urls( $thumbnail_id );

                // Corrigir excerpt
                $excerpt = self::clear_excerpt( $post->ID );
                $DOM = self::post_to_DOM( $post );

                // Remover o thumbnail
                $images = $DOM->getElementsByTagName( 'img' );
                foreach ( $images as $img ) {
                    $src = $img->getAttribute( 'src' );
                    foreach ( $thumbnail_urls as $url ) {
                        if ( strpos( $src, $url ) !== false ) {
                            self::delete_DOM_nodes( [$img] );
                            break;
                        }
                    }
                }

                // Remover o excerpt
                $paragraphs = $DOM->getElementsByTagName( 'p' );
                foreach ( $paragraphs as $p ) {
                    if ( strpos( $p->textContent, $excerpt ) !== false ) {
                        self::delete_DOM_nodes( [$p] );
                    }
                }

                $body = $DOM->getElementsByTagName('body')->item(0);
                $content = '';
                if ($body) {
                    foreach ($body->childNodes as $child) {
                        $content .= $DOM->saveHTML($child);
                    }
                }

                $content = html_entity_decode($content, ENT_QUOTES | ENT_XML1, 'UTF-8');
                $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

                $wpdb->update( $wpdb->posts, ['post_content' => $content], ['ID' => $post->ID] );

                fwrite( $log, "<p> num: " . $count . " | id: " . $post->ID . ": " . $post->post_title . "</p>" );
                $count++;
            }

            $end_time = microtime( true );
            $execution_time = ( $end_time - $start_time );

            fwrite( $log, "<p>Execution time = " . $execution_time . "s</p></body></html>" );
            fclose( $log );
        }
    }

    private static function get_thumbnail_urls( $thumbnail_id ) {
        $urls = [];

        $thumbnail_url = wp_get_attachment_url( $thumbnail_id );
        if ( $thumbnail_url ) {
            $urls[] = parse_url( $thumbnail_url, PHP_URL_PATH );
        }

        $metadata = wp_get_attachment_metadata( $thumbnail_id );
        if ( $metadata ) {
            $upload_dir = wp_upload_dir();
            $base_url = parse_url( $upload_dir['baseurl'], PHP_URL_PATH ) . '/' . dirname( $metadata['file'] );

            foreach ( $metadata['sizes'] as $size ) {
                $urls[] = $base_url . '/' . $size['file'];
            }
        }

        return $urls;
    }

    private static function clear_excerpt( $post_id ) {
        $excerpt = get_the_excerpt( $post_id );
        $tags = wp_get_post_tags( $post_id, ['fields' => 'names'] );

        foreach ( $tags as $tag ) {
            $prefix = $tag . '_';
            if ( strpos( $excerpt, $prefix ) === 0 ) {
                $excerpt = substr( $excerpt, strlen( $prefix ) );
                wp_update_post( [
                    'ID' => $post_id,
                    'post_excerpt' => $excerpt,
                ] );
                break;
            }
        }

        return $excerpt;
    }

    private static function post_to_DOM( $post ) {
        $content = new DOMDocument( '1.0', 'UTF-8' );
        libxml_use_internal_errors(true); // Suprime erros de parsing HTML

        $html = '<html><body>' . mb_convert_encoding($post->post_content, 'HTML-ENTITIES', 'UTF-8') . '</body></html>';
        $content->loadHTML( $html, LIBXML_NOWARNING | LIBXML_NOERROR );

        libxml_clear_errors();
        return $content;
    }

    private static function delete_DOM_nodes( $nodes = [] ) {
        foreach ( $nodes as $node ) {
            $node->parentNode->removeChild( $node );
        }
    }
}

RemoveThumbnailAndExcerpt::init();
