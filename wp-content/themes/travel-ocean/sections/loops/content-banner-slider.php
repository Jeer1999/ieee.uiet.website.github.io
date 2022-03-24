<?php
/**
 * This is a file provides the loop contents for the banner slider section.
 *
 * @package travel-ocean
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_travel_metas = travel_ocean_get_itinerary_meta();
$placeholder     = ! empty( $wp_travel_metas['thumbnails']['placeholder_url'] ) ? $wp_travel_metas['thumbnails']['placeholder_url'] : '';
$thumbnail       = ! empty( $wp_travel_metas['thumbnails']['url'] ) ? $wp_travel_metas['thumbnails']['url'] : $placeholder;

?>

<div id="banner-slider-<?php the_ID(); ?>">
	<div class="slider-container">
		<div class="image-container">
			<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title_attribute(); ?>">
			<figcaption class="banner-overlay-content">
				<div class="container">
				<div class="content">
						<?php
						the_title(
							'<div class="brand-title"><h1 class="title"><a href="' . get_the_permalink() . '">',
							'</a></h1></div>'
						);
						the_excerpt();
						?>
						<div class="button-item">
							<a href="<?php the_permalink(); ?>#booking" class="button theme-button"><?php esc_html_e( 'Book Now', 'travel-ocean' ); ?></a>
						</div>
					</div>
				</div>
			</figcaption>
		</div>
	</div>
</div>

