<?php

namespace hacklabr;

function render_talk_request_callback ($attributes) {
    $start_date = date( 'd/m/Y', strtotime( '+30 days' ) );

    ob_start();
?>
    <div class="hacklabr-talk-request-block">
        <?= do_shortcode('[ethosListaPalestras tp="16" sd="' . $start_date .' " days="700"]') ?>
    </div>
<?php
    $output = ob_get_clean();

    return $output;
}
