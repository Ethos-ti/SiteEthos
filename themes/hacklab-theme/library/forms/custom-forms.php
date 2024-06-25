<?php

namespace hacklabr;

function wrap_step_5_form ($form_html, $form) {
    if ($form['id'] !== 'member-registration-5' || empty($_GET['orgid'])) {
        return $form_html;
    }

    $post_id = (int) filter_input(INPUT_GET, 'orgid', FILTER_VALIDATE_INT);

    $group_id = (int) get_post_meta($post_id, '_pmpro_group', true);

    $primary_users = get_users([
        'meta_query' => [
            [ 'key' => '_pmpro_group', 'value' => $group_id ],
            [ 'key' => '_pmpro_role', 'value' => 'primary' ],
        ],
    ]);

    $financial_users = get_users([
        'meta_query' => [
            [ 'key' => '_pmpro_group', 'value' => $group_id ],
            [ 'key' => '_pmpro_role', 'value' => 'financial' ],
        ],
    ]);

    $script = <<<SCRIPT
    {
        role: '',
        closeFormModal () {
            this.role = '';
            this.\$refs.formModal.close();
        },
        openFormModal (role) {
            this.role = role;
            this.\$refs.formModal.showModal();
        },
    }
    SCRIPT;

    $form_lines = explode("\n", $form_html);
    array_splice($form_lines, 1, 0, [
        '<input type="hidden" name="__role" :value="role">',
    ]);
    $form_html = implode("\n", $form_lines);

    ob_start();
?>
    <div class="members-form" x-data="<?= $script ?>">
        <div class="members-form__section">
            <div class="members-form__text">
                <h3>Contato Principal</h3>
                <p>Este contato receberá todas as comunicações do Ethos.</p>
                <p>É possível ter mais de uma pessoa como principal</p>
            </div>

            <ul class="members-form__grid">
                <?php foreach ($primary_users as $user): ?>
                <li class="members-form__item">
                    <div class="members-form__card">
                        <div class="members-form__avatar">
                            <?= get_avatar($user->ID, 72); ?>
                        </div>
                        <div class="members-form__user">
                            <h4><?= $user->display_name ?></h4>
                            <p><?= get_user_meta($user->ID, 'cargo', true) ?></p>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>

                <li class="members-form__item">
                    <button type="button" @click="openFormModal('primary')">
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/add.svg" alt="">
                        Adicionar contato
                    </button>
                </li>
            </ul>
        </div>

        <div class="members-form__section">
            <div class="members-form__text">
                <h3>Contato Financeiro</h3>
                <p>Complete os campos a seguir com informações da pessoa que deverá receber os documentos e informações referentes à contribuição associativa.</p>
            </div>

            <ul class="members-form__grid">
            <?php foreach ($financial_users as $user): ?>
                <li class="members-form__item">
                    <div class="members-form__card">
                        <div class="members-form__avatar">
                            <?= get_avatar($user->ID, 72); ?>
                        </div>
                        <div class="members-form__user">
                            <h4><?= $user->display_name ?></h4>
                            <p><?= get_user_meta($user->ID, 'cargo', true) ?></p>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>

                <li class="members-form__item">
                    <button type="button" @click="openFormModal('financial')">
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/add.svg" alt="">
                        Adicionar contato
                    </button>
                </li>
            </ul>
        </div>

        <dialog x-ref="formModal" class="members-form__modal">
            <header class="members-form__modal-header">
                <span>Adicionar contato</span>
                <button type="button" @click="closeFormModal()" title="Fechar">
                    <iconify-icon icon="material-symbols:close"></iconify-icon>
                </button>
            </header>
            <main class="members-form__modal-body"><?= $form_html ?></main>
        </dialog>
    </div>
<?php
    $html = ob_get_clean();

    return $html;
}
add_action('hacklabr\\form_output', 'hacklabr\\wrap_step_5_form', 10, 2);
