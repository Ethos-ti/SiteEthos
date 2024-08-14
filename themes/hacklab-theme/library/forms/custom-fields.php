<?php

namespace hacklabr\Fields;

function render_pmpro_level_field (string $name, $value, array $definition) {
    $kit = filter_input(INPUT_GET, 'kit', FILTER_SANITIZE_ADD_SLASHES) ?? '';

    $post = \hacklabr\get_post_by_transaction('organizacao');

    $level_options = \hacklabr\get_pmpro_level_options($post->ID ?? null, $definition['for_manager']);
    $initial_value = $value ?: ($level_options[$kit] ?? 'null');

    $select_plan_str = esc_attr(__('Select plan', 'hacklabr'));
    $selected_plan_str = esc_attr(__('Selected plan', 'hacklabr'));
?>
    <div class="choose-plan__input" x-data="{ level: <?= $initial_value ?> }">
        <div class="choose-plan__grid">
            <div class="choose-plan__plan">
                <div class="choose-plan__title">
                    <strong>Conexão</strong>
                </div>
                <?php if (is_active_sidebar('vantagens_conexao')): ?>
                    <?php dynamic_sidebar('vantagens_conexao'); ?>
                <?php else: ?>
                    <div class="choose-plan__text"></div>
                <?php endif; ?>
                <div class="choose-plan__button">
                    <button type="button" class="button" :class="level === <?= $level_options['conexao'] ?> ? 'button--solid' : 'button--outline'" @click="level = <?= $level_options['conexao'] ?>">
                        <span x-text="(level === <?= $level_options['conexao'] ?> ? '<?= $selected_plan_str ?>' : '<?= $select_plan_str ?>')"></span>
                    </button>
                </div>
            </div>

            <div class="choose-plan__plan">
                <div class="choose-plan__title">
                    <strong>Essencial</strong>
                </div>
                <?php if (is_active_sidebar('vantagens_essencial')): ?>
                    <?php dynamic_sidebar('vantagens_essencial'); ?>
                <?php else: ?>
                    <div class="choose-plan__text"></div>
                <?php endif; ?>
                <div class="choose-plan__button">
                    <button type="button" class="button" :class="level === <?= $level_options['essencial'] ?> ? 'button--solid' : 'button--outline'" @click="level = <?= $level_options['essencial'] ?>">
                        <span x-text="(level === <?= $level_options['essencial'] ?> ? '<?= $selected_plan_str ?>' : '<?= $select_plan_str ?>')"></span>
                    </button>
                </div>
            </div>

            <div class="choose-plan__plan">
                <div class="choose-plan__title">
                    <strong>Vivência</strong>
                </div>
                <?php if (is_active_sidebar('vantagens_vivencia')): ?>
                    <?php dynamic_sidebar('vantagens_vivencia'); ?>
                <?php else: ?>
                    <div class="choose-plan__text"></div>
                <?php endif; ?>
                <div class="choose-plan__button">
                    <button type="button" class="button" :class="level === <?= $level_options['vivencia'] ?> ? 'button--solid' : 'button--outline'" @click="level = <?= $level_options['vivencia'] ?>">
                        <span x-text="(level === <?= $level_options['vivencia'] ?> ? '<?= $selected_plan_str ?>' : '<?= $select_plan_str ?>')"></span>
                    </button>
                </div>
            </div>

            <div class="choose-plan__plan">
                <div class="choose-plan__title">
                    <strong>Institucional</strong>
                </div>
                <?php if (is_active_sidebar('vantagens_institucional')): ?>
                    <?php dynamic_sidebar('vantagens_institucional'); ?>
                <?php else: ?>
                    <div class="choose-plan__text"></div>
                <?php endif; ?>
                <div class="choose-plan__button">
                    <button type="button" class="button" :class="level === <?= $level_options['institucional'] ?> ? 'button--solid' : 'button--outline'" @click="level = <?= $level_options['institucional'] ?>">
                        <span x-text="(level === <?= $level_options['institucional'] ?> ? '<?= $selected_plan_str ?>' : '<?= $select_plan_str ?>')"></span>
                    </button>
                </div>
            </div>
        </div>

        <input type="hidden" name="_<?= $name ?>" :value="level">
    </div>
<?php
}
