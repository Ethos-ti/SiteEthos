<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
	<meta charset="<?php bloginfo('charset');?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1.0">
	<?php wp_head()?>
	<title><?= is_front_page() ? get_bloginfo('name') : wp_title()?></title>
	<link rel="icon" href="<?= get_site_icon_url() ?>" />
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="main-header main-header-lateral" x-data="{ menuOpen: false, searchOpen: false }">
        <div class="container container--wide">
			<div class="main-header-lateral__content">
                <button class="main-header__toggle-menu main-header-lateral__toggle-menu" aria-label="<?= __('Toggle menu visibility', 'hacklabr') ?>" @click="menuOpen = !menuOpen">
                    <svg class="hamburger" :class="{ 'hamburger--open': menuOpen }" role="image" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <title>Exibir menu</title>
                        <rect width="16" height="2" x="0" y="2"/>
                        <rect width="16" height="2" x="0" y="7"/>
                        <rect width="16" height="2" x="0" y="12"/>
                    </svg>
                </button>

				<div class="main-header-lateral__logo">
                    <?php if ( has_custom_logo() ): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <a href="<?= home_url() ?>">
                            <img src="<?= get_template_directory_uri() ?>/assets/images/logo.png" width="200" alt="<?= get_bloginfo( 'name' ) ?>">
                        </a>
                    <?php endif; ?>
				</div>

                <div class="main-header-lateral__desktop-content">
                    <?= wp_nav_menu(['theme_location' => 'main-menu', 'container' => 'nav', 'menu_class' => 'menu', 'container_class' => 'main-header-lateral__menu-desktop']) ?>
                </div>

                <div class="search-component">
                    <?php get_search_form(); ?>
                </div>

                <?php do_action( 'hacklabr/header/menus-end' ); ?>
				</div>
			</div>
        </div>

        <div class="main-header-lateral__mobile-content">
            <?= wp_nav_menu(['theme_location' => 'main-menu', 'container' => 'nav', 'menu_class' => 'menu', 'container_class' => 'main-header-lateral__menu-mobile']) ?>
        </div>
	</header>

	<div id="app">
