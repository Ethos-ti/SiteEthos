<?php
/**
 * Template Name: Page with anchors
 */
get_header(); ?>

<div class="index-wrapper page-with-title">
    <div class="container">
        <?php get_template_part( 'template-parts/title/default' ); ?>
        <div class="row">
            <div class=" sidebarpage">
                <p class="anchor-title"><?= __( 'Sections', 'hacklabr' ) ?></p>
                <ul id="anchors"></ul>
            </div>
            <div class="content">
                <?php the_content() ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer();
