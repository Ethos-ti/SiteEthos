<?php

namespace hacklabr;

function get_payments_history_data ($attributes): array {
    return [];
}

function render_payments_history_callback ($attributes) {
    $query = get_payments_history_data($attributes);

    $invoice_page = get_permalink(get_page_by_template('template-invoice.php'));

    ob_start();
    ?>

    <table class="hacklabr-payments-history-block">
      <thead>
        <tr>
            <th>Data</th>
            <th class="id__pedido">Id do Pedido</th>
            <th>Nível</th>
            <th>Valor</th>
            <th>Status</th>
        </tr>
      </thead>

      <tbody>
      <tr>
        <td>Janeiro 2024</td>
        <?php
            $invoice_link = add_query_arg(['pedido'=> '1F5E4D4784'], $invoice_page);
        ?>
        <td class="id__pedido"><a href="<?= $invoice_link ?>">1F5E4D4784</a></td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pendente"><span>Pendente</span></td>
      </tr>
      <tr>
        <td>Dezembro 2023</td>
        <?php
            $invoice_link = add_query_arg(['pedido'=> '5BEE44D535'], $invoice_page);
        ?>
        <td class="id__pedido"><a href="<?= $invoice_link ?>">5BEE44D535</a></td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pendente"><span>Pendente</span></td>
      </tr>
      <tr>
        <td>Novembro 2023</td>
        <?php
            $invoice_link = add_query_arg(['pedido'=> '5097EECC89'], $invoice_page);
        ?>
        <td class="id__pedido"><a href="<?= $invoice_link ?>">5097EECC89</a></td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pago"><span>Pago</span></td>
      </tr>
      <tr>
        <td>Outubro 2023</td>
        <?php
            $invoice_link = add_query_arg(['pedido'=> '564S81B7C6'], $invoice_page);
        ?>
        <td class="id__pedido"><a href="<?= $invoice_link ?>">564S81B7C6</a></td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pago"><span>Pago</span></td>
      </tr>
      <tr>
        <td>Setembro 2023</td>
        <?php
            $invoice_link = add_query_arg(['pedido'=> '99F4653F21'], $invoice_page);
        ?>
        <td class="id__pedido"><a href="<?= $invoice_link ?>">99F4653F21</a></td>
        <td>Plano Vivência</td>
        <td>R$810,00</td>
        <td class="status status--pago"><span>Pago</span></td>
      </tr>
      <tr>
        <td>Agosto 2023</td>
        <?php
            $invoice_link = add_query_arg(['pedido'=> '2DFFBC4B8D'], $invoice_page);
        ?>
        <td class="id__pedido"><a href="<?= $invoice_link ?>">2DFFBC4B8D</a></td>
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
