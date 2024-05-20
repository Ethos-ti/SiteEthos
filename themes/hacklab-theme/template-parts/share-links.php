<div class="share-links">
    <span><?php _e( 'Share', 'hacklabr' ) ?></span>

    <div class="share-links__icons">
        <a href="https://twitter.com/intent/tweet?text=<?= urlencode(get_the_title()) ?>&url=<?= get_the_permalink() ?>" target="_blank">
            <iconify-icon icon="fa6-brands:x-twitter"></iconify-icon>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= get_the_permalink() ?>" target="_blank">
            <iconify-icon icon="fa6-brands:facebook-f"></iconify-icon>
        </a>
    </div>

    <a href="whatsapp://send?text=<?= (get_the_title().' - '.get_the_permalink()) ?>" target="_blank" class="hide-for-large">
        <iconify-icon icon="formkit:whatsapp"></iconify-icon>
    </a>
    <a href="https://api.whatsapp.com/send?text=<?= (get_the_title().' - '.get_the_permalink()) ?>" class="show-for-large" target="_blank">
        <iconify-icon icon="formkit:whatsapp"></iconify-icon>
    </a>
    <a href="https://telegram.me/share/url?url=<?= get_the_title().' - '.get_the_permalink() ?>" target="_blank">
        <iconify-icon icon="file-icons:telegram"></iconify-icon>
    </a>
</div>
