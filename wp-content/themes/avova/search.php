<?php

get_header();

global $post, $avova_fn_option;


$layout 			= 'boxed';
if(isset($avova_fn_option['search_layout'])){
	$layout			= $avova_fn_option['search_layout'];
}

$seo_page_title 			= 'h3';
if(isset($avova_fn_option['seo_page_title'])){
	$seo_page_title 		= $avova_fn_option['seo_page_title'];
}
$seo_page_title__start 		= sprintf( '<%1$s class="fn__title">', $seo_page_title );
$seo_page_title__end 		= sprintf( '</%1$s>', $seo_page_title );


// SEO
$seo_404_number 			= 'h2';
if(isset($avova_fn_option['seo_404_number'])){
	$seo_404_number 		= $avova_fn_option['seo_404_number'];
}
$seo_404_number__start 		= sprintf( '<%1$s class="fn__title">', $seo_404_number );
$seo_404_number__end 		= sprintf( '</%1$s>', $seo_404_number );

$seo_404_not_found 			= 'h3';
if(isset($avova_fn_option['seo_404_not_found'])){
	$seo_404_not_found 		= $avova_fn_option['seo_404_not_found'];
}
$seo_404_not_found__start 	= sprintf( '<%1$s class="fn__heading">', $seo_404_not_found );
$seo_404_not_found__end 	= sprintf( '</%1$s>', $seo_404_not_found );

$seo_404_desc 				= 'p';
if(isset($avova_fn_option['seo_404_desc'])){
	$seo_404_desc 			= $avova_fn_option['seo_404_desc'];
}
$seo_404_desc__start 		= sprintf( '<%1$s class="fn__desc">', $seo_404_desc );
$seo_404_desc__end 			= sprintf( '</%1$s>', $seo_404_desc );

?>
        
        
        
<!-- MAIN CONTENT -->
<section class="avova_fn_content">
		
	<div class="avova_fn_searchlist avova_fn_search_boxed">

		<?php if(have_posts()){ ?>
		<div class="avova_fn_pagetitle">
			<div class="fn-container">
				<div class="title_holder">
					<?php echo wp_kses($seo_page_title__start,'post'); ?>
					<?php printf( esc_html__('Search results for "%s"', 'avova'), get_search_query() ); ?>
					<?php echo wp_kses($seo_page_title__end,'post'); ?>
				</div>
			</div>
			<div class="fn_corner">
				<span class="fn_corner_a"></span>
				<span class="fn_corner_b"></span>
			</div>
		</div>
		<?php } ?>

		<div class="avova_fn_searchpagelist">
			<?php if(have_posts()){ ?>
			<div class="fn-container">
			<?php } ?>
			<?php if(have_posts()){ ?>
				<ul class="avova_fn_postlist">
					<?php get_template_part( 'inc/templates/template-posts', '', array('from_page' => 'search')  );?>
				</ul>
				<div class="clearfix"></div>
				<?php }else{ ?>
				<div class="avova_fn_404">
					<div class="fn-container">
						<div class="error_wrap">
							<div class="error_box">
								<div class="title_holder">
									<?php 
										echo wp_kses($seo_404_not_found__start,'post');
										printf( esc_html__('Nothing found for "%s"', 'avova'), get_search_query() );
										echo wp_kses($seo_404_not_found__end,'post');
									?>
									<?php 
										echo wp_kses($seo_404_desc__start,'post');
										esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'avova');
										echo wp_kses($seo_404_desc__end,'post');
									?>
								</div>
								<div class="search_holder">
									<form action="<?php echo esc_url(home_url('/')); ?>" method="get" >
										<div>
											<input type="text" placeholder="<?php esc_attr_e('Search','avova');?>" name="s" autocomplete="off" />
											<input type="submit" class="pe-7s-search" value="" />
											<span><?php echo wp_kses(avova_fn_getSVG_theme('search'), 'post');?></span>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="fn_corner">
						<span class="fn_corner_a"></span>
						<span class="fn_corner_b"></span>
					</div>
				</div>
				<?php } ?>
			<?php if(have_posts()){ ?>
			</div>
			<?php } ?>
		</div>

		<?php avova_fn_pagination(); wp_reset_postdata(); ?>
	</div>
	<!-- /SEARCH --> 
</section>
<!-- /MAIN CONTENT -->
        
<?php get_footer('null'); ?>   