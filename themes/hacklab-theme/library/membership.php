<?php

namespace hacklabr;

function add_user_to_pmpro_group (int $user_id, int $group_id) {
    $group = get_pmpro_group($group_id);

    $parent_level_id = $group->group_parent_level_id;
    $child_level_id = get_pmpro_child_level($parent_level_id);

    $membership = \PMProGroupAcct_Group_Member::create($user_id, $child_level_id, $group->id);

    assert($membership instanceof \PMProGroupAcct_Group_Member);

    \pmpro_changeMembershipLevel($child_level_id, $user_id);

    return $membership;
}

function calculate_membership_price (int $group_id) {
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
            $child_level_id = get_pmpro_child_level($group->group_parent_level_id);
            $child_level = \pmpro_getLevel($child_level_id);

            $total += (count($users) - 1) * ($child_level->initial_payment ?: 0);
        }
    }

    return $total;
}

function create_pmpro_group (int $user_id, int $level_id = 11) {
    $group = \PMProGroupAcct_Group::create($user_id, $level_id, 100);

    assert($group instanceof \PMProGroupAcct_Group);

    \pmpro_changeMembershipLevel($level_id, $user_id);

    return $group;
}

function get_pmpro_group (int $group_id) {
    return new \PMProGroupAcct_Group($group_id);
}

function get_pmpro_child_level ($level) {
    if ($level === 8 || $level === 9) {
        return $level + 12;
    } else {
        return $level;
    }
}

function get_pmpro_level_options ($organization_id, $for_manager = true) {
    $revenue = get_post_meta($organization_id, 'faturamento_anual', true) ?: 'small';

    if ($revenue === 'small') {
        return [
            'conexao' => $for_manager ? 8 : 20,
            'essencial' => $for_manager ? 9 : 21,
            'vivencia' => 10,
            'institucional' => 11,
        ];
    } else if ($revenue === 'medium') {
        return [
            'conexao' => 12,
            'essencial' => 13,
            'vivencia' => 14,
            'institucional' => 15,
        ];
    } else if ($revenue === 'large') {
        return [
            'conexao' => 16,
            'essencial' => 17,
            'vivencia' => 18,
            'institucional' => 19,
        ];
    }
}

function get_pmpro_level_slug_by_id ($level_id) {
    switch (((int) $level_id) % 4) {
        case 0: // 8, 12, 16, 20
            return 'conexao';
        case 1: // 9, 13, 17, 21
            return 'essencial';
        case 2: // 10, 14, 18
            return 'vivencia';
        case 3: // 11, 15, 19
            return 'institucional';
    }
}

function get_pmpro_plan ($user_id) {
    $group_id = (int) get_user_meta($user_id, '_pmpro_group', true);

    if (empty($group_id)) {
        return null;
    }

    $group = get_pmpro_group($group_id);
    $level_id = $group->group_parent_level_id;
    return get_pmpro_level_slug_by_id($level_id);
}

function update_group_level (int $group_id, int $level_id = 11) {
    global $wpdb;

    $group = get_pmpro_group($group_id);

    if ($group->group_parent_level_id == $level_id) {
        return $group;
    }

    $child_members = $group->get_active_members(false);
    $child_level_id = get_pmpro_child_level($level_id);

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

function update_group_parent (int $group_id, int $user_id) {
    global $wpdb;

    $group = get_pmpro_group($group_id);

    if ($group->group_parent_user_id == $user_id) {
        return $group;
    }

    $wpdb->update($wpdb->prefix . 'pmprogroupacct_groups',
    [
        'group_parent_user_id' => $user_id,
    ], [
        'id' => $group_id,
    ], ['%d'], ['%d']);

    $wpdb->delete($wpdb->prefix . 'pmprogroupacct_group_members', [
        'group_child_user_id' => $user_id,
    ], ['%d']);

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
        $child_level_id = get_pmpro_child_level($level_id);

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

    return get_single_post([
        'post_type' => 'organizacao',
        'meta_query' => [
            [ 'key' => '_pmpro_group', 'value' => $group_id ],
        ],
    ]);
}
