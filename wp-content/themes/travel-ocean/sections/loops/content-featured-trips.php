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

// Prices and currency.
$currency_code = ! empty( $wp_travel_metas['prices']['currency_code'] ) ? $wp_travel_metas['prices']['currency_code'] : false;
$enable_sale   = ! empty( $wp_travel_metas['prices']['enable_sale'] ) ? $wp_travel_metas['prices']['enable_sale'] : false;
$regular_price = ! empty( $wp_travel_metas['prices']['regular_price'] ) ? $wp_travel_metas['prices']['regular_price'] : false;
$trip_price    = ! empty( $wp_travel_metas['prices']['trip_price'] ) ? $wp_travel_metas['prices']['trip_price'] : false; // This will give sales price if sale is enabled.

$ratings_html = ! empty( $wp_travel_metas['general']['ratings_html'] ) ? $wp_travel_metas['general']['ratings_html'] : '';
$placeholder  = ! empty( $wp_travel_metas['thumbnails']['placeholder_url'] ) ? $wp_travel_metas['thumbnails']['placeholder_url'] : '';
$thumbnail    = ! empty( $wp_travel_metas['thumbnails']['url'] ) ? $wp_travel_metas['thumbnails']['url'] : $placeholder;

$activities    = ! empty( $wp_travel_metas['trip_terms']['activity'] ) ? $wp_travel_metas['trip_terms']['activity'] : '';
$activity      = ! empty( $activities[0] ) ? $activities[0] : '';
$activity_id   = ! empty( $activity->term_id ) ? $activity->term_id : '';
$activity_name = ! empty( $activity->name ) ? $activity->name : '';
$activity_link = ! empty( $activity_id ) ? get_term_link( $activity_id ) : '';

?>

<div>
	<div class="slider-content">
		<div class="content">

			<div class="img-container">
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title_attribute(); ?>">
				</a>
			</div>

			<figcaption class="short-feature-detail">
				<?php
					the_title(
						'<h3 class="feature-title"><a href="' . get_the_permalink() . '">',
						'</a></h3>'
					);
					?>
				<div class="prices">

					<?php
					if ( ! empty( $trip_price ) && ! empty( $regular_price ) ) {
						?>
						<div>
							<?php
								esc_html_e( 'From', 'travel-ocean' );
								echo $enable_sale && $regular_price ? sprintf( '<del><span class="amount">%s%d</span></del>', esc_html( $currency_code ), esc_html( $regular_price ) ) : '';
								echo $trip_price ? sprintf( '<span class="amount">%s%d</span>', esc_html( $currency_code ), esc_html( $trip_price ) ) : '';
							?>
						</div>
						<?php
					} else {
						echo sprintf( '<span class="amount">%sN/A</span>', esc_html( $currency_code ) );
					}
					?>

					<a class="button theme-button" href="<?php the_permalink(); ?>#booking" class="btn btn-primary"> <?php esc_html_e( 'Book Now', 'travel-ocean' ); ?> </a>
				</div>

				<div class="trip-footer">

					<?php echo wp_kses_post( $ratings_html ); ?>

					<div class="meta-content">
						<ul class="list-inline">
							<?php if ( $activity_name ) { ?>
								<li class="list-inline-item">
									<i class="fas fa-tags"></i>
									<a href="<?php echo esc_url( $activity_link ); ?>" class="more-link"><?php echo esc_html( $activity_name ); ?></a>
								</li>
								<?php
							}
							the_date(
								'',
								'<li class="list-inline-item"><i class="fas fa-clock"></i> ',
								'</li>'
							);
							?>
						</ul>
					</div>
				</div>
			</figcaption>

		</div>

	</div><!-- .slider-content -->
</div>
