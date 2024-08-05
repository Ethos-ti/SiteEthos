<?php

namespace hacklabr;

function get_subscription_data ($attributes): array {
    $account_id = $attributes['account_id'];

    $cached_data = get_block_transient('hacklabr/subscription', $attributes);
    if ($cached_data !== false) {
        return $cached_data;
    }

    $subscriptions_col = \hacklabr\get_crm_entities('fut_participante', [
        'filters' => [
            'fut_lk_empresa' => $account_id,
        ],
    ]);

    $subscriptions = $subscriptions_col->Entities ?? [];

    set_block_transient('hacklabr/subscription', $attributes, $subscriptions);

    return $subscriptions;
}

function render_subscription_callback ($attributes) {
    $user_id = get_current_user_id();

    $organization = get_organization_by_user($user_id);

    if (empty($organization)) {
        return '';
    }

    $account_id = get_post_meta($organization->ID, '_ethos_crm_account_id', true);

    $subscriptions = get_subscription_data([ 'account_id' => $account_id ]);

    // echo '<pre>';
    // var_dump($subscriptions);
    // echo '</pre>';

    ob_start();
    ?>

    <table class="hacklabr-subscription-block">
        <thead>
            <tr>
                <th><?php _e('Date', 'hacklabr') ?></th>
                <th><?php _e('Title', 'hacklabr') ?></th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($subscriptions as $subscription): ?>
            <?php $event = event_exists_on_wp($subscription->Id); ?>
            <tr>
                <td><?= $subscription->FormattedValues['fut_dt_iniciodaparticipao'] ?? '' ?></td>
                <td><a href="<?= $event ? get_permalink( $event->ID ) : '#' ?>"><?= $subscription->FormattedValues['fut_lk_projeto'] ?></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    $output = ob_get_clean();

    return $output;
}
