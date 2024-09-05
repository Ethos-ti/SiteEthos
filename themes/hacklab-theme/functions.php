<?php

namespace hacklabr;

load_theme_textdomain('hacklabr');

require __DIR__ . '/library/ethos-associados-redirects.php';

require __DIR__ . '/library/layout-parts/layout-parts.php';
require __DIR__ . '/library/supports.php';
require __DIR__ . '/library/sidebars.php';
require __DIR__ . '/library/menus.php';
require __DIR__ . '/library/settings.php';
require __DIR__ . '/library/assets.php';
require __DIR__ . '/library/crm/index.php';
require __DIR__ . '/library/membership.php';
require __DIR__ . '/library/forms.php';
require __DIR__ . '/library/form-fields.php';
require __DIR__ . '/library/search.php';
require __DIR__ . '/library/cron.php';
require __DIR__ . '/library/api/index.php';
require __DIR__ . '/library/sanitizers/index.php';
require __DIR__ . '/library/template-tags/index.php';
require __DIR__ . '/library/utils.php';
require __DIR__ . '/library/the-events-calendar/index.php';
require __DIR__ . '/library/blocks/index.php';
require __DIR__ . '/library/associates-area.php';
require __DIR__ . '/library/remove-thumbnail-and-excerpt.php';
require __DIR__ . '/library/shortcodes/shortcodes.php';

require __DIR__ . '/library/forms/helpers.php';
require __DIR__ . '/library/forms/custom-fields.php';
require __DIR__ . '/library/forms/custom-forms.php';
require __DIR__ . '/library/forms/registration.php';
require __DIR__ . '/library/forms/edit-organization.php';
require __DIR__ . '/library/forms/my-data.php';
require __DIR__ . '/library/forms/requests.php';

add_action( 'init', function() {
    if(isset($_GET['crm_sync_events']) && current_user_can('manage_options')) {
        ini_set('max_execution_time', 0);
        echo "IMPORTANDO EVENTOS <pre>";
        $number = intval($_GET['crm_sync_events']) ?: 5;
        do_get_crm_events($number);
        die;
    }
}, 150 );
