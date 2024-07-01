<?php

namespace hacklabr\Fields;

use function hacklabr\get_post_by_transaction;

function get_pmpro_child_level ($level) {
    if ($level === 8 || $level === 9) {
        return $level + 12;
    } else {
        return $level;
    }
}

function get_pmpro_level_options ($organization_id, $for_manager = true) {
    $revenue = get_post_meta($organization_id, 'faturamento_anual', true) ?: 'small';

    if ($revenue === 'small') {
        return [
            'conexao' => $for_manager ? 8 : 20,
            'essencial' => $for_manager ? 9 : 21,
            'vivencia' => 10,
            'institucional' => 11,
        ];
    } else if ($revenue === 'medium') {
        return [
            'conexao' => 12,
            'essencial' => 13,
            'vivencia' => 14,
            'institucional' => 15,
        ];
    } else if ($revenue === 'large') {
        return [
            'conexao' => 16,
            'essencial' => 17,
            'vivencia' => 18,
            'institucional' => 19,
        ];
    }
}

function render_pmpro_level_field (string $name, $value, array $definition) {
    $kit = filter_input(INPUT_GET, 'kit', FILTER_SANITIZE_ADD_SLASHES) ?? '';

    $post = get_post_by_transaction('organizacao');

    $level_options = get_pmpro_level_options($post->ID ?? null, $definition['for_manager']);
    $initial_value = $value ?: ($level_options[$kit] ?? 'null');
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
                        <span x-text="(level === <?= $level_options['conexao'] ?> ? 'Plano selecionado' : 'Selecionar plano')"></span>
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
                        <span x-text="(level === <?= $level_options['essencial'] ?> ? 'Plano selecionado' : 'Selecionar plano')"></span>
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
                        <span x-text="(level === <?= $level_options['vivencia'] ?> ? 'Plano selecionado' : 'Selecionar plano')"></span>
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
                        <span x-text="(level === <?= $level_options['institucional'] ?> ? 'Plano selecionado' : 'Selecionar plano')"></span>
                    </button>
                </div>
            </div>
        </div>

        <input type="hidden" name="_<?= $name ?>" :value="level">
    </div>
<?php
}
