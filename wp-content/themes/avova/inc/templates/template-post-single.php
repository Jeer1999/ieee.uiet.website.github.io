<?php 

global $avova_fn_option;
$post_type				= 'post';
if (isset($args['post_type'])) {
	$post_type 			= $args['post_type'];
}
$has_sidebar			= 'full';
if (isset($args['has_sidebar'])) {
	$has_sidebar 		= $args['has_sidebar'];
}
if (have_posts()) : while (have_posts()) : the_post();
	$post_ID 			= get_the_id();
	$authorMeta 		= avova_fn_get_author_meta($post_ID);
	$post_title			= '';
	if(get_the_title() !== ''){
		$post_title 	= '<div class="post_title"><h3 class="fn__title">'.get_the_title().'</h3></div>';
	}
		

	$post_thumbnail_id 	= get_post_thumbnail_id( $post_ID );
	$src 				= wp_get_attachment_image_src( $post_thumbnail_id, 'full');
	$image_URL 			= '';
	$has_image			= 0;
	if(isset($src[0])){
		$image_URL 		= $src[0];
	}
	if($image_URL != ''){
		$has_image		= 1;
	}
	$callBack			= avova_fn_callback_thumbs(12,7);
	$category_box		= avova_fn_get_category_info($post_ID,$post_type, 999);

	$getInfoAboutAuthor = avova_get_author_info();

	$dateMeta			= '<span class="date_meta">'.get_the_time(get_option('date_format'), $post_ID).'</span>';
	$authorHolder		= '<span class="author_name"><a href="' .esc_url(get_author_posts_url(get_the_author_meta('ID'))). '">'. esc_html(get_the_author_meta('display_name')) .'</a></span>';
	
	
?>

<div class="avova_fn_post_header">
	<div class="fn_post_title">
		<div class="fn_narrow_container">
			<div class="author__meta">
				<?php echo wp_kses($authorHolder, 'post'); ?>
				<?php echo wp_kses($dateMeta, 'post'); ?>
			</div>
			<?php echo wp_kses($post_title, 'post');?>
			<?php echo wp_kses($category_box, 'post');?>
		</div>
		
		<div class="fn_corner">
			<span class="fn_corner_a"></span>
			<span class="fn_corner_b"></span>
		</div>
	</div>
	<div class="fn_post_image rel_image" data-image="<?php echo esc_attr($has_image);?>">
		<div class="fn-container">
			<div class="img_wrapper">
				<div class="img_in">
					<img src="<?php echo esc_url($image_URL);?>" alt="<?php echo esc_attr__('Post Image', 'avova');?>" />
				</div>
			</div>
		</div>
	</div>
</div>


<!-- POST CONTENT -->
<div class="avova_fn_post_content fn_<?php echo esc_attr($has_sidebar);?>">
	
	<!-- Content without title, image and comments -->
	<div class="fn_single_content">
		
	<?php if($has_sidebar != 'full'){ ?>
	<div class="fn-container fn_single_sidebar">
		<div class="avova_fn_hassidebar">
			<div class="avova_fn_leftsidebar">
	<?php } ?>
		
	
	<!-- Elementor and Classic Content -->
	<div class="blog_content">
		<?php if(!isset($avova_fn_option)){ ?>
		<div class="fn_narrow_container">
		<?php }else{ ?>
		<div class="fn-container">
		<?php } ?>
		<?php the_content(); ?>
		</div>
	</div>
	<!-- /Elementor and Classic Content -->

	
					
	<!-- Information -->
	<div class="blog_info">
		<div class="fn_narrow_container">
			<?php echo wp_kses($getInfoAboutAuthor, 'post');?>
			<?php if(has_tag()){?>
				<div class="avova_fn_tags">
					<label><?php echo wp_kses(avova_fn_getSVG_theme('tag'),'post'); the_tags(esc_html_e('Tags:', 'avova').'</label>', ', '); ?>
				</div>
			<?php } ?>
		</div>
		<?php wp_link_pages(
			array(
				'before'      => '<div class="fn_narrow_container"><div class="avova_fn_pagelinks"><span class="title">' . esc_html__( 'Pages:', 'avova' ). '</span>',
				'after'       => '</div></div>',
				'link_before' => '<span class="number">',
				'link_after'  => '</span>',
			)); 
		?>
	</div>
	<!-- /Information -->
		
	<?php if($has_sidebar != 'full'){?>
				</div>
			<div class="avova_fn_rightsidebar">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
	<?php } ?>

		<div class="fn_corner" data-pos="left">
			<span class="fn_corner_a"></span>
			<span class="fn_corner_b"></span>
		</div>
	</div>
	<!-- /Content without title, image and comments -->
	
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
	
	
</div>
<?php endwhile; endif;wp_reset_postdata();?>