<?php

namespace hacklabr;

function get_edit_contact_fields () {
    $fields = get_registration_step5_fields();

    $fields['email']['validate'] = function ($value, $context) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return __('Invalid email', 'hacklabr');
        } else {
            $maybe_user = get_user_by('email', $value);
            if (!empty($maybe_user)) {
                $user_id = $context['_user_id'];
                if (empty($user_id) || $maybe_user->ID != $user_id) {
                    return __('Email is already in use', 'hacklabr');
                }
            }
        }
        return true;
    };

    return $fields;
}

function get_edit_organization_fields () {
    $fields = get_registration_step1_fields();

    unset($fields['termos_de_uso']);
    unset($fields['codigo_de_conduta']);

    foreach ($fields as $key => $field) {
        $fields[$key]['disabled'] = true;
    }

    return $fields;
}

function get_edit_organization_finance_fields () {
    $fields = get_registration_step4_fields();

    $current_user = get_current_user_id();

    if (class_exists('PMProGroupAcct_Group') && !empty($current_user)) {

        $group_id = (int) get_user_meta($current_user, '_pmpro_group', true);

        $membership_price = calculate_membership_price($group_id);

        $fields['pagto_sugerido']['default'] = $membership_price;
        $fields['pagto_sugerido']['disabled'] = true;
    }

    foreach ($fields as $key => $field) {
        $fields[$key]['disabled'] = true;
    }

    return $fields;
}

function get_organization_params ($form_id, $fields) {
    return function () use ($form_id, $fields) {
        $user_id = get_current_user_id();

        $organizations = get_posts([
            'post_type' => 'organizacao',
            'author' => $user_id,
            'posts_per_page' => 1,
        ]);

        if (!empty($organizations)) {
            $organization = $organizations[0];

            add_action('hacklabr\\form_output', function ($form_html, $form) use($form_id, $organization) {
                if ($form['id'] !== $form_id) {
                    return $form_html;
                }

                $form_lines = explode("\n", $form_html);
                array_splice($form_lines, 1, 0, [
                    '<input type="hidden" name="__organization_id" value="' . $organization->ID . '">',
                ]);
                return implode("\n", $form_lines);
            }, 10, 2);

            $meta = get_post_meta($organization->ID);
            $params = sanitize_form_params();

            foreach ($fields as $key => $field) {
                if (empty($params[$key]) && !empty($meta[$key])) {
                    $params[$key] = $meta[$key][0];
                }
            }

            return $params;
        }

        return [];
    };
}

function register_edit_organization_form () {
    $fields_contacts = get_edit_contact_fields();
    $fields_finance = get_edit_organization_finance_fields();
    $fields_organization = get_edit_organization_fields();

    register_form('edit-organization', __('Edit organization', 'hacklabr'), [
        'fields' => $fields_organization,
        'submit_label' => false,
        'get_params' => get_organization_params('edit-organization', $fields_organization),
    ]);

    register_form('edit-organization-contacts', __('Edit contacts', 'hacklabr'), [
        'fields' => $fields_contacts,
        'submit_label' => __('Save'),
    ]);

    register_form('edit-organization-contacts__hidden', __('Edit contacts', 'hacklabr') . ' ' . __('(hidden)', 'hacklabr'), [
        'fields' => [],
        'hidden' => true,
    ]);

    register_form('edit-organization-finances', __('Edit organization finances', 'hacklabr'), [
        'fields' => $fields_finance,
        'submit_label' => false,
        'get_params' => get_organization_params('edit-organization-finances', $fields_finance),
    ]);
}
add_action('init', 'hacklabr\\register_edit_organization_form');

