<?php

namespace hacklabr;

function add_user_to_pmpro_group ($user_id, $group_id) {
    $group = get_pmpro_group($group_id);

    $parent_level_id = $group->group_parent_level_id;
    $child_level_id = Fields\get_pmpro_child_level($parent_level_id);

    $membership = \PMProGroupAcct_Group_Member::create($user_id, $child_level_id, $group->id);

    assert($membership instanceof \PMProGroupAcct_Group_Member);

    \pmpro_changeMembershipLevel($child_level_id, $user_id);

    return $membership;
}

function calculate_membership_price( $group_id ){
    $group = get_pmpro_group($group_id);

    $users = get_users( [
        'meta_query' => [
            ['key' => '_pmpro_group', 'value' => $group_id ],
        ],
    ] );

    $total = 0;

    $level = \pmpro_getLevel($group->group_parent_level_id);

    if (!empty($level)) {

        $total += $level->initial_payment ?: 0;

        if (count($users) > 1){
            $child_level_id = Fields\get_pmpro_child_level($group->group_parent_level_id);
            $child_level = \pmpro_getLevel($child_level_id);

            $total += (count($users) - 1) * ($child_level->initial_payment ?: 0);
        }
    }

    return $total;
}

function create_pmpro_group ($user_id, $level_id = 11) {
    $group = \PMProGroupAcct_Group::create($user_id, $level_id, 100);

    assert($group instanceof \PMProGroupAcct_Group);

    \pmpro_changeMembershipLevel($level_id, $user_id);

    return $group;
}

function get_pmpro_group ($group_id) {
    return new \PMProGroupAcct_Group($group_id);
}

function update_group_level ($group_id, $level_id = 11) {
    global $wpdb;

    $group = get_pmpro_group($group_id);

    if ($group->group_parent_level_id == $level_id) {
        return $group;
    }

    $child_members = $group->get_active_members(false);
    $child_level_id = Fields\get_pmpro_child_level($level_id);

    $wpdb->update($wpdb->prefix . 'pmprogroupacct_groups',
    [
        'group_parent_level_id' => $level_id,
    ], [
        'id' => $group_id,
    ], ['%d'], ['%d']);

    \pmpro_changeMembershipLevel($level_id, $group->group_parent_user_id);

    foreach ($child_members as $child_member) {
        \pmpro_changeMembershipLevel($child_level_id, $child_member->group_child_user_id);
    }

    return $group;
}

function require_approval_for_login ($user) {
    if (!class_exists('PMPro_Approvals') || empty($user) || is_wp_error($user)) {
        return $user;
    }

    assert($user instanceof \WP_User);

    $group_id = get_user_meta($user->ID, '_pmpro_group', true);

    if (!empty($group_id)) {
        $group = get_pmpro_group($group_id);
        $level_id = $group->group_parent_level_id;
        $child_level_id = Fields\get_pmpro_child_level($level_id);

        if (!\PMPro_Approvals::isApproved($user->ID, $level_id) && !\PMPro_Approvals::isApproved($user->ID, $child_level_id)) {
            return new \WP_Error('failed', 'Associação ainda não foi aprovada.');
        }
    }

    return $user;
}
add_filter('wp_authenticate_user', 'hacklabr\\require_approval_for_login');

function register_organization_cpt () {
    register_post_type('organizacao', [
        'label' => __('Organizations', 'hacklabr'),
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-building',
        'supports' => ['author', 'custom-fields', 'thumbnail', 'title'],
    ]);
}
add_action('init', 'hacklabr\\register_organization_cpt');

function get_organization_by_user ($user_id = null) {
    if (empty($user_id)) {
        $user_id = get_current_user_id();
    }

    $group_id = get_user_meta($user_id, '_pmpro_group', true);

    if (empty($group_id)) {
        return null;
    }

    $posts = get_posts([
        'post_type' => 'organizacao',
        'meta_query' => [
            [ 'key' => '_pmpro_group', 'value' => $group_id ],
        ],
    ]);

    if (empty($posts)) {
        return null;
    } else {
        $post = $posts[0];
        assert($post instanceof \WP_Post);
        return $post;
    }
}
