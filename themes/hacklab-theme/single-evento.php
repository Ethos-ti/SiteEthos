<?php
get_header();
the_post();
$category = get_the_category();
$excerpt = !empty($post->post_excerpt) ? wp_kses_post($post->post_excerpt) : '';

?>

<header class="post-header">
    <div class="post-header__postdata container--wide">
        <h1 class="post-header__title"> <?php the_title(); ?> </h1>

        <?php if ( $excerpt ) : ?>
            <p class="post-header__excerpt container--narrow"><?= get_the_excerpt() ?></p>
        <?php endif; ?>

        <div class="post-header__meta container">
            <p class="post-header__date"><?php _e('Published in ', 'hacklabr') ?><?= get_the_date() ?></p>
            <?php get_template_part('template-parts/share-links', null, ['link' => get_the_permalink()]) ?>
        </div>
    </div>

    <div class="event-metadada-section">
        <div class="event-metadada container">
            <div class="event-metadada__infos -text-center">
                <div class="event-metadada__infos__date">
                    <p class="-bold"><?php _e('Date', 'Hacklabr') ?></p>
                    <p><?php _e('08/10/2024', 'Hacklabr') ?></p>
                </div>
                <div class="event-metadada__infos__time">
                    <p class="-bold"><?php _e('Time', 'Hacklabr') ?></p>
                    <p><?php _e('das 8h às 18h30', 'Hacklabr') ?></p>
                </div>
                <div class="event-metadada__infos__workload">
                    <p class="-bold"><?php _e('Workload', 'Hacklabr') ?></p>
                    <p><?php _e('3 horas', 'Hacklabr') ?></p>
                </div>
                <div class="event-metadada__infos__investment">
                    <p class="-bold"><?php _e('Investment', 'Hacklabr') ?></p>
                    <p><?php _e('459,00 (50% de desconto para estudantes)', 'Hacklabr') ?></p>
                </div>
            </div>
            <div class="event-metadada__location -text-center">
                <div class="event-metadada__location__local">
                    <p class="-bold"><?php _e('Local', 'Hacklabr') ?></p>
                    <p><?php _e('Online e ao vivo, via webconferência nas plataformas Zoom e Meeting', 'Hacklabr') ?></p>
                </div>
            </div>
        </div>
    </div>

</header>

<main class="post-content stack container">
    <?php the_content() ?>
</main>

<?php get_footer() ?>
