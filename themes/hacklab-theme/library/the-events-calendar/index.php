<?php

namespace hacklabr;

require_once get_theme_file_path( 'library/the-events-calendar/Meta_Save.php' );

add_action( 'init', 'hacklabr\replace_events_meta_save_class' );

function replace_events_meta_save_class() {
    remove_action( 'save_post', [ 'Tribe__Events__Main', 'addEventMeta' ], 15 );
    add_action( 'save_post', 'hacklabr\ethos_events_save_meta', 10, 2 );
}

function ethos_events_save_meta( $post_id, $post ) {
    if ( 'tribe_events' !== $post->post_type ) {
        return;
    }

    $context = new \Tribe__Events__Meta__Context();
    $meta_save = new \Ethos_Events_Meta_Save( $post_id, $post, $context );
    $meta_save->maybe_save();
}

add_action( 'admin_menu', 'hacklabr\ethos_events_add_metabox' );

function ethos_events_add_metabox() {
    add_meta_box(
        'tribe_events_event_details',
        'The Events Calendar',
        [ tribe( 'tec.admin.event-meta-box' ), 'init_with_event' ],
        'tribe_events',
        'normal',
        'high'
    );
}

