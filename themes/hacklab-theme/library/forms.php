<?php

namespace hacklabr;

function sanitize_form_params () {
    $params = [];

    foreach ($_POST as $key => $value) {
        if (str_starts_with($key, '_')) {
            $params[substr($key, 1)] = filter_input(INPUT_POST, $key);
        }
    }

    return $params;
}

function register_form (string $form_id, string $name, array $options) {
    global $hacklabr_registered_forms;

    if (!empty($hacklabr_registered_forms)) {
        $hacklabr_registered_forms = [];
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
    if ($validation !== true) {
        $definition['error_message'] = $validation;
    }

    if (isset($definition['conditional']) && !call_user_func($definition['conditional'])) {
        return;
    }
?>

    <div class="form-field <?= $definition['class'] ?><?= ($validation === true) ? '' : ' form-field--invalid' ?>">
        <?php if ($definition['type'] !== 'static'): ?>
            <label class="form-field__label" for="<?= $name ?>">
                <?= $definition['label'] ?>
                <?php if ($definition['required']): ?>
                    <span class="form-field__required">*</span>
                <?php endif; ?>
            </label>
        <?php endif; ?>

        <?php if (isset($definition['description']) && !empty($definition['description'])): ?>
            <p class="form-field__description"><?= esc_html($definition['description']) ?></p>
        <?php endif; ?>

        <?php
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

function render_form (array $form, array $params = []) {
    $submit_label = $form['submit_label'] ?? __('Submit', 'hacklabr');
?>
    <form class="form" id="form:<?= $form['id'] ?>" method="post">
        <input type="hidden" name="__hacklabr_form" value="<?= $form['id'] ?>">
        <div class="form__grid">
        <?php foreach ($form['fields'] as $field => $definition): ?>
            <?php render_field($field, $definition, $params); ?>
        <?php endforeach; ?>
        </div>
        <div class="form__buttons">
            <button class="button button--solid" type="submit"><?= $submit_label ?></button>
        </div>
    </form>
<?php
}

function validate_field (array $definition, mixed $value, array $context = []) {
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

    if (empty($errors)) {
        return $errors;
    } else {
        return true;
    }
}
