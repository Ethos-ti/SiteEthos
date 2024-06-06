<?php

namespace hacklabr\Fields;

function render_input_field (string $name, mixed $value, array $definition) {
?>
    <input
        id="<?= $name ?>"
        name="_<?= $name ?>"
        placeholder="<?= $definition['placeholder'] ?>"
        type="<?= $definition['type'] ?>"
        <?= $definition['required'] ? 'required' : '' ?>
        value="<?= $value ?>"
        aria-errormessage="<?= $name ?>__error"
        <?= (isset($definition['disabled']) && $definition['disabled']) ? 'disabled' : '' ?>
    >
<?php
}
