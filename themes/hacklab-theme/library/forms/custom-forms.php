<?php

namespace hacklabr;

function wrap_step_5_form ($form_html, $form) {
    if ($form['id'] !== 'member-registration-5' || empty($_GET['transaction'])) {
        return $form_html;
    }

    $kit = filter_input(INPUT_GET, 'kit', FILTER_SANITIZE_ADD_SLASHES) ?? null;
    $transaction = filter_input(INPUT_GET, 'transaction', FILTER_SANITIZE_ADD_SLASHES) ?? null;

    $post = get_post_by_transaction('organizacao', $transaction);
    $group_id = (int) get_post_meta($post->ID, '_pmpro_group', true);

    $previous_url = build_registration_step_link('member-registration-4', $kit, $transaction);
    $finish_url = get_permalink(get_page_by_template('template-registration-finished.php'));

    $primary_users = get_users([
        'role__in' => ['ethos_under_progress', 'subscriber'],
        'meta_query' => [
            [ 'key' => '_pmpro_group', 'value' => $group_id ],
            [ 'key' => '_pmpro_role', 'value' => 'primary' ],
        ],
    ]);

    $financial_users = get_users([
        'role__in' => ['ethos_under_progress', 'subscriber'],
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

        <div class="members-form__section">
            <div class="form__buttons form__buttons--has-previous">
                <a class="button button--outline" href="<?= $previous_url ?>"><?= __('Back') ?></a>
                <a class="button button--solid" href="<?= $finish_url ?>"><?= __('Finish', 'hacklabr') ?></a>
            </div>
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
