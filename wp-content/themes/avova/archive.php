<?php

get_header();

global $post, $avova_fn_option;

$currentAuthor = get_userdata(get_query_var('author'));
$avova_fn_pagestyle 		= 'ws';
if(!avova_fn_if_has_sidebar()){
	$avova_fn_pagestyle	= 'full';
}

$seo_page_title 			= 'h3';
if(isset($avova_fn_option['seo_page_title'])){
	$seo_page_title 		= $avova_fn_option['seo_page_title'];
}
$seo_page_title__start 		= sprintf( '<%1$s class="fn__title">', $seo_page_title );
$seo_page_title__end 		= sprintf( '</%1$s>', $seo_page_title );


?>
        
    
        <div class="avova-fn-content_archive">
			<div class="avova_fn_pagetitle">
				<div class="fn-container">
					<div class="title_holder">
						<?php echo wp_kses($seo_page_title__start,'post'); ?>
							<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
							<?php /* If this is a category archive */ if (is_category()) { ?>
								<?php printf(esc_html__('All posts in %s', 'avova'), single_cat_title('',false)); ?>
							<?php /* If this is a tag archive */ } elseif( is_tax() ) { $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );?>
								<?php printf(esc_html__('All posts in %s', 'avova'), $term->name ); ?>
							<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
								<?php printf(esc_html__('All posts tagged in %s', 'avova'), single_tag_title('',false)); ?>
							<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
								<?php esc_html_e('Archive for', 'avova') ?> <?php the_time(get_option('date_format')); ?>
							 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
								<?php esc_html_e('Archive for', 'avova') ?> <?php the_time('F, Y'); ?>
							<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
								<?php esc_html_e('Archive for', 'avova') ?> <?php the_time('Y'); ?>
							<?php /* If this is an author archive */ } elseif (is_author()) { ?>
								<?php esc_html_e('All posts by', 'avova') ?> <?php echo esc_html($currentAuthor->display_name); ?>
							<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
								<?php esc_html_e('Blog Archives', 'avova') ?>
							<?php }else if($post->post_type == 'avova-project'){
								if(isset($avova_fn_option['portfolio_archive_title'])){
									echo esc_html($avova_fn_option['portfolio_archive_title']);
								}else{
									esc_html_e('All Works', 'avova');
								}
							} ?>
						<?php echo wp_kses($seo_page_title__end,'post'); ?>
						<?php avova_fn_breadcrumbs();?>
					</div>
				</div>
				<div class="fn_corner">
					<span class="fn_corner_a"></span>
					<span class="fn_corner_b"></span>
				</div>
			</div>
			
			<div class="fn-container">
				<ul class="avova_fn_postlist">
					<?php get_template_part( 'inc/templates/template-posts' );?>
				</ul>
			</div>
			<?php avova_fn_pagination(); ?>
        </div>
		<!-- /MAIN CONTENT -->
        
<?php get_footer(); ?>   