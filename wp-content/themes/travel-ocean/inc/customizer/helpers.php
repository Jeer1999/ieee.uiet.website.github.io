<?php
/**
 * This file has the functions to help customizer work flow.
 *
 * @package travel-ocean
 * @subpackage inc/customizer
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Function to register control and setting.
 */
function travel_ocean_register_option( $wp_customize, $option ) {

	// Initialize Setting.
	$wp_customize->add_setting(
		$option['name'],
		array(
			'sanitize_callback' => $option['sanitize_callback'],
			'default'           => isset( $option['default'] ) ? $option['default'] : '',
			'transport'         => isset( $option['transport'] ) ? $option['transport'] : 'refresh',
			'theme_supports'    => isset( $option['theme_supports'] ) ? $option['theme_supports'] : '',
		)
	);

	$control = array(
		'label'    => $option['label'],
		'section'  => $option['section'],
		'settings' => $option['name'],
	);

	if ( isset( $option['active_callback'] ) ) {
		$control['active_callback'] = $option['active_callback'];
	}

	if ( isset( $option['priority'] ) ) {
		$control['priority'] = $option['priority'];
	}

	if ( isset( $option['choices'] ) ) {
		$control['choices'] = $option['choices'];
	}

	if ( isset( $option['type'] ) ) {
		$control['type'] = $option['type'];
	}

	if ( isset( $option['input_attrs'] ) ) {
		$control['input_attrs'] = $option['input_attrs'];
	}

	if ( isset( $option['description'] ) ) {
		$control['description'] = $option['description'];
	}

	if ( isset( $option['mime_type'] ) ) {
		$control['mime_type'] = $option['mime_type'];
	}

	if ( ! empty( $option['custom_control'] ) ) {
		$wp_customize->add_control( new $option['custom_control']( $wp_customize, $option['name'], $control ) );
	} else {
		$wp_customize->add_control( $option['name'], $control );
	}
}


if ( ! function_exists( 'travel_ocean_get_customizer_defaults' ) ) {

	/**
	 * Provides the customizer defaults.
	 *
	 * @param string $panel_id Customizer panel ID.
	 * @param string $section_id Customizer section ID.
	 * @param string $control Control key for the section ID..
	 */
	function travel_ocean_get_customizer_defaults( $panel_id, $section_id, $control ) {

		$defaults = array(
			'travel_ocean_settings' => array(
				'travel_ocean_customizer_settings_banner_slider' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Banner Slider', 'travel-ocean' ),
					'tax_dropdown'   => 'none',
				),
				'travel_ocean_customizer_settings_trip_filter' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Trip Filter', 'travel-ocean' ),
				),
				'travel_ocean_customizer_settings_trip_destinations' => array(
					'enable_section'  => false,
					'title'           => esc_html__( 'Post Categories', 'travel-ocean' ),
					'tax_dropdown'    => 'travel_locations',
					'number_of_items' => 3,
				),
				'travel_ocean_customizer_settings_featured_trips' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Featured Trips', 'travel-ocean' ),
				),
				'travel_ocean_customizer_settings_trip_activities' => array(
					'enable_section'  => false,
					'title'           => esc_html__( 'Category Listings', 'travel-ocean' ),
					'tax_dropdown'    => 'activity',
					'number_of_items' => 3,
				),
				'travel_ocean_customizer_settings_customer_reviews' => array(
					'enable_section' => false,
					'title'          => esc_html__( 'Customer Reviews', 'travel-ocean' ),
					'review_type'    => '4_and_above',
				),
			),
		);

		return isset( $defaults[ $panel_id ][ $section_id ][ $control ] ) ? $defaults[ $panel_id ][ $section_id ][ $control ] : '';
	}
}


if ( ! function_exists( 'travel_ocean_customizer_get_name' ) ) {

	/**
	 * Generates the formated string for the control name attr.
	 */
	function travel_ocean_customizer_get_name( $panel, $section, $control ) {
		$mod_prefix = 'travel_ocean_theme_options';
		return "{$mod_prefix}[{$panel}][{$section}][{$control}]";
	}
}


if ( ! function_exists( 'travel_ocean_get_theme_option' ) ) {

	/**
	 * Provides the customizer theme options.
	 * Returns default options if nothing is set by the user.
	 *
	 * @param string $panel_id Customizer panel ID.
	 * @param string $section_id Customizer section ID.
	 * @param string $control Control key for the section ID..
	 */
	function travel_ocean_get_theme_option( $panel_id, $section_id, $control ) {
		if ( ! $panel_id || ! $section_id || ! $control ) {
			return;
		}

		$default = travel_ocean_get_customizer_defaults( $panel_id, $section_id, $control );
		$options = get_theme_mod( 'travel_ocean_theme_options' );
		return isset( $options[ $panel_id ][ $section_id ][ $control ] ) ? $options[ $panel_id ][ $section_id ][ $control ] : $default;
	}
}

if ( ! function_exists( 'travel_ocean_get_wp_travel_taxonomies' ) ) {

	/**
	 * Provides the formatted array for taxonomy listing.
	 */
	function travel_ocean_get_wp_travel_taxonomies() {

		$taxonomies = array(
			'none'     => esc_html__( 'Select Taxonomy', 'travel-ocean' ),
			'category' => esc_html__( 'Category', 'travel-ocean' ),
		);

		$wpt_tax = array(
			'travel_locations' => esc_html__( 'Trip Locations', 'travel-ocean' ),
			'itinerary_types'  => esc_html__( 'Trip Types', 'travel-ocean' ),
			'activity'         => esc_html__( 'Trip Activities', 'travel-ocean' ),
		);

		if ( function_exists( 'WP_Travel' ) ) {
			$taxonomies = array_merge( $taxonomies, $wpt_tax );
		}

		// Build the array.
		foreach ( $taxonomies as $tax_slug => $tax_label ) {
			$items[ $tax_slug ] = $tax_label;
		}

		return $items;
	}
}

if ( ! function_exists( 'travel_ocean_get_pages_and_posts' ) ) {

	/**
	 * Returns the formatted array of pages and posts for customizer option.
	 */
	function travel_ocean_get_pages_and_posts() {

		$items = array();

		$items['none'] = esc_html__( 'Select a post or page...', 'travel-ocean' );

		$the_query = new WP_Query(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			)
		);
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$items[ get_the_ID() ] = get_the_title();
			}
		}
		wp_reset_postdata();

		$the_query = new WP_Query(
			array(
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
			)
		);
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$items[ get_the_ID() ] = get_the_title();
			}
		}
		wp_reset_postdata();

		return $items;

	}
	travel_ocean_get_pages_and_posts();
}

if ( ! function_exists( 'travel_ocean_get_wp_travel_terms' ) ) {

	/**
	 * Provides the customizer formated terms.
	 */
	function travel_ocean_get_wp_travel_terms( $taxonomy ) {

		$term_array = array();
		$terms      = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => true,
			)
		);

		if ( is_array( $terms ) && count( $terms ) > 0 ) {
			$term_array['none'] = esc_html__( 'Select a category...', 'travel-ocean' );
			foreach ( $terms as $itinerary_term ) {
				$slug  = ! empty( $itinerary_term->slug ) ? $itinerary_term->slug : '';
				$label = ! empty( $itinerary_term->name ) ? $itinerary_term->name : '';

				$term_array[ $slug ] = $label;
			}
		}

		return $term_array;
	}
}
