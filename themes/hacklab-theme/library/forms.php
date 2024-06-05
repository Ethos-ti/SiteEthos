<?php

namespace hacklabr;

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

function render_form (array $fields, array $params = []) {
    foreach ($fields as $field => $definition) {
        render_field($field, $definition, $params);
    }
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
