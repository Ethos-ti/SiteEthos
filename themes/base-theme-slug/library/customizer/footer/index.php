<?php

function footer_custom_options($wp_customize) {
    $prefix = 'footer';
    $section = 'footer_area';


	$wp_customize->add_section(
		$section,
		array(
			'title' => esc_html__( 'Footer', 'base-textdomain' ),
			'section' => $section,
		)
	);

	// Copyright
    $wp_customize->add_setting(
		$prefix . '_copyright_text',
		array(
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);

	$wp_customize->add_control(
		$prefix . '_copyright_text',
		array(
			'label'       => __( 'Footer copyright text', 'base-textdomain' ),
			'description' => __( 'Leave it empty to hide all copyright info.', 'base-textdomain' ),
			'section'     => $section,
			'default'     => '',
			'type'        => 'text',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	// Show year and name
    $wp_customize->add_setting(
		$prefix . '_show_year_and_name',
		array(
			'default'  => false,
			'sanitize_callback' => 'sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$prefix . '_show_year_and_name',
		array(
			'type' => 'checkbox',
			'section' => $section,
			'label' => __( 'Display year and site name aside copyright info?', 'base-textdomain' ),
		)
	);

	// footer background color
	$wp_customize->add_setting(
		$prefix . '_background_color',
		array(
			'default' => '#035299',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . '_background_color',
			array(
				'label' => __( 'Footer background', 'base-textdomain' ),
				'section' => $section,
				'settings' => $prefix . '_background_color'
    		)
		)
	);


	// footer text color
	$wp_customize->add_setting(
		$prefix . '_text_color',
		array(
			'default' => '#FFFFFF',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			$prefix . '_text_color',
			array(
				'label' => __( 'Footer text color', 'base-textdomain' ),
				'section' => $section,
				'settings' => $prefix . '_text_color'
    		)
		)
	);

}


add_action('customize_register', 'footer_custom_options', 99);


// Aplica as cores selecionadas

function footer_colors(){
    $footer_bgcolor = get_theme_mod( 'footer_background_color', 'var(--wp--preset--color--high-pure)' );
	$footer_txtcolor = get_theme_mod( 'footer_text_color', 'var(--wp--preset--color--low-pure)' );

	$footer_vars = ":root {
		--hl--color--footer-background: $footer_bgcolor;
		--hl--color--footer-text: $footer_txtcolor;
	}";

	wp_add_inline_style( 'wp-block-library', $footer_vars );
}

add_action( 'wp_enqueue_scripts', 'footer_colors' );
