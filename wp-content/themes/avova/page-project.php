<?php
/*
	Template Name: Portfolio Page
*/
get_header();

global $post, $avova_fn_option;
$avova_fn_pagetitle 		= '';


if(function_exists('rwmb_meta')){
	$avova_fn_pagetitle 	= get_post_meta(get_the_ID(),'avova_fn_page_title', true);
}

// QUERY ARGUMENTS
if(isset($avova_fn_option['portfolio_perpage'])){
	$portfolio_perpage		= $avova_fn_option['portfolio_perpage'];
}else{
	$portfolio_perpage 		= 9;
}

if(is_front_page()) { $paged = (get_query_var('page')) ? get_query_var('page') : 1;	} else { $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;}
$query_args = array(
	'post_type' 			=> 'avova-project', 
	'paged' 				=> $paged, 
	'posts_per_page' 		=> $portfolio_perpage,
	'post_status' 			=> 'publish',
);
// QUERY WITH ARGUMENTS
$avova_fn_loop 			= new WP_Query($query_args);
$specified_posts_count		= count($avova_fn_loop->posts);


$query_args2 = array(
	'post_type' 			=> 'avova-project', 
	'paged' 				=> $paged, 
	'posts_per_page' 		=> -1,
	'post_status' 			=> 'publish',
);
// QUERY WITH ARGUMENTS
$avova_fn_loop2 = new WP_Query($query_args2);

$all_posts_count = count($avova_fn_loop2->posts);


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
	
	<!-- ALL PAGES -->		
	<div class="avova_fn_full_page_in">
						
		<div class="avova_fn_portfolio_page">

			<!-- PORTFOLIO CONTENT -->
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="portfolio_content">
					<div class="fn-container">
						<?php the_content(); ?>
					</div>
				</div>
			<?php endwhile; endif;?>
			<!-- PORTFOLIO /CONTENT -->

			<!-- PORTFOLIO LIST -->
			<div class="portfolio_list">
				<div class="fn-container">
					<?php echo wp_kses(avova_fn_get_portfolio($avova_fn_loop,$avova_fn_loop2), 'post'); ?>
				</div>
			</div>
			<!-- /PORTFOLIO LIST -->
			<?php if($all_posts_count > $specified_posts_count){ ?>
				<div class="fn-container">
					<div class="fn_ajax_more">
					<input type="hidden" value="2" />
						<a href="#"><?php esc_html_e('Load More','avova');?></a>
					</div>
				</div>
			<?php }?>
		</div>
	</div>		
	<!-- /ALL PAGES -->
</div>
<?php } ?>

<?php get_footer(); ?>  