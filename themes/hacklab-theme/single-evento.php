<?php

global $post;

get_header();
$post_id  = get_the_ID();
$category = get_the_category();
$excerpt = !empty($post->post_excerpt) ? wp_kses_post($post->post_excerpt) : '';
$terms    = get_html_terms( $post_id , 'tribe_events_cat' );
$workload = get_post_meta($post_id, 'carga_horaria_total', true );
$investiment = get_post_meta($post_id, '_EventCost', true );
$local = get_post_meta($post_id, 'local', true );
$date = get_post_meta($post_id, 'data-do-evento', true );
$time = get_post_meta($post_id, 'horario', true );

?>

<header class="post-header">
    <div class="post-header__postdata container--wide">

    <div class="post-header__postdata__date">

        <?php if ( $terms ) : ?>
            <div class="tag-event -text-center">
                <span class="tag"><?php echo $terms ?></span>
            </div>
        <?php endif; ?>

        <h1 class="post-header__title"> <?php the_title(); ?> </h1>

        <?php if ( $excerpt ) : ?>
            <p class="post-header__excerpt container"><?= get_the_excerpt() ?></p>
        <?php endif; ?>

        <div class="post-header__meta container">
            <p class="post-header__date"><?php _e('Published in ', 'hacklabr') ?><?= get_the_date() ?></p>
            <?php get_template_part('template-parts/share-links', null, ['link' => get_the_permalink()]) ?>
        </div>
    </div>

    <div class="event-metadada-section">
        <div class="event-metadada container">
            <div class="event-metadada__infos -text-center">
                <?php if ($date) : ?>
                <div class="event-metadada__infos__date">
                    <p class="-bold"><?php _e('Date', 'Hacklabr') ?></p>
                    <?php echo apply_filters('the_content', $date); ?>
                </div>
                <?php endif; ?>
                <?php if ($time) : ?>
                <div class="event-metadada__infos__date">
                    <p class="-bold"><?php _e('Time', 'Hacklabr') ?></p>
                    <?php echo apply_filters('the_content', $time); ?>
                </div>
                <?php endif; ?>
                <?php if ($workload) : ?>
                    <div class="event-metadada__infos__workload">
                        <p class="-bold"><?php _e('Workload', 'Hacklabr') ?></p>
                        <?php echo apply_filters('the_content', $workload); ?>
                    </div>
                <?php endif; ?>
                <?php if ($investiment) : ?>
                <div class="event-metadada__infos__investment">
                    <p class="-bold"><?php _e('Investment', 'Hacklabr') ?></p>
                    <?php echo apply_filters('the_content', $investiment); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($local) : ?>
            <div class="event-metadada__location -text-center">
                <div class="event-metadada__location__local">
                    <p class="-bold"><?php _e('Local', 'Hacklabr') ?></p>
                    <?php echo apply_filters('the_content', $local); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</header>

<main class="post-content stack container">
    <?php the_content() ?>
</main>

<?php get_footer() ?>
