<?php
/**
 * View: Default Template for Events
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/default-template.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 */

use Tribe\Events\Views\V2\Template_Bootstrap;

get_header();

?>

<?php

if(is_tax('tribe_events_cat', 'cursos' )) :
    echo hacklabr\get_layout_header( 'cursos' );
elseif(is_tax('tribe_events_cat', 'grupos-de-trabalhos' )) :
    echo hacklabr\get_layout_header( 'grupos-de-trabalho' );
else :
    echo hacklabr\get_layout_header( 'agenda' );
endif;
?>


<div class="ethos-events">

    <?php echo tribe( Template_Bootstrap::class )->get_view_html();?>
</div>

<?php

get_footer();
