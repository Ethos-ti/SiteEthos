<?php

namespace hacklabr;

function get_my_plan_data () {
    $user_id = get_current_user_id();

    $plan_slug = get_pmpro_plan($user_id);

    if (empty($plan_slug)) {
        return null;
    }

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

    return $plan;
}

function render_my_plan_callback ($attributes) {
    $plan = get_my_plan_data();

    if (empty($plan)) {
        return '';
    }

    ob_start();
?>
    <div class="my-plan">
        <p><?php _ex('Plan', 'membership', 'hacklabr') ?> <?= $plan->label ?>:</p>
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
