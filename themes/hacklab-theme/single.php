<?php
/**
 * The template for displaying all single posts
 */

get_header();
the_post();
$category = get_the_category();
$excerpt = !empty($post->post_excerpt) ? wp_kses_post($post->post_excerpt) : '';
?>

<header class="post-header container container--wide">
    <div class="post-header__featured-image">
        <?php
            $thumbnail_id = get_post_thumbnail_id(get_the_ID());
            echo get_the_post_thumbnail(null, 'post-thumbnail', ['class' => 'post-header__featured-image']);
            $thumbnail_caption = get_post($thumbnail_id)->post_excerpt;

            if ( !empty( $thumbnail_caption ) ) {
                echo '<div class="post-header__featured-image-caption">' . esc_html( $thumbnail_caption ) . '</div>';
            }
        ?>
    </div>

    <?php
    function should_exclude_related_posts_and_tag( $excluded_title ) {
        $current_post_title = trim( get_the_title() );
        $excluded_title = trim( $excluded_title );
        return $current_post_title === $excluded_title;
    }

    $excluded_post_title = 'Instituto Ethos celebra 25 anos em evento em São Paulo, com debate sobre as desigualdades'; // Substitua pelo título do post específico

    if ( $category && !should_exclude_related_posts_and_tag( $excluded_post_title ) ) : ?>
        <div class="post-header__tags">
            <a class="tag tag--solid tag--<?= $category[0]->slug ?>" href="<?= get_term_link( $category[0], 'category' ) ?>">
                <?= $category[0]->name ?>
            </a>
        </div>
    <?php endif; ?>

    <h1 class="post-header__title"> <?php the_title(); ?> </h1>

    <?php if ( $excerpt ) : ?>
        <p class="post-header__excerpt container--narrow"><?= get_the_excerpt() ?></p>
    <?php endif; ?>

    <div class="post-header__meta container">
        <p class="post-header__date"><?php _e('Published in ', 'hacklabr') ?><?= get_the_date() ?></p>
        <?php get_template_part('template-parts/share-links', null, ['link' => get_the_permalink()]) ?>
    </div>

    <div class="post-header__author container">
        <p class="post-header__author-name"><?php _e('Published by ', 'hacklabr') ?><?= get_the_author() ?></p>
    </div>
</header>

<main class="post-content stack container">
    <?php the_content() ?>
</main>

<?php
if ( !should_exclude_related_posts_and_tag( $excluded_post_title ) ) {
    get_template_part( 'template-parts/content/related-posts' );
}
?>

<?php get_footer(); ?>
