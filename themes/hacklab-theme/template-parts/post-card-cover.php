<?php
if ( isset($args['modifiers']) ) {
    $args['modifiers'][] = 'cover';
} else {
    $args['modifiers'] = ['cover'];
}
get_template_part('template-parts/post-card', null, $args);

