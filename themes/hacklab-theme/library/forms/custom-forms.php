<?php

namespace hacklabr;

function get_user_fields ($user, $fields) {
    $data = [
        'ID' => $user->ID,
    ];

    $user_meta = get_user_meta($user->ID);

    foreach ($fields as $key => $field) {
        if (!empty($user_meta[$key])) {
            $data[$key] = $user_meta[$key][0];
        }
    }

    return $data;
}

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
                <h3><?php _e('Main contacts', 'hacklabr') ?></h3>
                <p><?php _e('This contact will receive all communications by Ethos.', 'hacklabr') ?></p>
                <p><?php _e("It's possible to have more than one main contact.", 'hacklabr') ?></p>
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
                        <?php _e('Add contact', 'hacklabr') ?>
                    </button>
                </li>
            </ul>
        </div>

        <div class="members-form__section">
            <div class="members-form__text">
                <h3><?php _e('Financial contact', 'hacklabr') ?></h3>
                <p><?php _e('This contact will receive documents and communications related to the membership payments.', 'hacklabr') ?></p>
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
                        <?php _e('Add contact', 'hacklabr') ?>
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
                <span><?php _e('Add contact', 'hacklabr') ?></span>
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

function wrap_edit_contacts_form ($form_html, $form) {
    if ($form['id'] !== 'edit-organization-contacts') {
        return $form_html;
    }

    $current_user = get_current_user_id();
    $group_id = (int) get_user_meta($current_user, '_pmpro_group', true);

    if (empty($group_id)) {
        return $form_html;
    }

    $add_contact_str = esc_attr(__('Add contact', 'hacklabr'));
    $confirm_removal_str = esc_attr(__('Are you sure you want to delete the user?', 'hacklabr'));
    $edit_contact_str = esc_attr(__('Edit contact', 'hacklabr'));
    $replace_approver_str = esc_attr(__('You can only have one approver by team, do you want to replace the remover?', 'hacklabr'));

    $script = <<<SCRIPT
    {
        action: '',
        userId: null,
        closeFormModal () {
            this.\$refs.formModal.close();
        },
        createUser () {
            const form = document.querySelector('#form_edit-organization-contacts');
            for (const [key, el] of Object.entries(form.elements)) {
                if (key.match(/^[a-z]/)) {
                    el.value = '';
                }
            }
            this.userId = null;
            this.\$refs.formModal.showModal();
        },
        deleteUser (userId) {
            if (confirm("$confirm_removal_str")) {
                this.action = 'deleteUser';
                this.userId = userId;
                \$nextTick(() => this.\$refs.implicitForm.submit());
            }
        },
        editUser (user) {
            const form = document.querySelector('#form_edit-organization-contacts');
            for (const [key, value] of Object.entries(user)) {
                if (form.elements[key]) {
                    form.elements[key].value = value;
                    if (form.elements[key]._mask) {
                        form.elements[key]._mask.value = value;
                    }
                }
            }
            this.userId = user.ID;
            this.\$refs.formModal.showModal();
        },
        toggleAdmin (el, user) {
            this.action = el.checked ? 'addAdmin' : 'removeAdmin';
            this.userId = user.ID;
            \$nextTick(() => this.\$refs.implicitForm.submit());
        },
        toggleApprover (el, user) {
            if (el.checked) {
                if (confirm("$replace_approver_str")) {
                    this.action = 'addApprover';
                    this.userId = user.ID;
                    \$nextTick(() => this.\$refs.implicitForm.submit());
                } else {
                    el.checked = false;
                }
            } else {
                this.action = 'removeApprover';
                this.userId = user.ID;
                \$nextTick(() => this.\$refs.implicitForm.submit());
            }
        }
    }
    SCRIPT;

    $form_lines = explode("\n", $form_html);
    array_splice($form_lines, 1, 0, [
        '<input type="hidden" name="__action" :value="action">',
        '<input type="hidden" name="__user_id" :value="userId">',
    ]);
    $form_html = implode("\n", $form_lines);

    $fields = $form['options']['fields'];

    $group = get_pmpro_group($group_id);
    $original_user = $group->group_parent_user_id;

    $contacts = get_users([
        // 'role__in' => ['subscriber'],
        'meta_query' => [
            [ 'key' => '_pmpro_group', 'value' => $group_id ],
        ],
        'orderby' => 'display_name',
    ]);

    ob_start();
?>
    <div class="contacts-list" x-data="<?= esc_attr($script) ?>" x-ref="contactsList">
        <div class="contacts-list__count">Total de <?= count($contacts) ?> contatos cadastrados</div>

        <div class="contacts-list__buttons">
            <button class="button button--outline" @click="createUser()">
                <?php _e('Add one more contact', 'hacklabr') ?>
            </button>
        </div>

        <div class="contacts-list__table">
            <table>
                <thead>
                    <tr>
                        <th><?php _e('Name', 'hacklabr') ?></th>
                        <th><?php _e('Email', 'hacklabr') ?></th>
                        <th><?php _e('Approver', 'hacklabr') ?></th>
                        <th><?php _e('Administrator', 'hacklabr') ?></th>
                        <th><span class="sr-only"><?php _e('Edit', 'hacklabr') ?></span></th>
                        <th><span class="sr-only"><?php _e('Delete', 'hacklabr') ?></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr x-data="{ user: <?= esc_attr(json_encode(get_user_fields($contact, $fields))) ?> }">
                        <td><?= $contact->display_name ?></td>
                        <td><?= $contact->user_email ?></td>
                        <td>
                            <input type="checkbox"<?php checked('1', get_user_meta($contact->ID, '_ethos_approver', true)) ?> @click="toggleApprover($el, user)">
                        </td>
                        <td>
                            <input type="checkbox"<?php checked('1', get_user_meta($contact->ID, '_ethos_admin', true)) ?> @click="toggleAdmin($el, user)">
                        </td>
                        <td>
                            <button type="button" class="contacts-list__edit" title="<?php _e('Edit', 'hacklabr') ?>" @click="editUser(user)">
                                <iconify-icon icon="material-symbols:edit-outline"></iconify-icon>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="contacts-list__remove"<?= ($contact->ID === $current_user || $contact->ID === $original_user) ? ' disabled' : '' ?> title="<?php _e('Delete', 'hacklabr') ?>" @click="deleteUser(<?= $contact->ID ?>)">
                                <iconify-icon icon="material-symbols:delete-outline"></iconify-icon>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <form x-ref="implicitForm" method="post">
            <input type="hidden" name="__hacklabr_form" value="edit-organization-contacts__hidden">
            <input type="hidden" name="__action" :value="action">
            <input type="hidden" name="__user_id" :value="userId">
        </form>

        <dialog x-ref="formModal" class="contacts-list__modal">
            <header class="contacts-list__modal-header">
                <span x-text="userId ? '<?= $add_contact_str ?>' : '<?= $add_contact_str ?>'"></span>
                <button type="button" @click="closeFormModal()" title="Fechar">
                    <iconify-icon icon="material-symbols:close"></iconify-icon>
                </button>
            </header>
            <main class="contacts-list__modal-body"><?= $form_html ?></main>
        </dialog>
    </div>
<?php
    $html = ob_get_clean();

    return $html;
}
add_action('hacklabr\\form_output', 'hacklabr\\wrap_edit_contacts_form', 10, 2);
