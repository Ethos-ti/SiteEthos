<?php

namespace hacklabr;

function get_payments_history_data ($attributes): array {
    return [];
}

function render_payments_history_callback ($attributes) {
    $query = get_posts_grid_data($attributes);

    ob_start();
    ?>

    <table class="hacklabr-payments-history-block">
      <thead>
        <tr>
            <th>Data</th>
            <th class="id-pedido">Id do Pedido</th>
            <th>Nível</th>
            <th>Valor</th>
            <th>Status</th>
        </tr>
      </thead>

      <tbody>
      <tr>
        <td>Janeiro 2024</td>
        <td class="id-pedido">1F5E4D4784</td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pendente"><span>Pendente</span></td>
      </tr>
      <tr>
        <td>Dezembro 2023</td>
        <td class="id-pedido">5BEE44D535</td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pendente"><span>Pendente</span></td>
      </tr>
      <tr>
        <td>Novembro 2023</td>
        <td class="id-pedido">5097EECC89</td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pago"><span>Pago</span></td>
      </tr>
      <tr>
        <td>Outubro 2023</td>
        <td class="id-pedido">564S81B7C6</td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pago"><span>Pago</span></td>
      </tr>
      <tr>
        <td>Setembro 2023</td>
        <td class="id-pedido">99F4653F21</td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pago"><span>Pago</span></td>
      </tr>
      <tr>
        <td>Agosto 2023</td>
        <td class="id-pedido">2DFFBC4B8D</td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pago" ><span>Pago</span></td>
      </tr>
      </tbody>
    </table>

    <?php
    $output = ob_get_clean();

    return $output;
}
