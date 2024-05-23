<?php
/**
 * Template Name: Área de associados
 */

get_header();

$login_url = \function_exists( 'pmpro_url' ) && ( $pmpro_url = pmpro_url( 'login' ) ) ? $pmpro_url : home_url();
?>

<div class="content-sidebar container">
    <aside class="content-sidebar__sidebar">
        <h6><?= __( 'Associeted panel', 'base-textdomain' ); ?></h6>
        <?php
        $args = [
            'post_type'      => 'page',
            'meta_key'       => '_wp_page_template',
            'meta_value'     => 'template-associates-area.php',
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'posts_per_page' => -1
        ];

        $associates_areas = \get_posts( $args );

        if ( $associates_areas ) {
            echo '<ul class="content-sidebar__list">';
            foreach ( $associates_areas as $associates_area ) {
                $css_class = get_the_ID() === $associates_area->ID ? 'content-sidebar__list-item--active' : 'content-sidebar__list-item';
                echo '<li class="' . $css_class . '"><a href="' . esc_url( get_permalink( $associates_area ) ) . '">' . wp_kses_post( get_the_title( $associates_area ) ) . '</a></li>';
            }
            echo '</ul>';
        }
        ?>

        <a class="button button--outline" href="<?= wp_logout_url( $login_url ); ?>"><?= __( 'Logout', 'base-textdomain' ); ?></a>
    </aside>
    <main class="content-sidebar__content">
        <?php the_content(); ?>
    </main>
</div>

<?php get_footer(); ?>
