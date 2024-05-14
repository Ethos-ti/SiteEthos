<?php
if ( isset($args['modifiers']) ) {
    $args['modifiers'][] = 'horizontal';
} else {
    $args['modifiers'] = ['horizontal'];
}

get_template_part('template-parts/post-card', null, $args);
