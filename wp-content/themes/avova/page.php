<?php 

get_header();

global $post, $avova_fn_option;
$avova_fn_pagetitle 	= '';
$avova_fn_pagestyle 	= '';

if(function_exists('rwmb_meta')){
	$avova_fn_pagetitle 	= get_post_meta(get_the_ID(),'avova_fn_page_title', true);
	$avova_fn_pagestyle 	= get_post_meta(get_the_ID(),'avova_fn_page_style', true);
}

if($avova_fn_pagestyle == 'ws' && !avova_fn_if_has_sidebar()){
	$avova_fn_pagestyle	= 'full';
}

// CHeck if page is password protected	
if(post_password_required($post)){
	$protected = avova_fn_protectedpage();
	echo wp_kses($protected, 'post');
}
else
{
 	$seo_page_title 			= 'h3';
	if(isset($avova_fn_option['seo_page_title'])){
		$seo_page_title 		= $avova_fn_option['seo_page_title'];
	}
	$seo_page_title__start 		= sprintf( '<%1$s class="fn__title">', $seo_page_title );
	$seo_page_title__end 		= sprintf( '</%1$s>', $seo_page_title );
?>




<div class="avova_fn_full_page_template">
	<?php if($avova_fn_pagetitle !== 'disable'){ ?>
		<!-- PAGE TITLE -->
		<div class="avova_fn_pagetitle">
			<div class="fn-container">
				<div class="title_holder">
					<?php echo wp_kses($seo_page_title__start,'post'); ?><?php the_title(); ?><?php echo wp_kses($seo_page_title__end,'post'); ?>
					<?php avova_fn_breadcrumbs();?>
				</div>
			</div>
			<div class="fn_corner">
				<span class="fn_corner_a"></span>
				<span class="fn_corner_b"></span>
			</div>
		</div>
		<!-- /PAGE TITLE -->
	<?php } ?>
		
	<?php if($avova_fn_pagestyle == 'ws'){ ?>
	
	<div class="avova_fn_hassidebar">
		<div class="avova_fn_leftsidebar">
	<?php } ?>
				
			<!-- ALL PAGES -->		
			<div class="avova_fn_full_page_in">
				
				<?php if(!isset($avova_fn_option) || ( class_exists('WooCommerce') && (is_shop() || is_product() || is_checkout() || is_woocommerce() || is_cart() ))){ ?>
				<div class="fn-container">
				<?php } ?>
				<!-- PAGE -->
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php the_content(); ?>

					<?php wp_link_pages(
						array(
							'before'      => '<div class="avova_fn_pagelinks"><span class="title">' . esc_html__( 'Pages:', 'avova' ). '</span>',
							'after'       => '</div>',
							'link_before' => '<span class="number">',
							'link_after'  => '</span>',
						)); 
					?>


				<!-- /PAGE -->
				
				
				<?php if(!isset($avova_fn_option)){ ?>	
				</div>
				<?php } ?>	
				
			</div>		
			<!-- /ALL PAGES -->
		<?php if($avova_fn_pagestyle == 'ws'){ ?>
		</div>
		<?php } ?>
		<?php if($avova_fn_pagestyle == 'ws'){?>
			<div class="avova_fn_rightsidebar">
				<?php get_sidebar(); ?>
			</div>
		</div>
		<?php } ?>
		
		<?php if ( comments_open() || get_comments_number()){?>
		<!-- POST COMMENT -->
		<div class="avova_fn_comment_wrapper">
			<div class="fn_narrow_container">
				<div class="avova_fn_comment" id="comments">
					<div class="comment_in">
						<?php comments_template(); ?>
					</div>
				</div>
			</div>
			<div class="fn_corner">
				<span class="fn_corner_a"></span>
				<span class="fn_corner_b"></span>
			</div>
		</div>
		<!-- /POST COMMENT -->
		<?php } ?>
		<?php endwhile; endif; ?>
</div>





<?php } ?>

<?php get_footer(); ?>  