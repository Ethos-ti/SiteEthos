<?php

namespace hacklabr;

function register_edit_organization_form () {
    $fields = get_registration_step1_fields();

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

            if(!empty($organizations)) {
                $organization = $organizations[0];
                $meta = get_post_meta($organization->ID);
                $params = [];

                foreach ($fields as $key => $field) {
                    if(!empty($meta [$key])) {
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

        // Save params
    }
}
add_action('hacklabr\\form_action', 'hacklabr\\validate_edit_organization_form');
