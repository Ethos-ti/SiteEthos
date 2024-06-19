<?php

namespace hacklabr;

function delete_form_post_meta ($post_id) {
    delete_post_meta($post_id, 'hacklabr_form');
}
add_action('save_post_page', 'hacklabr\\delete_form_post_meta');
add_action('save_post_post', 'hacklabr\\delete_form_post_meta');

function get_page_by_form (string $form_id) {
    $pages = get_posts([
        'post_type' => ['page', 'post'],
        'post_status' => 'publish',
        'meta_key' => 'hacklabr_form',
        'meta_value' => $form_id,
    ]);

    foreach ($pages as $page) {
        return $page;
    }

    return false;
}

function process_form_data () {
    global $hacklabr_registered_forms;

    if (empty($hacklabr_registered_forms) || empty($_POST['__hacklabr_form'])) {
        return;
    }

    $form_id = $_POST['__hacklabr_form'];

    if (!empty($hacklabr_registered_forms[$form_id])) {
        $form = $hacklabr_registered_forms[$form_id];
        $form_options = $form['options'];
        $params = call_user_func($form_options['get_params']);

        do_action('hacklabr\\form_action', $form_id, $form_options, $params);
    }
}

add_action('template_redirect', 'hacklabr\\process_form_data');

function sanitize_form_params () {
    $params = [];

    if (empty($_POST['__hacklabr_form'])) {
        return $params;
    }

    foreach ($_POST as $key => $value) {
        if (str_starts_with($key, '_')) {
            $params[substr($key, 1)] = filter_input(INPUT_POST, $key);
        }
    }

    return $params;
}

function register_form (string $form_id, string $name, array $options = []) {
    global $hacklabr_registered_forms;

    if (empty($hacklabr_registered_forms)) {
        $hacklabr_registered_forms = [];
    }

    if (empty($options['get_params'])) {
        $options['get_params'] = 'hacklabr\\sanitize_form_params';
    }

    $hacklabr_registered_forms[$form_id] = [
        'id' => $form_id,
        'name' => $name,
        'options' => $options,
    ];

    return true;
}

function render_field (string $name, array $definition, array $context = []) {
    $value = array_key_exists($name, $context) ? $context[$name] : '';

    $validation = empty($context) ? true : validate_field($definition, $value, $context);

    if (isset($definition['conditional']) && !call_user_func($definition['conditional'])) {
        return;
    }
?>
    <div class="<?= concat_class_list(['form-field', $definition['class'], ($validation === true) ? null : 'form-field--invalid']) ?>">
        <?php if ($definition['type'] !== 'static'): ?>
            <label class="form-field__label" for="<?= $name ?>">
                <?= $definition['label'] ?>
                <?php if ($definition['required']): ?>
                    <span class="form-field__required">*</span>
                <?php endif; ?>
            </label>
        <?php endif; ?>

        <?php if (!empty($definition['description'])): ?>
            <p class="form-field__description"><?= esc_html($definition['description']) ?></p>
        <?php endif; ?>

        <?php
        $value = $value ?: ($definition['default'] ?? '');

        $render_function = __NAMESPACE__ . '\Fields\render_' . $definition['type'] . '_field';
        if (function_exists($render_function)) {
            call_user_func($render_function, $name, $value, $definition);
        } else {
            Fields\render_input_field($name, $value, $definition);
        }
        ?>

        <?php if ($validation !== true): ?>
            <div id="<?= $name ?>__error" class="form-field__error"><?= $validation ?></div>
        <?php endif; ?>
    </div>
<?php
}

function render_form (array $form, array $params = [], string $class = 'form') {
    $form_options = $form['options'];
    $back_label = $form_options['back_label'] ?? __('Back', 'hacklabr');
    $submit_label = $form_options['submit_label'] ?? __('Submit', 'hacklabr');
?>
    <form class="<?= $class ?>" id="form:<?= $form['id'] ?>" method="post">
        <input type="hidden" name="__hacklabr_form" value="<?= $form['id'] ?>">

        <?php if (!empty($form_options['hidden_fields'])): ?>
            <?php render_hidden_fields($form_options['hidden_fields'], $params); ?>
        <?php endif; ?>

        <div class="form__grid">
        <?php foreach ($form_options['fields'] as $field => $definition): ?>
            <?php render_field($field, $definition, $params); ?>
        <?php endforeach; ?>
        </div>

        <div class="form__buttons">
            <?php if (!empty($form_options['back_url'])): ?>
                <a class="button button--outline" href="<?= $form_options['back_url'] ?>"><?= $back_label ?></a>
            <?php endif; ?>
            <button class="button button--solid" type="submit"><?= $submit_label ?></button>
        </div>
    </form>
<?php
}

function render_hidden_fields ($fields, $params = []) {
    foreach ($fields as $field) {
        $value = $params[$field] ?? '';
        if (!empty($value)) {
            Fields\render_hidden_field($field, $value);
        }
    }
}

function validate_field (array $definition, $value, array $context = []) {
    if (isset($definition['editable']) && $definition['editable'] !== true) {
        return true;
    } elseif ($definition['required'] && empty($value)) {
        return $definition['required_text'] ?? __('Required field', 'hacklabr');
    } elseif ($value && !empty($definition['validate'])) {
        return $definition['validate']($value, $context);
    }
    return true;
}

function validate_form (array $fields, array $params = []) {
    if (empty($params)) {
        return false;
    }

    $errors = [];

    foreach ($fields as $field => $definition) {
        $value = array_key_exists($field, $params) ? $params[$field] : '';

        $validation = validate_field($definition, $value, $params);
        if ($validation !== true) {
            $errors[$field] = $validation;
        }
    }

    if (!empty($errors)) {
        return $errors;
    } else {
        return true;
    }
}
