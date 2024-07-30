<?php
/**
 * Template Name: Membership area
 */
function show_associated_page() {
    // Obtemos a página atual
    global $post;

    if (!$post) {
        return;
    }

    $admin_pages = [
        'perfil-da-empresa',
        'meu-plano',
        'minhas-solicitacoes',
        'pagamentos',
    ];

    // Verifica se a página atual está na lista de páginas administrativas
    if (in_array($post->post_name, $admin_pages)) {
        $user_id = get_current_user_id();

        // Verifica se o usuário não é administrador
        if (!(bool) get_user_meta($user_id, '_ethos_admin', true)) {
            // Redireciona para a página de boas vindas
            wp_redirect(home_url('/boas-vindas/'));
            exit;
        }
    }
}
add_action('template_redirect', 'show_associated_page');
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
                    if(show_associated_page($associates_area)){
                        $css_class = $current_post_id === $associates_area->ID ? 'content-sidebar__list-item content-sidebar__list-item--active' : 'content-sidebar__list-item';
                        echo '<li class="' . $css_class . '"><a href="' . esc_url( get_permalink( $associates_area ) ) . '">' . wp_kses_post( get_the_title( $associates_area ) ) . '</a></li>';
                    }
                }
                echo '</ul>';
            }
            ?>

            <a class="button button--outline" href="<?= wp_logout_url( get_login_page_url() ); ?>"><?= __( 'Logout', 'hacklabr' ); ?></a>
        </aside>
        <main class="content-sidebar__content stack">
            <div class="collapse-menu active"></div>
            <?php the_content(); ?>

            <script>
                document.querySelector( '.collapse-menu' ).addEventListener( 'click', function() {
                    var sidebar = document.querySelector( '.content-sidebar__sidebar' );
                    if ( sidebar.style.display === 'none' || sidebar.style.display === '' ) {
                        sidebar.style.display = 'block';
                    } else {
                        sidebar.style.display = 'none';
                    }
                });
            </script>
        </main>
    </div>
</div>

<?php get_footer(); ?>
