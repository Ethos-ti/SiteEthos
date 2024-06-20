<?php

namespace hacklabr\Fields;

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
    $org_id = (int) filter_input(INPUT_GET, 'orgid', FILTER_VALIDATE_INT);
    $level_options = get_pmpro_level_options($org_id, $definition['for_manager']);
?>
    <div class="choose-plan__input" x-data="{ level: <?= $value ?: 'null' ?> }">
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
                <?php if (is_active_sidebar('vantagens_essencial')): ?>
                    <?php dynamic_sidebar('vantagens_essencial'); ?>
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
                <?php if (is_active_sidebar('vantagens_essencial')): ?>
                    <?php dynamic_sidebar('vantagens_essencial'); ?>
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
