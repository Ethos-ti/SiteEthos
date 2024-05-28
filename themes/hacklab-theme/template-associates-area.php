<?php
/**
 * Template Name: Área de associados
 */

get_header();

$current_post_id = get_the_ID();

?>

<div class="content-sidebar">
    <div class="container container--wide content-sidebar__container">
        <aside class="content-sidebar__sidebar">
            <p class="content-sidebar__sidebar-description"><?= __( 'Associeted panel', 'hacklabr' ); ?></p>
            <?php
            $associates_areas = \get_pages_by_template( 'template-associates-area.php' );

            if ( $associates_areas ) {
                echo '<ul class="content-sidebar__list">';
                foreach ( $associates_areas as $associates_area ) {
                    $css_class = $current_post_id === $associates_area->ID ? 'content-sidebar__list-item content-sidebar__list-item--active' : 'content-sidebar__list-item';
                    echo '<li class="' . $css_class . '"><a href="' . esc_url( get_permalink( $associates_area ) ) . '">' . wp_kses_post( get_the_title( $associates_area ) ) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>

            <a class="button button--outline" href="<?= wp_logout_url( get_login_page_url() ); ?>"><?= __( 'Logout', 'hacklabr' ); ?></a>
        </aside>
        <main class="content-sidebar__content stack">
            <?php the_content(); ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>
