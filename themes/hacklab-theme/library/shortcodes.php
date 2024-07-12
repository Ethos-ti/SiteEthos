<?php

namespace hacklabr;

function ethos_org_manager_shortcode ($attributes) {
    $attrs = shortcode_atts([
        'postid' => null,
    ], $attributes);

    $post_id = null;

    if (!empty($attrs['postid'])) {
        $post_id = intval($attrs['postid']);
    } else {
        $user_id = get_current_user_id();

        if (!empty($user_id)) {            
            $organizations = get_posts([
                'post_type' => 'organizacao',
                'author' => $user_id,
                'posts_per_page' => 1,
            ]);

            if (!empty($organizations)) {
                $post_id = $organizations[0]->ID;
            }
        }
    }

    if (empty($post_id)) {
        return '(Nome de gerente)';
    }

    $group_id = get_post_meta($post_id, '_pmpro_group', true);
    $group = get_pmpro_group($id);

    $manager = get_user_by('ID', $group->group_parent_user_id);
    return $manager->display_name;
}

function ethos_org_name_shortcode ($attributes) {
    $attrs = shortcode_atts([
        'postid' => null,
    ], $attributes);

    $post_id = null;

    if (!empty($attrs['postid'])) {
        $post_id = intval($attrs['postid']);
    } else {
        $user_id = get_current_user_id();

        if (!empty($user_id)) {            
            $organizations = get_posts([
                'post_type' => 'organizacao',
                'author' => $user_id,
                'posts_per_page' => 1,
            ]);

            if (!empty($organizations)) {
                $post_id = $organizations[0];
            }
        }
    }

    if (empty($post_id)) {
        return '(Nome da empresa)';
    }

    $post = get_post($post_id);
    return $post->post_title;
}

function register_shortcodes () {
    add_shortcode('ethos-org-manager', 'hacklabr\\ethos_org_manager_shortcode');
    add_shortcode('ethos-org-name', 'hacklabr\\ethos_org_name_shortcode');
}
add_action('init', 'hacklabr\\register_shortcodes');
