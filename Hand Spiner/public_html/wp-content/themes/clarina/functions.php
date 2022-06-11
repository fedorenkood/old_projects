<?php

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 99 );
function child_enqueue_styles() {
	$parent_style = 'parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
	wp_enqueue_style( 'clarina-fonts', clarina_fonts_url(), array(), null );
	wp_enqueue_script( 'clarina-custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), '2.0.2', true );
}

if ( get_stylesheet() !== get_template() ) {
	add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
		update_option( 'theme_mods_' . get_template(), $value );
		return $old_value; // prevent update to child theme mods
	}, 10, 2 );
	add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
		return get_option( 'theme_mods_' . get_template(), $default );
	} );
}


function clarina_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Lora, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$titillium_web = _x( 'on', 'Titillium Web font: on or off', 'clarina' );

	/* Translators: If there are characters in your language that are not
	* supported by Open Sans, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$assistant = _x( 'on', 'Assistant font: on or off', 'clarina' );

	if ( 'off' !== $titillium_web || 'off' !== $assistant ) {
		$font_families = array();

		if ( 'off' !== $titillium_web ) {
			$font_families[] = 'Titillium Web:400,400i,600,700';
		}
		if ( 'off' !== $assistant ) {
			$font_families[] = 'Assistant:700,400,800';
		}
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	return esc_url_raw( $fonts_url );
}


add_action('customize_register','my_customize_register');
function my_customize_register( $wp_customize ) {


	/* Ribbon subtitle */
	$wp_customize->add_setting( 'clarina_ribbon_subtitle', array(
		'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','clarina'),
		'sanitize_callback' => 'clarina_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'clarina_ribbon_subtitle', array(
		'label'    => esc_html__( 'Main subtitle', 'clarina' ),
		'section'  => 'llorix_one_lite_ribbon_section',
		'priority'    => 25
	));

	/* Ribbon image */
	$wp_customize->add_setting( 'clarina_ribbon_image', array(
		'sanitize_callback' => 'esc_url',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'clarina_ribbon_image', array(
		'label'    => esc_html__( 'Image', 'clarina' ),
		'section'  => 'llorix_one_lite_ribbon_section',
		'priority'    => 50,
	)));

	/* latest posts submenu */
	$wp_customize->add_setting( 'clarina_news_subtitle', array(
		'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit','clarina'),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'clarina_news_subtitle', array(
		'label'    => esc_html__( 'Main subtitle', 'clarina' ),
		'section'  => 'llorix_one_lite_latest_news_section',
		'priority'    => 15
	));

	/* Featured ribbon Title */
	$wp_customize->add_setting( 'clarina_featured_ribbon_title', array(
		'default' => esc_html__('Lorem ipsum dolor','clarina'),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'clarina_featured_ribbon_title', array(
		'label'    => esc_html__( 'Main title', 'clarina' ),
		'section'  => 'llorix_one_lite_features_ribbon_section',
		'priority'    => 15
	));

}

/* Customizer js file */
function childtheme_customizer_live_preview() {
	wp_enqueue_script( 'clarina_customizer_script', llorix_one_lite_get_file('/js/clarina_customizer.js'), array( 'jquery','customize-preview' ), '1.0', true
	);
}
add_action( 'customize_preview_init', 'childtheme_customizer_live_preview' );

  add_filter( 'woocommerce_currencies', 'add_inr_currency' );
add_filter( 'woocommerce_currency_symbol', 'add_inr_currency_symbol' );



function add_inr_currency( $currencies ) {
   $currencies['UAH'] = __( 'Украинская гривна', 'themewoocommerce' );
		$currencies['RUR'] = __( 'Российский рубль', 'themewoocommerce' );
		$currencies['RUB'] = __( 'Российский рубль (P)', 'themewoocommerce' );
		$currencies['BYR'] = __( 'Belarusian ruble', 'themewoocommerce' );
		$currencies['AMD'] = __( 'Armenian dram  (Դրամ)', 'themewoocommerce' );
		$currencies['KGS'] = __( 'Киргизский сом', 'themewoocommerce' );
		$currencies['KZT'] = __( 'Казахстанский тенге ', 'themewoocommerce' );
		$currencies['UZS'] = __( 'Узбекский сум', 'themewoocommerce' );
		$currencies['LTL'] = __( 'Lithuanian Litas', 'themewoocommerce' );
    return $currencies;
}

function add_inr_currency_symbol( $symbol ) {
	$currency = get_option( 'woocommerce_currency' );
	switch( $currency ) {
						case 'UAH': $symbol = '<span class=rure >&#x433;&#x440;&#x43D;.</span>'; break;
				case 'RUB': $symbol = '<span class=rure >&#x440;<span>&#x443;&#x431;.</span></span>'; break;
				case 'RUR': $symbol = '<span class=rure >&#x440;&#x443;&#x431;.</span>'; break;
				case 'BYR': $symbol = '<span class=rure >&#x440;&#x443;&#x431;.</span>'; break;
				case 'AMD': $symbol = '<span class=rure >&#x534;</span>'; break;
				case 'KGS': $symbol = '<span class=rure >сом</span>'; break;
				case 'KZT': $symbol = '<span class=rure >&#x20B8;</span>'; break;
				case 'UZS': $symbol = '<span class=rure >&#x441;&#x45E;&#x43C;</span>'; break;
				case 'LTL': $symbol = '<span class=rure >lt.</span>'; break;

	}
	return $symbol;
}



