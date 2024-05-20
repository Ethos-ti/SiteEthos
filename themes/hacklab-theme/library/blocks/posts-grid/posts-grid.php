<?php

namespace hacklabr;

function get_posts_grid_render_data ($attributes, $posts_to_show): \WP_Query {
    global $newspack_blocks_post_id;
    global $hacklabr_blocks_post_ids;

    if (!$newspack_blocks_post_id) {
        $newspack_blocks_post_id = [];
    }

    if (!$hacklabr_blocks_post_ids) {
        $hacklabr_blocks_post_ids = [];
    }

    $post__not_in = array_merge($newspack_blocks_post_id, $hacklabr_blocks_post_ids);

    $cached_query = get_block_transient('hacklabr/posts', $attributes);
    if ($cached_query !== false) {
        return $cached_query;
    }

    $query_args = build_posts_query($attributes, $posts_to_show, $post__not_in);
    $query = new \WP_Query($query_args);

    set_block_transient('hacklabr/posts', $attributes, $query);

    return $query;
}

function render_posts_grid_callback ($attributes) {
    $card_model = $attributes['cardModel'];
    $posts_per_column = $attributes['postsPerColumn'] ?: 1;
    $posts_per_row = $attributes['postsPerRow'] ?: 1;

    $query = get_posts_grid_render_data($attributes, $posts_per_column * $posts_per_row);

    ob_start();
    ?>

    <div class="posts-grid-block" style="--grid-columns: <?= $posts_per_row ?>">
        <?php foreach ($query->posts as $post):
            get_template_part('template-parts/post-card', $card_model ?: null, [ 'post' => $post ]);
        endforeach; ?>
    </div>

    <?php
    $output = ob_get_clean();

    return $output;
}
