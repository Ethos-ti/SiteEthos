<?php

namespace hacklabr;

function get_request_talk_fields () {
    $event_options = [];

    $palestras = [];
    $palestra_options = [];

    $privacy_policy_url =  get_privacy_policy_url();

    $fields = [
        'empresa' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => _x('Business', 'organization', 'hacklabr'),
            'placeholder' => __('Enter the business name', 'hacklabr'),
            'required' => true,
        ],
        'cnpj' => [
            'type' => 'masked',
            'class' => '-colspan-12',
            'label' => __('CNPJ number', 'hacklabr'),
            'mask' => '00.000.000/0000-00',
            'placeholder' => __("Enter the company' CNPJ number", 'hacklabr'),
            'required' => true,
            'validate' => function ($value, $context) {
                if (!is_numeric($value) || strlen($value) !== 14) {
                    return __('Invalid CNPJ number', 'hacklabr');
                }
                return true;
            },
        ],
        'prenome' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => __('First name', 'hacklabr'),
            'placeholder' => __('Enter your first name', 'hacklabr'),
            'required' => true,
        ],
        'sobrenome' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => __('Last name', 'hacklabr'),
            'placeholder' => __('Enter your last name', 'hacklabr'),
            'required' => true,
        ],
        'email' => [
            'type' => 'email',
            'class' => '-colspan-12',
            'label' => __('Email', 'hacklabr'),
            'placeholder' => __('Enter the email', 'hacklabr'),
            'required' => true,
            'validate' => function ($value, $context) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return __('Invalid email', 'hacklabr');
                }
                return true;
            },
        ],
        'repete_email' => [
            'type' => 'email',
            'class' => '-colspan-12',
            'label' => __('Repeat email', 'hacklabr'),
            'placeholder' => __('Enter the email again', 'hacklabr'),
            'required' => true,
            'validate' => function ($value, $context) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return __('Invalid email', 'hacklabr');
                } elseif ($value !== $context['email']) {
                    return __('Email addresses do not match', 'hacklabr');
                }
                return true;
            },
        ],
        'telefone' => [
            'type' => 'masked',
            'class' => '-colspan-12',
            'label' => __('Phone number', 'hacklabr'),
            'mask' => '(00) 0000-0000|(00) 00000-0000',
            'placeholder' => __('Enter the phone number', 'hacklabr'),
            'required' => false,
            'validate' => function ($value, $context) {
                if (empty($value)) {
                    return true;
                } elseif (!is_numeric($value) || strlen($value) < 10 || strlen($value) > 11) {
                    return __('Invalid phone number', 'hacklabr');
                }
                return true;
            },
        ],
        'descricao' => [
            'type' => 'textarea',
            'class' => '-colspan-12',
            'label' => __('Describe your requirements', 'hacklabr'),
            'placeholder' => __("Describe briefly what you'd like to be covered in the talk", 'hacklabr'),
            'required' => false,
        ],
        'tipo_evento' => [
            'type' => 'select',
            'class' => '-colspan-12',
            'label' => __('Event type', 'hacklabr'),
            'options' => $event_options,
            'required' => true,
            'validate' => function ($value, $context) use ($event_options) {
                if (!array_key_exists($value, $event_options)) {
                    return _x('Invalid type', 'event', 'hacklabr');
                }
                return true;
            },
        ],
        'palestra' => [
            'type' => 'select',
            'class' => '-colspan-12',
            'label' => _x('Talk', 'lecture', 'hacklabr'),
            'options' => $palestra_options,
            'required' => true,
            'validate' => function ($value, $context) use ($palestra_options) {
                if (!array_key_exists($value, $palestra_options)) {
                    return _x('Invalid talk', 'lecture', 'hacklabr');
                }
                return true;
            },
        ],
        'publico_alvo' => [
            'type' => 'textarea',
            'class' => '-colspan-12',
            'label' => __('Target audience', 'hacklabr'),
            'placeholder' => __('Describe the target audience for the talk', 'hacklabr'),
            'required' => false,
        ],
        'data' => [
            'type' => 'date',
            'class' => '-colspan-12',
            'label' => __('Desired date', 'hacklabr'),
            'placeholder' => __('Select a date', 'hacklabr'),
            'required' => false,
        ],
        'horario' => [
            'type' => 'time',
            'class' => '-colspan-12',
            'label' => __('Desired hour', 'hacklabr'),
            'placeholder' => __('Select an hour', 'hacklabr'),
            'required' => false,
        ],
        'politica_privacidade' => [
            'type' => 'checkbox',
            'class' => '-colspan-12',
            'label' => sprintf(__('I have read and agreed with the <a href="%s" target="_blank">Privacy Policy</a>', 'hacklabr'), $privacy_policy_url),
            'required' => true,
        ],
        'grecaptcha' => [
            'type' => 'grecaptcha',
            'class' => '-colspan-12',
            'required' => false,
            'validate' => function ($value, $context) {
                if (class_exists('\WPCaptcha_Functions')) {
                    if (empty($value)) {
                        return __('Prove you are not a robot', 'hacklabr');
                    } else {
                        $verification = \WPCaptcha_Functions::handle_captcha();
                        if (is_wp_error($verification)) {
                            return $verification->get_error_message();
                        } elseif ($verification != true) {
                            return __('CAPTCHA verification failed', 'hacklabr');
                        }
                    }
                }
                return true;
            },
        ],
    ];

    return $fields;
}

// function get_request_talk_params () {
//     $params = sanitize_form_params();

//     $params['grecaptcha'] = filter_input(INPUT_POST, 'g-recaptcha-response') ?: '';

//     return $params;
// }

function enqueue_grecaptcha_on_request_talk () {
    if (class_exists('\WPCaptcha_Functions')) {
        add_action('wp_enqueue_scripts', ['WPCaptcha_Functions', 'login_enqueue_scripts']);
        add_action('wp_head', ['WPCaptcha_Functions', 'login_head'], 9999);
    }
}

function register_request_talk_form () {
    $fields = get_request_talk_fields();

    register_form('request-talk', __('Request talk', 'hacklabr'), [
        'fields' => $fields,
        // 'get_params' => 'hacklabr\\get_request_talk_params',
    ]);
}
add_action('init', 'hacklabr\\register_request_talk_form');

function validate_request_talk_form ($form_id, $form, $params) {
    if ($form_id === 'request-talk') {
        $validation = validate_form($form['fields'], $params);

        if ($validation !== true) {
            return;
        }
    }
}
add_action('hacklabr\\form_action', 'hacklabr\\validate_request_talk_form', 10, 3);
