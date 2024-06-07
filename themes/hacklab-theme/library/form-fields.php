<?php

namespace hacklabr\Fields;

function render_input_field (string $name, $value, array $definition) {
    $placeholder = $definition['placeholder'] ?? '';
?>
    <input
        class="form-field__input text-input"
        id="<?= $name ?>"
        name="_<?= $name ?>"
        placeholder="<?= $placeholder ?>"
        type="<?= $definition['type'] ?>"
        <?= $definition['required'] ? 'required' : '' ?>
        value="<?= $value ?>"
        aria-errormessage="<?= $name ?>__error"
        <?= (!empty($definition['disabled'])) ? 'disabled' : '' ?>
    >
<?php
}
