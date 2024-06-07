<?php

namespace hacklabr\Fields;

function render_checkbox_field (string $name, $value, array $definition) {
    $value = maybe_unserialize($value);
?>
    <input
        class="checkbox"
        id="<?= $name ?>"
        name="_<?= $name ?>"
        <?= $definition['required'] ? 'required' : '' ?>
        type="checkbox"
        value="yes"
        <?php checked('yes', $value) ?>
        aria-errormessage="<?= $name ?>__error"
        <?= (!empty($definition['disabled'])) ? 'disabled' : '' ?>
    >
<?php
}

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

function render_select_field (string $name, $value, array $definition) {
    $placeholder = $definition['placeholder'] ?? __('Select an option', 'hacklabr');
?>
	<select
        class="form-field__input select"
        id="<?= $name ?>"
        name="_<?= $name ?>"
		<?= $definition['required'] ? 'required' : '' ?>
		aria-errormessage="<?= $name ?>__error"
	>
	<?php if (empty($value)): ?>
		<option value="" disabled selected>
			<?= $placeholder ?>
		</option>
	<?php endif; ?>
	<?php foreach ($definition['options'] as $option => $option_label): ?>
		<option value="<?= $option ?>" <?php selected($value, $option) ?>>
			<?= $option_label ?>
		</option>
	<?php endforeach; ?>
	</select>
<?php
}

function render_static_field (string $name, $value, array $definition) {
    echo $definition['html'];
}

function render_textarea_field (string $name, $value, array $definition) {
    $placeholder = $definition['placeholder'] ?? '';
?>
    <textarea
        class="form-field__input text-input"
        id="<?= $name ?>"
        name="_<?= $name ?>"
        placeholder="<?= $placeholder ?>"
        <?= $definition['required'] ? 'required' : '' ?>
        aria-errormessage="<?= $name ?>__error"
        <?= (!empty($definition['disabled'])) ? 'disabled' : '' ?>
    ><?= esc_html($value) ?></textarea>
<?php
}