function validate_edit_organization_form ($form_id, $form, $params) {
    $current_user = get_current_user_id();

    $is_ethos_admin = get_user_meta( $current_user, '_ethos_admin', true );

    if ( empty( $is_ethos_admin ) ) {
        return;
    }

    if ($form_id === 'edit-organization') {
        $validation = validate_form($form['fields'], $params);

        if ($validation !== true) {
            return;
        }

        $post_id = $params['_organization_id'];
        $post_meta = $params;

        unset($post_meta['_hacklabr_form']);
        unset($post_meta['_organization_id']);

        wp_update_post([
            'ID' => $post_id,
            'post_title' => $post_meta['nome_fantasia'],
            'meta_input' => $post_meta,
        ]);
    }

    if ($form_id === 'edit-organization-finances') {
        $validation = validate_form($form['fields'], $params);

        if ($validation !== true) {
            return;
        }

        $post_id = $params['_organization_id'];
        $post_meta = $params;

        unset($post_meta['_hacklabr_form']);
        unset($post_meta['_organization_id']);

        foreach ($params as $meta_key => $meta_value) {
            update_post_meta($post_id, $meta_key, $meta_value);
        }
    }

    if ($form_id === 'edit-organization-contacts') {
        $validation = validate_form($form['fields'], $params);

        if ($validation !== true) {
            return;
        }

        $user_id = (int) $params['_user_id'];
        $post_meta = $params;

        unset($post_meta['_action']);
        unset($post_meta['_hacklabr_form']);
        unset($post_meta['_user_id']);

        if (empty($user_id)) {
            $group_id = (int) get_user_meta($current_user, '_pmpro_group', true);

            $user_meta = array_merge($params, [
                '_pmpro_group' => $group_id,
                '_pmpro_role' => 'primary',
            ]);

            $password = wp_generate_password(16);

            $user_id = wp_insert_user([
                'display_name' => $params['nome_completo'],
                'user_email' => $params['email'],
                'user_login' => sanitize_title($params['nome_completo']),
                'user_pass' => $password,
                'role' => 'subscriber',
                'meta_input' => $user_meta,
            ]);

            add_user_to_pmpro_group($user_id, $group_id);
        } else {
            $user_meta = $params;

            wp_update_user([
                'ID' => $user_id,
                'display_name' => $params['nome_completo'],
                'user_email' => $params['email'],
                'meta_input' => $user_meta,
            ]);
        }
    }

    if ($form_id === 'edit-organization-contacts__hidden') {
        $action = $params['_action'];
        $user_id = (int) $params['_user_id'];

        if (empty($action) || empty($user_id)) {
            return;
        }

        if ($action === 'addAdmin') {
            $ethos_admins = get_users([
                'meta_query' => [
                    [ 'key' => '_pmpro_group', 'value' => $group_id ],
                    [ 'key' => '_ethos_admin', 'value' => '1' ],
                ],
            ]);

            if (count($ethos_admins) < 3) {
                update_user_meta($user_id, '_ethos_admin', '1');
            }
        } elseif ($action === 'addApprover') {
            $group_id = get_user_meta($user_id, '_pmpro_group', true);

            $current_approvers = get_users([
                'meta_query' => [
                    [ 'key' => '_pmpro_group', 'value' => $group_id ],
                ],
            ]);
            foreach ($current_approvers as $approver) {
                delete_user_meta($approver->ID, '_ethos_approver', '1');
            }

            update_user_meta($user_id, '_ethos_approver', '1');
        } elseif ($action === 'deleteUser') {
            // Required for using `wp_delete_user` function
	        require_once(ABSPATH . 'wp-admin/includes/user.php');

            wp_delete_user($user_id, null);
        } elseif ($action === 'removeAdmin') {
            delete_user_meta($user_id, '_ethos_admin', '1');
        } elseif ($action === 'removeApprover') {
            delete_user_meta($user_id, '_ethos_approver', '1');
        }

        $current_url = untrailingslashit( $_SERVER['REQUEST_URI'] );
        wp_safe_redirect(add_query_arg(['tab' => 2], $current_url));
        exit;
    }
}
add_action('hacklabr\\form_action', 'hacklabr\\validate_edit_organization_form', 10, 3);
