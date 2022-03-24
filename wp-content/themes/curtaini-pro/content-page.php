<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Curtaini Pro
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="UnicarePageStyle">
    <header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'curtaini-pro' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'curtaini-pro' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
  </div>
</article><!-- #post-## -->
