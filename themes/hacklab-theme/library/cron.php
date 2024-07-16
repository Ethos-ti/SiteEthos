<?php

namespace hacklabr;

function add_cron_schedules (array $schedules) {
    $schedules['hacklabr_hourly'] = [
        'interval' => 3600,
        'display' => __('Hourly', 'hacklabr'),
    ];

    return $schedules;
}
add_filter('cron_schedules', 'hacklabr\\add_cron_schedules');

function clean_transactions () {
    $TRANSACTION_KEY = '_ethos_transaction';

    $posts = get_posts([
        'post_type' => ['organizacao'],
        'post_status' => ['draft', 'ethos_under_progress', 'publish'],
        'date_query' => [
            [ 'before' => '1 day ago', 'inclusive' => true ],
        ],
        'meta_query' => [
            [ 'key' => $TRANSACTION_KEY, 'compare' => 'EXISTS' ],
        ],
        'posts_per_page' => 20,
    ]);

    foreach ($posts as $post) {
        delete_post_meta($post->ID, $TRANSACTION_KEY);
    }

    $users = get_users([
        'role__in' => ['ethos_under_progress', 'subscriber'],
        'date_query' => [
            [ 'before' => '1 day ago', 'inclusive' => true ],
        ],
        'meta_query' => [
            [ 'key' => $TRANSACTION_KEY, 'compare' => 'EXISTS' ],
        ],
        'number' => 20,
    ]);

    foreach ($users as $user) {
        delete_user_meta($user->ID, $TRANSACTION_KEY);
    }
}
add_action('hacklabr\\run_every_hour', 'hacklabr\\clean_transactions');

function schedule_recurring_tasks () {
    wp_unschedule_hook('hacklabr\\run_every_hour');

    wp_schedule_event(time(), 'hacklabr_hourly', 'hacklabr\\run_every_hour');
}

add_action('after_switch_theme', 'hacklabr\\schedule_recurring_tasks');
