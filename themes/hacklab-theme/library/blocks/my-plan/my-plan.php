<?php

namespace hacklabr;

function get_my_plan_data () {
    $user_id = get_current_user_id();

    $organization = get_organization_by_user($user_id);

    if (empty($organization)) {
        return [null, null];
    }

    $group_id = get_post_meta($organization->ID, '_pmpro_group', true);
    $group = get_pmpro_group($group_id);

    $plan_slug = Fields\get_pmpro_level_slug_by_id($group->group_parent_level_id);

    if ($plan_slug === 'conexao') {
        $plan = (object) [
            'label' => 'Conexão',
            'slug' => 'conexao',
            'contains' => ['conexao'],
        ];
    } else if ($plan_slug === 'essencial') {
        $plan = (object) [
            'label' => 'Essencial',
            'slug' => 'essencial',
            'contains' => ['essencial', 'conexao'],
        ];
    } else if ($plan_slug === 'vivencia') {
        $plan = (object) [
            'label' => 'Vivência',
            'slug' => 'vivencia',
            'contains' => ['vivencia', 'essencial', 'conexao'],
        ];
    } else {
        $plan = (object) [
            'label' => 'Institucional',
            'slug' => 'institucional',
            'contains' => ['institucional', 'vivencia', 'essencial', 'conexao'],
        ];
    }

    return [$organization, $plan];
}

function render_my_plan_callback ($attributes) {
    [$organization, $plan] = get_my_plan_data();

    if (empty($organization)) {
        return '';
    }

    ob_start();
?>
    <div class="my-plan">
        <p class="my-plan__summary">
            <?= get_the_title($organization) ?> tem o plano <b><?= $plan->label ?></b>.
        </p>
        <p>Plano <?= $plan->label ?>:</p>
        <div class="my-plan__advantages">
            <?php foreach ($plan->contains as $slug): ?>
                <?php dynamic_sidebar('vantagens_' . $slug); ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php
    $output = ob_get_clean();

    return $output;
}
