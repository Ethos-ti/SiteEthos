<?php

namespace ethos\crm;

function get_contact( string $contact_id, string $account_id ) {
    $existing_users = get_users( [
        'meta_query' => [
            [ 'key' => '_ethos_crm_account_id', 'value' => $account_id ],
            [ 'key' => '_ethos_crm_contact_id', 'value' => $contact_id ],
        ],
    ] );

    if ( empty( $existing_users ) ) {
        $account = \hacklabr\get_crm_entity_by_id( 'account', $account_id );
        $contact = \hacklabr\get_crm_entity_by_id( 'contact', $contact_id );

        if ( ! empty( $contact ) ) {
            return \ethos\migration\import_contact( $contact, $account, false );
        }
    } else {
        return $existing_users[0]->ID;
    }

    return null;
}

function get_post_id_by_account( string $account_id ) {
    $existing_post = get_single_post( [
        'post_type' => 'organizacao',
        'meta_query' => [
            [ 'key' => '_ethos_crm_account_id', 'value' => $account_id ],
        ],
    ] );

    if ( empty( $existing_post ) ) {
        $account = \hacklabr\get_crm_entity_by_id( 'account', $account_id );

        if ( ! empty( $account ) ) {
            return create_from_account( $account );
        }

        return null;
    }

    return $existing_post->ID;
}
