<?php

namespace hacklabr;

function render_talk_request_callback ($attributes) {
    $start = strtotime('2021-01-01');
    $end = strtotime('+2 years');

    $days = ceil(($end - $start) / DAY_IN_SECONDS) + (2 * 365);

    ob_start();
?>
    <div class="hacklabr-talk-request-block">
        <?= do_shortcode('[ethosListaPalestras tp="16" sd="01/01/2021" days="' . $days . '"]') ?>
    </div>
<?php
    $output = ob_get_clean();

    return $output;
}
