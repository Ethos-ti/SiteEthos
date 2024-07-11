<?php

namespace hacklabr;

function get_subscription_data ($attributes): array {
    return [];
}

function render_subscription_callback ($attributes) {
    $query = get_posts_grid_data($attributes);

    ob_start();
    ?>

    <table class="hacklabr-subscription-block">
      <thead>
        <tr>
            <th>Data</th>
            <th>Título</th>
            <th>Tipo de inscrição</th>
            <th>Status</th>
        </tr>
      </thead>

      <tbody>
      <tr>
        <td>Janeiro 2024</td>
        <td><a href="https://abrir.link/sHNBW">Valor Estratégico/ODS e Agenda 2030</a></td>
        <td>Curso</td>
        <td class="status status--pendente"><span>Pendente</span></td>
      </tr>
      <tr>
        <td>Dezembro 2023</td>
        <td><a href="#">Título da palestra lorem ipsum</a></td>
        <td>Palestra</td>
        <td class="status status--pendente"><span>Pendente</span></td>
      </tr>
      <tr>
        <td>Novembro 2023</td>
        <td><a href="#">Título da palestra lorem ipsum</a></td>
        <td>Curso</td>
        <td class="status status--inscrito"><span>Inscrito</span></td>
      </tr>
      <tr>
        <td>Outubro 2023</td>
        <td><a href="#">Título da palestra lorem ipsum</a></td>
        <td>Palestra</td>
        <td class="status status--inscrito"><span>Inscrito</span></td>
      </tr>
      <tr>
        <td>Setembro 2023</td>
        <td><a href="#">Título da palestra lorem ipsum</a></td>
        <td>Curso</td>
        <td class="status status--inscrito"><span>Inscrito</span></td>
      </tr>
      <tr>
        <td>Agosto 2023</td>
        <td><a href="#">Título da palestra lorem ipsum</a></td>
        <td>Palestra</td>
        <td class="status status--inscrito" ><span>Inscrito</span></td>
      </tr>
      </tbody>
    </table>

    <?php
    $output = ob_get_clean();

    return $output;
}
