<?php
if ( isset($args['modifiers']) ) {
    $args['modifiers'][] = 'vertical';
} else {
    $args['modifiers'] = ['vertical'];
}

get_template_part('template-parts/post-card', null, $args);
