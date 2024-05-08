<?php

function header_custom_options($wp_customize) {
    $prefix = 'header';
    $section = 'header_area';

    $wp_customize->add_section(
		$section,
		array(
			'title' => esc_html__( 'Header', 'base-textdomain' ),
			'section' => $section,
		)
	);

    // header background color
	$wp_customize->add_setting(
		$prefix . '_background_color',
		array(
			'default' => '#FFFFFF',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . '_background_color',
			array(
				'label' => 'Header background',
				'section' => $section,
				'settings' => $prefix . '_background_color'
    		)
		)
	);

	// header text color
	$wp_customize->add_setting(
		$prefix . '_text_color',
		array(
			'default' => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . '_text_color',
			array(
				'label' => 'Header text color',
				'section' => $section,
				'settings' => $prefix . '_text_color'
    		)
		)
	);

}

add_action('customize_register', 'header_custom_options', 99);


// Aplica as cores selecionadas

function header_colors(){
    $header_bgcolor = get_theme_mod( 'header_background_color', 'var(--wp--preset--color--high-pure)' );
	$header_txtcolor = get_theme_mod( 'header_text_color', 'var(--wp--preset--color--low-pure)' );

	$header_vars = ":root {
		--hl--color--header-background: $header_bgcolor;
		--hl--color--header-text: $header_txtcolor;
	}";

	wp_add_inline_style( 'wp-block-library', $header_vars );
}

add_action( 'wp_enqueue_scripts', 'header_colors' );
