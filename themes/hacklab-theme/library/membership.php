<?php

namespace hacklabr;

function pmpro_create_blank_group ($level_id = 0) {
    global $wpdb;

    $wpdb->insert($wpdb->pmprogroupacct_groups, [
        'group_parent_user_id'  => 0,
        'group_parent_level_id' => $level_id,
        'group_checkout_code'   => \pmpro_getDiscountCode(),
        'group_total_seats'     => 100,
    ], ['%d', '%d', '%s', '%d']);

    if (empty($wpdb->insert_id)) {
        return false;
    }

    return new \PMProGroupAcct_Group($wpdb->insert_id);
}

function pmpro_fill_group ($group_id, $user_id) {
    global $wpdb;

    $wpdb->update($wpdb->pmprogroupacct_groups, [
        'group_parent_user_id' => $user_id,
    ], [
        'id' => $group_id,
    ], ['%d'], ['%d']);

    $group = new \PMProGroupAcct_Group($group_id);

    $group->regenerate_group_checkout_code();

    return $group;
}

function register_organization_cpt () {
    register_post_type('organizacao', [
        'label' => __('Organizations', 'hacklabr'),
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-building',
        'supports' => ['title', 'author', 'custom-fields'],
    ]);
}
add_action('init', 'hacklabr\\register_organization_cpt');
