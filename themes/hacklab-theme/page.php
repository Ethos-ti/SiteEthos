<?php
get_header();
?>
    <div class="container">
        <div class="post-header post-header__separator">
            <h1 class="post-header__title"><?php the_title() ?></h1>
            <div class="post-header__excerpt container--wide">
                <?php the_excerpt() ?>
            </div>
        </div>
        <div class="post-content content content--normal">
            <?php the_content() ?>
        </div>
    </div>
<?php get_footer();
