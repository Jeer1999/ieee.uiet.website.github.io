<?php 
global $post,$avova_fn_option;
$key = 0;
$postType	= 'post';
$list 		= '';
if(is_front_page()) {
	$avova_fn_paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
	$avova_fn_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}
if(!is_search() && !is_archive() && !is_home()){
	query_posts('posts_per_page=&paged='.esc_html($avova_fn_paged));
}


$from_page			= 'blog';
if (isset($args['from_page'])) {
	$from_page 		= $args['from_page'];
}
$call_back_thumb	= avova_fn_callback_thumbs(650,422);
if (have_posts()) : while (have_posts()) : the_post();
	$key++;
	$postID 		= get_the_id();
	$permalink 		= get_the_permalink();
	$postClasses  	= 'class="'.implode(' ', get_post_class()).' item"';

	

	$authorMeta 	= avova_fn_get_author_meta($postID);
	$authorMeta		= '';
	if($from_page == 'search'){
		$extraMeta 	= '';
	}else{
		$extraMeta	= avova_fn_get_category_info($postID,$postType);
	}

	$thumbName 		= 'full';
		

	$post_image 	= '<div class="abs_img" data-fn-bg-img="'.get_the_post_thumbnail_url($postID,$thumbName).'"></div>';

	$post_title		= '';
	if(get_the_title() !== ''){
		$post_title = '<div class="post_title"><h3><a href="'.$permalink.'">'.get_the_title().'</a></h3></div>';
	}

	$icon			= avova_fn_getSVG_theme('upload');
	
	$post_desc 		= '<div class="excerpt_holder"><p>'.avova_fn_excerpt(22,$postID).'</p></div>';
	$post_read 		= '<div class="avova_fn_read"><a class="read_more" href="'.$permalink.'">'.esc_html__('Read More', 'avova').'<span class="arrow">'.$icon.$icon.'</span></a></div>';

	$post_header 	= '<li class="fn_post_item_'.$key.'" id="post-'.$postID.'"><div '.$postClasses.'>';
	$post_footer 	= '</div></li>';

	
	$left_part		= '<div class="post_left"><a href="'.$permalink.'"></a><div class="img_wrap">'.$call_back_thumb.$post_image.'</div></div>';

	$right_part		= '<div class="post_right">'.$extraMeta.$post_title.$post_desc.$authorMeta.$post_read.'</div>';

	// echo
	$list .= $post_header;
		$list .= $left_part;
		$list .= $right_part;
	$list .= $post_footer;

endwhile; endif; wp_reset_postdata();
echo wp_kses($list, 'post');
?>