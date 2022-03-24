<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * For inner loops: @see loops/content-banner-slider.php
 *
 * @package travel-ocean
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$panel_id       = 'travel_ocean_settings';
$section_id     = 'travel_ocean_customizer_settings_banner_slider';
$enable_section = travel_ocean_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$taxonomy_name = travel_ocean_get_theme_option( $panel_id, $section_id, 'tax_dropdown' );


$posttype = 'category' === $taxonomy_name ? 'post' : 'itineraries';

if ( 'none' === $taxonomy_name ) {
	$posttype = array( 'post', 'itineraries' );
}

$args = array(
	'post_type'      => $posttype,
	'post_status'    => 'publish',
	'posts_per_page' => 5,
);

if ( 'none' !== $taxonomy_name ) {

	$itinerary_term[] = travel_ocean_get_theme_option( $panel_id, $section_id, "{$taxonomy_name}_term" );

	$args['tax_query'] = array( // phpcs:ignore
		array(
			'taxonomy' => $taxonomy_name,
			'terms'    => $itinerary_term,
			'field'    => 'slug',
		),
	);
} else {
	$args['orderby'] = 'rand';
}

$the_query = new WP_Query( $args );

?>

<div id="itinerary-banner-slider" >
	<div class="banner-container">
		<div class="wrapper">
			<div class="slider banner-slider ">
			<?php
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					get_template_part( 'sections/loops/content', 'banner-slider' );
				}
			}
			?>
			</div>
		</div>
	</div>
</div>

<?php
wp_reset_postdata();
