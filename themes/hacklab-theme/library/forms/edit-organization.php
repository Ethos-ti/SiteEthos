<?php

namespace hacklabr;

function register_edit_organization_form () {
    $fields = get_registration_step1_fields();

    unset($fields['termos_de_uso']);

    register_form('edit-organization', __('Edit organization', 'hacklabr'), [
        'fields' => $fields,
        'submit_label' => __('Edit', 'hacklabr'),
        'get_params' => function () use ($fields) {
            $user_id = get_current_user_id();

            $organizations = get_posts([
                'post_type' => 'organizacao',
                'author' => $user_id,
                'posts_per_page' => 1,
            ]);

            if (!empty($organizations)) {
                $organization = $organizations[0];

                add_action('hacklabr\\form_output', function ($form_html, $form) use($organization) {
                    if ($form['id'] !== 'edit-organization') {
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
        },
    ]);
}
add_action('init', 'hacklabr\\register_edit_organization_form');

function validate_edit_organization_form ($form_id, $form, $params) {
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
}
add_action('hacklabr\\form_action', 'hacklabr\\validate_edit_organization_form', 10, 3);
