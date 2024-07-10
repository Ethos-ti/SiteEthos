<?php
/**
 * Template Name: Invoice area
 */

get_header();

$payments_page = get_page_by_path('pagamentos', OBJECT);

$pedido_id = filter_input(INPUT_GET, 'pedido');

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
                    $css_class = $payments_page->ID === $associates_area->ID ? 'content-sidebar__list-item content-sidebar__list-item--active' : 'content-sidebar__list-item';
                    echo '<li class="' . $css_class . '"><a href="' . esc_url( get_permalink( $associates_area ) ) . '">' . wp_kses_post( get_the_title( $associates_area ) ) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>

            <a class="button button--outline" href="<?= wp_logout_url( get_login_page_url() ); ?>"><?= __( 'Logout', 'hacklabr' ); ?></a>
        </aside>
        <main class="content-sidebar__content stack">
            <div class="collapse-menu active"></div>
            <?php the_content(); ?>

            <div class="invoice">
                <span><a class="return__payment" href="https://ethos.hacklab.com.br/associados/pagamentos"> <<< VOLTAR PARA PAGAMENTOS</a></span>
                <h2 class="invoice__title">Fatura Digital</h2>
                <p class="invoice__paragraph">Fatura #<?= $pedido_id; ?>, <?= get_the_date() ?> </p>
                <div class="invoice__items">
                    <ul>
                        <li><b>Conta:</b> ContaDaEmpresa_Membro (e-maildaempresa@mail.com)</li>
                        <li><b>Plano:</b> Vivência</li>
                        <li><b>Status:</b> <span class="status status--pago">Pago</span></li>
                    </ul>
                </div>
                <hr/>
                <div class="invoice__price">
                    <p><b>Preço</b></p>
                    <p>R$ 810,00</p>
                </div>
                <hr/>
            </div>

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

