<?php

namespace hacklabr;

function register_edit_organization_form () {
    $fields = get_registration_step1_fields();

    register_form('edit-organization', __('Edit organization', 'hacklabr'), [
        'fields' => $fields,
        'submit_label' => __('Edit', 'hacklabr'),
        'get_params' => function () {
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
