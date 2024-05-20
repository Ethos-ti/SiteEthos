<?php

namespace hacklabr;

function render_post_grid_callback ($attributes) {
    $posts_per_column = $attributes['postsPerColumn'] ?: 1;
    $posts_per_row = $attributes['postsPerRow'] ?: 1;

    ob_start();

    var_dump(build_posts_query($attributes, $posts_per_column * $posts_per_row, []));

    $output = ob_get_clean();

    return $output;
}
