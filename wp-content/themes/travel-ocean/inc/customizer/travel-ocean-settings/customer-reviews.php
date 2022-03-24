<?php
/**
 * This file has the settings for the customer reviews options.
 *
 * @package travel-ocean
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'WP_Travel' ) ) {
	return;
}


if ( ! function_exists( 'travel_ocean_customizer_settings_customer_reviews' ) ) {

	/**
	 * Adds settings and options for the banner slider option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travel_ocean_customizer_settings_customer_reviews( $wp_customize ) {
		$panel_id   = 'travel_ocean_settings';
		$section_id = 'travel_ocean_customizer_settings_customer_reviews';

		// Add section.
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'title' ),
				'panel' => $panel_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'checkbox',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'enable_section' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'enable_section' ),
				'sanitize_callback' => 'travel_ocean_sanitize_checkbox',
				'label'             => esc_html__( 'Enable Section?', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'text',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'title' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'title' ),
				'sanitize_callback' => 'sanitize_text_field',
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_customer_reviews';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'label'             => esc_html__( 'Title', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'travel_ocean_slim_select',
				'custom_control'    => 'Travel_Ocean_Customizer_Slim_Select_Control',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'review_type' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'review_type' ),
				'sanitize_callback' => 'travel_ocean_sanitize_select',
				'description'       => esc_html__( 'Filter the reviews according to the trip average ratings.', 'travel-ocean' ),
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_customer_reviews';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'choices'           => array(
					'display_all'  => esc_html__( 'Display all reviews', 'travel-ocean' ),
					'3_and_above'  => esc_html__( 'From 3 stars and above', 'travel-ocean' ),
					'4_and_above'  => esc_html__( 'From 4 stars and above', 'travel-ocean' ),
					'5_stars_only' => esc_html__( '5 stars only', 'travel-ocean' ),
				),
				'label'             => esc_html__( 'Filter reviews', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);
	}
	add_action( 'customize_register', 'travel_ocean_customizer_settings_customer_reviews' );
}
