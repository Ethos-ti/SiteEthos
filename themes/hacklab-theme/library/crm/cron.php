<?php

namespace ethos\crm;

function fetch_lastest_created_items (string $entity_name) {
    $entities = \hacklabr\get_crm_entities($entity_name, [
        'cache' => false,
        'orderby' => 'modifiedon',
        'order' => 'DESC',
        'per_page' => 100,
    ]);

    return $entities->Entities;
}

function fetch_lastest_modified_items (string $entity_name) {
    $entities = \hacklabr\get_crm_entities($entity_name, [
        'cache' => false,
        'orderby' => 'modifiedon',
        'order' => 'DESC',
        'per_page' => 100,
    ]);

    return $entities->Entities;
}

function set_initial_last_crm_sync () {
    global $wpdb;

    // Query largest modified date on database
    $query = "SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_ethos_crm:modifiedon' ORDER BY meta_value DESC LIMIT 1";

    $datetime = $wpdb->get_var($query) ?? null;

    return update_last_crm_sync($datetime);
}

function get_last_crm_sync () {
    $option = get_option('_ethos_last_crm_sync', null);

    if (empty($option)) {
        return set_initial_last_crm_sync();
    } else {
        return $option;
    }
}

function update_last_crm_sync (string|null $datetime = null) {
    if (empty($datetime)) {
        // Use format returned by CRM `modifiedon` attribute
        $datetime = date_format(date_create('now'), 'Y-m-d\TH:i:sp');
    }

    update_option('_ethos_last_crm_sync', $datetime);

    return $datetime;
}
