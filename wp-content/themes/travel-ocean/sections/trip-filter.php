<?php
/**
 * This is a file provides the trip filter search box.
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

$panel_id       = 'travel_ocean_settings';
$section_id     = 'travel_ocean_customizer_settings_trip_filter';
$enable_section = travel_ocean_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

?>

<div id="itinerary-trip-search-filter" >
	<div class="trip-search">
		<form class="form-wrapper" action="">
			<div class="item item-1">
				<i class="fas fa-map-marker-alt"></i>
				<?php
					$taxonomy_name = 'travel_locations';
					$args          = array(
						'show_option_all'   => __( 'All Location', 'travel-ocean' ),
						'option_none_value' => __( 'All Location', 'travel-ocean' ),
						'hide_empty'        => 0,
						'selected'          => 1,
						'hierarchical'      => 1,
						'name'              => $taxonomy_name,
						'class'             => 'wp-travel-taxonomy',
						'taxonomy'          => $taxonomy_name,
						'value_field'       => 'slug',
					);
					wp_dropdown_categories( $args, $taxonomy_name );
					?>
			</div>
			<div class="item item-2">
				<?php
					$taxonomy_name = 'itinerary_types';
					$args          = array(
						'show_option_all'   => __( 'Trip Types', 'travel-ocean' ),
						'option_none_value' => __( 'Trip Types', 'travel-ocean' ),
						'hide_empty'        => 1,
						'selected'          => 1,
						'hierarchical'      => 1,
						'name'              => $taxonomy_name,
						'class'             => 'wp-travel-taxonomy select-2',
						'taxonomy'          => $taxonomy_name,
						'value_field'       => 'slug',
					);
					wp_dropdown_categories( $args, $taxonomy_name );
					?>
			</div>
			<div class="item item-3">
				<input type="text" name="s" placeholder="<?php esc_attr_e( 'Keyword', 'travel-ocean' ); ?>" id="search">
			</div>
			<div class="item item-4">
				<button type="submit" class="primary-button theme-button"><?php esc_html_e( 'Search', 'travel-ocean' ); ?></button>
			</div>
		</form>
	</div>

</div>
