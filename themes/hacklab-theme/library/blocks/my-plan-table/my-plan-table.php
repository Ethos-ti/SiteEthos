<?php

namespace hacklabr;

function get_my_plan_table_data () {
    $user_id = get_current_user_id();

    $plan = get_pmpro_plan($user_id);

    return $plan ?: 'conexao';
}

function render_my_plan_table_callback ($attributes, $content) {
    $plan = get_my_plan_table_data();

    ob_start();
?>
    <div class="my-plan-table my-plan-table--<?= $plan ?>">
        <table>
            <thead>
                <tr>
                    <th><?php _e('Benefits', 'hacklabr') ?></th>
                    <th class="my-plan-table__conexao">Conexão</th>
                    <th class="my-plan-table__essencial">Essencial</th>
                    <th class="my-plan-table__vivencia">Vivência</th>
                    <th class="my-plan-table__institucional">Institucional</th>
                </tr>
            </thead>
            <tbody>
                <?= $content ?>
            </tbody>
        </table>
    </div>
<?php
    $output = ob_get_clean();

    return $output;
}
