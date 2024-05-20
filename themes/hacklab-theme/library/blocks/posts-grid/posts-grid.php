<?php

namespace hacklabr;

function get_posts_grid_data ($attributes): \WP_Query {
    $cached_query = get_block_transient('hacklabr/posts', $attributes);
    if ($cached_query !== false) {
        return $cached_query;
    }

    $post__not_in = get_used_post_ids();

    $query_args = build_posts_query($attributes, $post__not_in);
    $query = new \WP_Query($query_args);

    set_block_transient('hacklabr/posts', $attributes, $query);

    return $query;
}

function render_posts_grid_callback ($attributes) {
    $card_model = $attributes['cardModel'];
    $posts_per_column = $attributes['postsPerColumn'] ?: 1;
    $posts_per_row = $attributes['postsPerRow'] ?: 1;

    // Normalize attributes before calling `build_posts_query`
    unset($attributes['cardModel']);
    unset($attributes['postsPerColumn']);
    unset($attributes['postsPerRow']);
    $attributes['postsPerPage'] = $posts_per_column * $posts_per_row;

    $query = get_posts_grid_data($attributes);

    ob_start();
    ?>

    <div class="posts-grid-block" style="--grid-columns: <?= $posts_per_row ?>">
        <?php foreach ($query->posts as $post):
            mark_post_id_as_used($post->ID);
            get_template_part('template-parts/post-card', $card_model ?: null, [ 'post' => $post ]);
        endforeach; ?>
    </div>

    <?php
    $output = ob_get_clean();

    return $output;
}
