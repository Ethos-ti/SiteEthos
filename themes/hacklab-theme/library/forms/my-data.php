<?php

namespace hacklabr;

function get_my_data_fields () {
    $fields = get_edit_contact_fields();

    return $fields;
}

function get_my_data_params () {
   $params = sanitize_form_params();

   return $params;
}

function register_my_data_form () {
    $fields = get_my_data_fields();

    register_form('edit-my-data', __('My data', 'hacklabr'), [
        'fields' => $fields,
        'get_params' => 'hacklabr\\get_my_data_params',
        'submit_label' => __('Save changes', 'hacklabr'),
    ]);
}
add_action('init', 'hacklabr\\register_my_data_form');

function validate_my_data_form ($form_id, $form, $params) {
    if ($form_id === 'edit-my-data') {
        $validation = validate_form($form['fields'], $params);

        if ($validation !== true) {
            return true;
        }

        // TODO
    }
}
add_action('hacklabr\\form_action', 'hacklabr\\validate_my_data_form', 10, 3);
