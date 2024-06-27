<?php

global $post;

get_header();

$post_id  = get_the_ID();
$category = get_the_category();
$excerpt = !empty($post->post_excerpt) ? wp_kses_post($post->post_excerpt) : '';
$terms    = get_html_terms( $post_id , 'tribe_events_cat' );
$workload = get_post_meta($post_id, 'carga_horaria_total', true );
$investiment = get_post_meta($post_id, '_EventCost', true );
$local = tribe_get_venue($post_id);
$start = get_post_meta($post_id, '_EventStartDate', true );
$end = get_post_meta($post_id, '_EventEndDate', true );
$recurrence = get_post_meta($post_id, '_EventRecurrence', true );

// Verifica se há recorrência configurada
if (!empty($recurrence)) {
    // Itera sobre as regras de recorrência
    foreach ($recurrence[0]['rules'] as $rule) {
        // Obtém os detalhes da regra
        $type = $rule['type'];
        $interval = $rule['custom']['interval'];
        $days = $rule['custom']['week']['day'];
        $same_time = $rule['custom']['same-time'];
        $recurrence_type = $rule['custom']['type'];
        $end_type = $rule['end-type'];
        $end_count = $rule['end-count'];

        // Converte os dias da semana para nomes legíveis
        $week_days = array(
            '1' => 'Segunda-feira',
            '2' => 'Terça-feira',
            '3' => 'Quarta-feira',
            '4' => 'Quinta-feira',
            '5' => 'Sexta-feira',
            '6' => 'Sábado',
            '7' => 'Domingo',
        );
        $day_names = array_map(function($day) use ($week_days) {
            return $week_days[$day];
        }, $days);
    }
}

?>

<header class="post-header">
    <div class="post-header__postdata alingfull">
        <div class="post-header__postdata__date container--wide">
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
    </div>
    <div class="event-metadada-section">
        <div class="event-metadada container">
            <div class="event-metadada__infos -text-center">
                <?php
                if ($start) :
                    $date = new DateTime($start);
                    $formatted_date_time = $date->format('d/m/Y H:i:s');
                    ?>
                    <div class="event-metadada__infos__date">
                        <p class="-bold"><?php _e('Start', 'hacklabr') ?></p>
                        <?php echo apply_filters('the_content', $formatted_date_time); ?>
                    </div>
                <?php endif; ?>
                <?php if ($end) :
                    $date = new DateTime($end);
                    $formatted_date_time = $date->format('d/m/Y H:i:s');
                    ?>
                    <div class="event-metadada__infos__date">
                        <p class="-bold"><?php _e('End', 'hacklabr') ?></p>
                        <?php echo apply_filters('the_content', $formatted_date_time); ?>
                    </div>
                <?php endif; ?>
                <?php if ($workload) : ?>
                    <div class="event-metadada__infos__workload">
                        <p class="-bold"><?php _e('Workload', 'hacklabr') ?></p>
                        <?php echo apply_filters('the_content', $workload); ?>
                    </div>
                <?php endif; ?>
                <?php if ($investiment) : ?>
                <div class="event-metadada__infos__investment">
                    <p class="-bold"><?php _e('Investment', 'hacklabr') ?></p>
                    <?php echo apply_filters('the_content', $investiment); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($local) : ?>
                <div class="event-metadada__location -text-center">
                    <div class="event-metadada__location__local">
                        <p class="-bold"><?php _e('Local', 'hacklabr') ?></p>
                        <?php echo apply_filters('the_content', $local); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($recurrence) : ?>
                <div class="event-recurrence">
                    <h3>Detalhes da Recorrência</h3>
                    <p><strong>Tipo:</strong> <?php echo esc_html($recurrence_type); ?></p>
                    <p><strong>Intervalo:</strong> <?php echo esc_html($interval); ?> semana(s)</p>
                    <p><strong>Dias:</strong> <?php echo implode(', ', $day_names); ?></p>
                    <p><strong>Mesmo horário:</strong> <?php echo esc_html($same_time); ?></p>
                    <p><strong>Fim após:</strong> <?php echo esc_html($end_count); ?> ocorrências</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</header>

<main class="post-content stack container">
    <?php the_content() ?>
</main>

<?php get_footer() ?>
