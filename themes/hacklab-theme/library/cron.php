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

function clean_abandoned_registrations () {
    // Required for using `wp_delete_user` function
	require_once(ABSPATH . 'wp-admin/includes/user.php');

    $TRANSACTION_KEY = '_ethos_transaction';

    $abandoned_posts = get_posts([
        'post_type' => ['organizacao'],
        'post_status' => ['draft', 'ethos_under_progress'],
        'date_query' => [
            [ 'before' => '1 day ago', 'inclusive' => true ],
        ],
        'posts_per_page' => 20,
    ]);

    foreach ($abandoned_posts as $abandoned_post) {
        wp_delete_post($abandoned_post->ID, true);
    }

    $abandoned_users = get_users([
        'role__in' => ['ethos_under_progress'],
        'date_query' => [
            [ 'before' => '1 day ago', 'inclusive' => true ],
        ],
        'number' => 20,
    ]);

    foreach ($abandoned_users as $abandoned_user) {
        wp_delete_user($abandoned_user->ID, null);
    }

    $finished_posts = get_posts([
        'post_type' => ['organizacao'],
        'post_status' => ['publish'],
        'date_query' => [
            [ 'before' => '1 day ago', 'inclusive' => true ],
        ],
        'meta_query' => [
            [ 'key' => $TRANSACTION_KEY, 'compare' => 'EXISTS' ],
        ],
        'posts_per_page' => 20,
    ]);

    foreach ($finished_posts as $finished_post) {
        delete_post_meta($finished_post->ID, $TRANSACTION_KEY);
    }

    $finished_users = get_users([
        'role__in' => ['subscriber'],
        'date_query' => [
            [ 'before' => '1 day ago', 'inclusive' => true ],
        ],
        'meta_query' => [
            [ 'key' => $TRANSACTION_KEY, 'compare' => 'EXISTS' ],
        ],
        'number' => 20,
    ]);

    foreach ($finished_users as $finished_user) {
        delete_user_meta($finished_user->ID, $TRANSACTION_KEY);
    }
}
add_action('hacklabr\\run_every_hour', 'hacklabr\\clean_abandoned_registrations');

function schedule_recurring_tasks () {
    wp_unschedule_hook('hacklabr\\run_every_hour');

    wp_schedule_event(time(), 'hacklabr_hourly', 'hacklabr\\run_every_hour');
}

add_action('after_switch_theme', 'hacklabr\\schedule_recurring_tasks');
