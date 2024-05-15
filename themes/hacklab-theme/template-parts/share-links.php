<div class="share-links">
    <span><?php _e( 'Share', 'hacklabr' ) ?></span>
    <a href="https://twitter.com/intent/tweet?text=<?= urlencode(get_the_title()) ?>&url=<?= get_the_permalink() ?>" target="_blank">
        <iconify-icon icon="tabler:brand-x"></iconify-icon>
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= get_the_permalink() ?>" target="_blank">
        <iconify-icon icon="fa6-brands:facebook-f"></iconify-icon>
    </a>

    <a href="whatsapp://send?text=<?= (get_the_title().' - '.get_the_permalink()) ?>" target="_blank" class="hide-for-large"><i class="fab fa-whatsapp"></i></a>
    <a href="https://api.whatsapp.com/send?text=<?= (get_the_title().' - '.get_the_permalink()) ?>" class="show-for-large" target="_blank"><i class="fab fa-whatsapp"></i></a>
    <a href="https://telegram.me/share/url?url=<?= get_the_title().' - '.get_the_permalink() ?>" target="_blank"><i class="fab fa-telegram"></i></a>
</div>
