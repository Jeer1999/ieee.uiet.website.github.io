<?php 

global $avova_fn_option;
use Frel\Frel_Helper;
$post_type				= 'avova-project';

$image_size 		= 'avova_fn_thumb-1200-9999';
if(isset($avova_fn_option['project_single_page_image_size'])){
	$image_size		= $avova_fn_option['project_single_page_image_size'];
}
if (have_posts()) : while (have_posts()) : the_post();
	$post_ID 			= get_the_id();
	$authorMeta 		= avova_fn_get_author_meta($post_ID);
	$post_title 		= '<div class="post_title"><h3 class="fn__title">'.get_the_title().'</h3></div>';

	$post_thumbnail_id 	= get_post_thumbnail_id( $post_ID );
	$src 				= wp_get_attachment_image_src( $post_thumbnail_id, $image_size);
	$image_URL 			= '';
	$has_image			= 0;
	if(isset($src[0])){
		$image_URL 		= $src[0];
	}
	if($image_URL != ''){
		$has_image		= 1;
	}
	$callBack			= avova_fn_callback_thumbs(12,7);
	$category_box		= avova_fn_get_categories($post_ID,$post_type);

	$getInfoAboutAuthor = avova_get_author_info();

	$dateMeta			= '<span class="date_meta">'.get_the_time(get_option('date_format'), $post_ID).'</span>';
	$authorHolder		= '<span class="author_name"><a href="' .esc_url(get_author_posts_url(get_the_author_meta('ID'))). '">'. esc_html(get_the_author_meta('display_name')) .'</a></span>';
	
	$likeshare			= '';
	if(isset($avova_fn_option)){
		$like 			= '<div class="like_btn">'.avova_fn_like($post_ID,'return').'</div>';
		$shareText		= esc_html__('Share', 'avova');
		$share			= Frel_Helper::share_post($post_ID,$shareText);
		$likeshare	 	= '<div class="avova_fn_like_share"><span class="share_lines"></span>'.$like.$share.'</div>';
	}
	
?>

<div class="avova_fn_post_header">
	<div class="fn_post_title">
		<div class="fn_narrow_container">
			<?php echo wp_kses($category_box, 'post');?>
			<?php echo wp_kses($post_title, 'post');?>
			<?php echo wp_kses($likeshare, 'post');?>
		</div>
		
		<div class="fn_corner">
			<span class="fn_corner_a"></span>
			<span class="fn_corner_b"></span>
		</div>
	</div>
	<div class="fn_post_image" data-image="<?php echo esc_attr($has_image);?>">
		<div class="fn-container">
			<div class="img_wrapper">
				<div class="img_in">
					<div class="post_header_bg" data-fn-bg-img="<?php echo esc_url($image_URL);?>"></div>
					<?php echo wp_kses($callBack, 'post'); ?>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- POST CONTENT -->
<div class="avova_fn_post_content">
	
	<!-- Content without title, image and comments -->
	<div class="fn_single_content">
	
		<!-- Elementor and Classic Content -->
		<?php the_content(); ?>
		<!-- /Elementor and Classic Content -->

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