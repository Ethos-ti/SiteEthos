<?php

namespace hacklabr;

function add_user_to_pmpro_group ($user_id, $group_id) {
    $group = new \PMProGroupAcct_Group($group_id);

    $membership = \PMProGroupAcct_Group_Member::create($user_id, $group->group_parent_level_id, $group->id);

    assert($membership instanceof \PMProGroupAcct_Group_Member);

    \pmpro_changeMembershipLevel($user_id, $group->group_parent_level_id);

    return $membership;
}

function create_pmpro_group ($user_id, $level_id = 11) {
    $group = \PMProGroupAcct_Group::create($user_id, $level_id, 100);

    assert($group instanceof \PMProGroupAcct_Group);

    \pmpro_changeMembershipLevel($level_id, $user_id);

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
