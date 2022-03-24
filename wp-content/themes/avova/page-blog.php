<?php
/*
	Template Name: Blog Page
*/
get_header();

global $post, $avova_fn_option;
$avova_fn_pagetitle 	= '';
$avova_fn_pagestyle 	= 'ws';

if(function_exists('rwmb_meta')){
	$avova_fn_pagetitle 		= get_post_meta(get_the_ID(), 'avova_fn_page_title', true);
	$avova_fn_pagestyle 		= get_post_meta(get_the_ID(),'avova_fn_page_style', true);
}

if(isset($_GET['blog_layout'])){$avova_fn_pagestyle = $_GET['blog_layout'];}

if($avova_fn_pagestyle == 'ws' && !avova_fn_if_has_sidebar()){
	$avova_fn_pagestyle		= 'full';
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
	
	$pageContent 				= get_the_content();
	if($avova_fn_pagetitle !== 'disable'){ ?>
	<!-- PAGE TITLE -->
	<div class="avova_fn_pagetitle">
		<div class="fn-container">
			<div class="title_holder">
				<?php 
					echo wp_kses($seo_page_title__start,'post');
					the_title();
					echo wp_kses($seo_page_title__end,'post');
					avova_fn_breadcrumbs();
				?>
			</div>
		</div>
		<div class="fn_corner">
			<span class="fn_corner_a"></span>
			<span class="fn_corner_b"></span>
		</div>
	</div>
	<!-- /PAGE TITLE -->
	<?php } ?>

	<div class="fn_page_blog">
		<div class="fn-container">

			<?php if($avova_fn_pagestyle == 'full'){ ?>

			<!-- WITHOUT SIDEBAR -->
			<div class="avova_fn_nosidebar">
				<ul class="avova_fn_postlist">
					<?php get_template_part( 'inc/templates/template-posts' );?>
				</ul>
			</div>
			<!-- /WITHOUT SIDEBAR -->

			<?php }else{ ?>

			<!-- WITH SIDEBAR -->
			<div class="avova_fn_hassidebar">
				<div class="avova_fn_leftsidebar">
					<div class="sidebar_in">
						<ul class="avova_fn_postlist">
							<?php get_template_part( 'inc/templates/template-posts' );?>
						</ul>
					</div>
				</div>

				<div class="avova_fn_rightsidebar">
					<div class="sidebar_in">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
			<!-- /WITH SIDEBAR -->

			<?php } ?>
		</div>
	</div>
	<?php avova_fn_pagination(); ?>



	<?php if($pageContent !== ''){ ?>
	<div class="avova_fn_blog_content">
		<div class="fn-container">
			<div class="blog_content">
				<?php echo wp_kses($pageContent, 'post'); ?>
			</div>
		</div>
	</div>	
	<?php } ?>


<?php } ?>

<?php get_footer(); ?>  