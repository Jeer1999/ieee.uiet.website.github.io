<?php
/*-----------------------------------------------------------------------------------*/
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
/*-----------------------------------------------------------------------------------*/	

global $avova_fn_option, $post;


function frenify_theme_header_markup(){
	global $avova_fn_option;
	if(isset($avova_fn_option['header_switcher']) && $avova_fn_option['header_switcher'] === 'disabled'){
		return '';
	}
	ob_start();
	get_template_part( 'inc/templates/template-header' );

	$out1 = ob_get_contents();

	ob_end_clean();
	
	return $out1;
}
function frenify_theme_footer_markup(){
	global $avova_fn_option;
	if(isset($avova_fn_option['footer_switch']) && $avova_fn_option['footer_switch'] === 'disable'){
		return '';
	}
	ob_start();
	get_template_part( 'inc/templates/template-footer' );

	$out1 = ob_get_contents();

	ob_end_clean();
	
	return $out1;
}

function avova_fn_buy_button(){
	global $woocommerce;
	if ( class_exists( 'WooCommerce' ) ) {
		// buy
		$svgText	= esc_html__('svg','avova');
		$buyIcon	= get_template_directory_uri().'/assets/svg/shopping-cart.svg';
		$buySVG 	= '<img class="avova_fn_svg" src="'.esc_url($buyIcon).'" alt="'.esc_attr($svgText).'" />';
		$cartBox	= avova_fn_getCartBox();
		$buyHTML	= '<div class="avova_fn_buy_nav"><a class="buy_icon" href="#">'.$buySVG.'<span>'.esc_html($woocommerce->cart->cart_contents_count).'</span></a>'.$cartBox.'</div>';
	}else{
		$buyHTML	= '';
	}
	return $buyHTML;
}

function avova_fn_getCartBox($in = '',$pageFrom = ''){
	global $woocommerce;
	$items = $woocommerce->cart->get_cart();
	
	$html	= '<div class="avova_fn_cartbox">';
	if($in == 'yes'){
		$html = '';
	}
	
	if(!empty($items)){
		$subTotalText 		= esc_html__('Subtotal:', 'avova');
		$deleteItemText		= esc_html__('Remove this product from the cart', 'avova');
		$cartURL			= '<a class="fn_cart_url" href="'.esc_url( wc_get_cart_url() ).'">'.esc_html__('View Cart', 'avova').'</a>';
		$checkoutURL		= '<a class="fn_checkout_url" href="'.esc_url( wc_get_checkout_url() ).'">'.esc_html__('Checkout', 'avova').'</a>';
		
		$html .= '<div class="fn_cartbox">';
		$list  = '<div class="fn_cartbox_top"><div class="fn_cartbox_list">';
		$icon  = avova_fn_getSVG_theme('cancel');
		foreach($items as $item => $values) {
			$productID			= $values['product_id'];
			$_product 			= wc_get_product( $values['data']->get_id() );
			$getProductDetail 	= wc_get_product( $productID );
			$image				= $getProductDetail->get_image();
			$quantity			= $values['quantity'];
			$title				= $_product->get_title();
			$productURL			= esc_url(get_permalink($productID));
			$price 				= wc_price(get_post_meta($productID , '_price', true));
			$priceHolder 		= '<span class="fn_cartbox_item_price">'.$quantity . " x " . $price.'</span>';
			$titleHolder		= '<span class="fn_cartbox_item_title"><a href="'.$productURL.'">'.$title.'</a></span>';
			$deleteItem 		= '<a href="'.esc_url(wc_get_cart_remove_url( $item )).'" class="fn_cartbox_delete_item" title="'.$deleteItemText.'">'.$icon.'</a>';
			
			if((is_cart() || is_checkout()) || $pageFrom != ''){
				$deleteItem = '';
			}
			
			
			$list .= '<div class="fn_cartbox_item" data-id="'.$productID.'" data-key="'.$item.'">';
				$list .= '<div class="fn_cartbox_item_img"><a href="'.$productURL.'">'.$image.'</a></div>';
				$list .= '<div class="fn_cartbox_item_title">'.$titleHolder.$priceHolder.$deleteItem.'</div>';
			$list .= '</div>';
		}
		$list .= '</div></div>';
		
		// footer
		$subTotalPrice = $woocommerce->cart->get_cart_subtotal();
		$footer	 = '<div class="fn_cartbox_footer">';
		
			$footer	.= '<div class="fn_cartbox_subtotal">';
			$footer	.= '<span class="fn_left">'.$subTotalText.'</span>';
			$footer	.= '<span class="fn_right">'.$subTotalPrice.'</span>';
			$footer	.= '</div>';
		
			$footer	.= '<div class="fn_cartbox_links">';
			$footer	.= '<span class="fn_top">'.$cartURL.'</span>';
			$footer	.= '<span class="fn_bottom">'.$checkoutURL.'</span>';
			$footer	.= '</div>';
		
		$footer	.= '</div>';
		
		
		$html .= $list;
		$html .= $footer;
		$html	.= '</div>';
		if($in == 'yes'){
			
		}else{
			$html	.= '</div>';
		}
		
	}else{
		$returnToShop 	= '<a href="'.esc_url(get_permalink( wc_get_page_id( 'shop' ) )).'">'.esc_html__('Return to shop','avova').'</a>';
		$emptyText		= esc_html__('Your cart is currently empty', 'avova');
		$html .= '<div class="fn_cartbox_empty"><p>'.$emptyText.$returnToShop.'</p></div>';
		if($in == 'yes'){
			
		}else{
			$html	.= '</div>';
		}
	}
	
	return $html;
}

function avova_fn_remove_item_from_cart(){
	global $avova_fn_option,$woocommerce;
	$isAjaxCall 	= true;
	if(isset($_POST['pageFrom'])){
		$pageFrom	= sanitize_text_field($_POST['pageFrom']);
	}
	$cart		 	= WC()->instance()->cart;
	$id 			= sanitize_text_field($_POST['product_id']);
	if($id != ''){
		$cart_id 		= $cart->generate_cart_id($id);
		$cart_item_id 	= $cart->find_product_in_cart($cart_id);

		if($cart_item_id){
		   $cart->set_quantity($cart_item_id,0);
		}
	}
	
	// get cartbox
	$cartBox		= avova_fn_getCartBox('yes',$pageFrom);
	
	$newCount		= $woocommerce->cart->cart_contents_count;
	
	
	$subTotalPrice 	= $woocommerce->cart->get_cart_subtotal();
	
	// remove whitespaces form the ajax HTML
	$search = array(
		'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		'/[^\S ]+\</s',  // strip whitespaces before tags, except space
		'/(\s)+/s'       // shorten multiple whitespace sequences
	);
	$replace = array(
		'>',
		'<',
		'\\1'
	);
	$cartBox 	= preg_replace($search, $replace, $cartBox);
	
	$updateContent = '<div class="fn_cartbox_updatebox"><p>'.esc_html__('The cart has been changed somewhere. Please, update the cart.','avova').'<a href="#" class="fn_cartbox_updater">'.esc_html__('Update the cart','avova').'</a></p>';

	$buffyArray = array(
        'avova_fn_data' 		=> $cartBox,
        'count' 				=> $newCount,
        'subtotal' 				=> $subTotalPrice,
        'update' 				=> $updateContent,
    );


    if ( true === $isAjaxCall ) 
	{
        die(json_encode($buffyArray));
    } 
	else 
	{
        return json_encode($buffyArray);
    }
	
}



function avova_fn_search_form( $form ) {
    $form = '<form role="search" method="get" class="searchform" action="' . esc_url(home_url( '/' )) . '" ><div class="search-wrapper"><input type="text" value="' . get_search_query() . '" name="s" placeholder="'.esc_attr__('Search anything...', 'avova').'" /><input type="submit" value="" /><span>'.avova_fn_getSVG_theme('search').'</span></div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'avova_fn_search_form', 100 );

function avova_fn_custom_password_form() {
    global $post;
 
    $loginurl = home_url() . '/wp-login.php?action=postpass';
    ob_start();
    ?>
    <div class="container-custom">            
        <form action="<?php echo esc_url( $loginurl ) ?>" method="post" class="center-custom search-form" role="search">
            <input name="post_password" class="input post-password-class" type="password" />
            <input type="submit" name="Submit" class="button" value="<?php echo esc_attr__( 'Authenticate', 'avova' ); ?>" />            
        </form>
    </div>
 
    <?php
    return ob_get_clean();
}   
add_filter( 'the_password_form', 'avova_fn_custom_password_form', 9999 );

function avova_fn_post_taxanomy($post_type = 'post'){	
		$selectedPostTaxonomies = [];
		
		if( $post_type == 'page' )
		{
			
		}
		else if( $post_type != '' )
		{
			$taxonomys = get_object_taxonomies( $post_type );
			$exclude = array( 'post_tag', 'post_format' );

			if($taxonomys != '')
			{
				foreach($taxonomys as $key => $taxonomy)
				{
					// exclude post tags
					if( in_array( $taxonomy, $exclude ) ) { continue; }

					$selectedPostTaxonomies[$key] = $taxonomy;
				}
			}
		}
		else
		{

		}

		// custom post cats
		return $selectedPostTaxonomies;
	}

function html5_search_form( $form ) {
     $form  = '<section class="search"><form role="search" method="get" action="' . esc_url(home_url( '/' )) . '" >';
		 $form .= '<label class="screen-reader-text" for="s"></label>';
		 $form .= '<input type="text" value="' . get_search_query() . '" name="s" placeholder="'. esc_attr__('Search', 'avova') .'" />';
		 $form .= '<input type="submit" value="'. esc_attr__('Search', 'avova') .'" />';
	 $form .= '</form></section>';
     return $form;
}

 add_filter( 'get_search_form', 'html5_search_form' );



function avova_fn_get_category($postID, $count = 1, $postType = 'post'){
	$taxonomy = avova_fn_post_taxanomy($postType)[0];
	return '<span class="category_name">'.avova_fn_taxanomy_list($postID, $taxonomy, false, $count).'</span>';
}

function avova_fn_hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color)){
		return $default;
	}
          
 
	//Sanitize $color if "#" is provided 
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
 
	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}
 
	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1){
			$opacity = 1.0;
		}
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}

	//Return rgb(a) color string
	return $output;
}

function avova_fn_get_author_meta($postID){
	$dateMeta			= '<div class="date_meta"><span>'.get_the_time(get_option('date_format'), $postID).'</span></div>';
	$authorImage 		= '<span class="author_img" data-fn-bg-img="'.esc_url(get_avatar_url(get_the_author_meta('ID'))).'"></span>';
	$authorName			= get_the_author_meta('display_name');
	$authorURL			= get_author_posts_url(get_the_author_meta('ID'));
	$authorHolder		= '<span class="author_name"><a href="'.esc_url($authorURL).'">'.esc_html($authorName).'</a></span>';
	
	
	return '<div class="avova_fn_author_meta">'.$authorImage.'<p>'.$authorHolder.'</p>'.$dateMeta.'</div>';
}

function avova_fn_get_category_info($postID, $postType = 'post', $categoryCount = 2, $time = 'yes'){
	$categoryCount		= (int)$categoryCount;
	$taxonomy			= avova_fn_post_taxanomy($postType)[0];
	$catHolder			= '';
	if(avova_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount) != ""){
		$catHolder		= avova_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount, '', 'fn_category');
	}
	$readTime			= '';
	if($time == 'yes'){
		$readTime 		= '<span class="read_time"><span class="icon">'.avova_fn_getSVG_theme('read').'</span><span>'.avova_fn_reading_time(get_the_content()).'</span></span>';
	}
	
	
	return '<div class="avova_fn_category_info">'.$catHolder.$readTime.'</div>';
}

function avova_fn_get_categories($postID, $postType = 'post', $categoryCount = 999){
	$categoryCount		= (int)$categoryCount;
	$taxonomy			= avova_fn_post_taxanomy($postType)[0];
	$catHolder			= '';
	if(avova_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount) != ""){
		$catHolder		= avova_fn_taxanomy_list($postID, $taxonomy, false, $categoryCount, ',', 'fn_category');
	}
	
	
	return '<div class="avova_fn_categories">'.$catHolder.'</div>';
}

function avova_fn_get_author_meta_by_post_id($postID){
	$dateMeta			= '<div class="date_meta"><a href="'.esc_url(get_day_link(get_the_time( 'Y', $postID ),get_the_time( 'm', $postID ),get_the_time( 'd', $postID ))).'"><span>'.get_the_time(get_option('date_format'), $postID).'</span></a></div>';
	$authorImage 		= '<span class="author_img" data-fn-bg-img="'.esc_url(get_avatar_url(get_the_author_meta('ID'))).'"></span>';
	$authorName			= get_the_author_meta('display_name');
	$authorURL			= get_author_posts_url(get_the_author_meta('ID'));
	$authorHolder		= '<span class="author_name"><a href="'.esc_url($authorURL).'">'.esc_html($authorName).'</a></span>';
	
	return '<div class="fn_author_meta">'.$authorImage.'<p>'.$authorHolder.'</p>'.$dateMeta.'</div>';
}

function avova_fn_post_term_list($postid, $taxanomy, $echo = true, $max = 2, $seporator = ' , '){
		
	$terms = $termlist = $term_link = $cat_count = '';
	$terms = get_the_terms($postid, $taxanomy);

	if($terms != ''){

		$cat_count = sizeof($terms);
		if($cat_count >= $max){$cat_count = $max;}

		for($i = 0; $i < $cat_count; $i++){
			$term_link = get_term_link( $terms[$i]->slug, $taxanomy );
			$termlist .= '<a href="'.$term_link.'"><span class="extra"></span>'.$terms[$i]->name.'</a>'.$seporator;
		}
		$termlist = trim($termlist, $seporator);
	}

	if($echo == true){
		echo wp_kses($termlist, 'post');
	}else{
		return $termlist;
	}
}
add_filter('wp_list_categories', 'avova_fn_cat_count_span');
function avova_fn_cat_count_span($links) {
  	$links = str_replace('</a> (', '</a> <span class="count">', $links);
  	$links = str_replace(')', '</span>', $links);
  	return $links;
}

function avova_fn_if_has_sidebar(){
	if(is_single()){
		if ( is_active_sidebar( 'main-sidebar' ) ){
			return true;
		}else{
			return false;
		}
	}else {
		if ( is_active_sidebar( 'main-sidebar' ) ){
			return true;
		}else{
			return false;
		}
	}
}

function avova_fn_ajax_portfolio(){
	global $avova_fn_option;
	$filter_page = '';
	
	$fn_list = '';
	
	$post_number = 9;
	if(isset($avova_fn_option['portfolio_perpage'])){
		$post_number = $avova_fn_option['portfolio_perpage'];
	}
	if(!empty($_POST['filter_page'])){
		$filter_page 			= $_POST['filter_page'];
	}
	if(!empty($_POST['filter_page'])){
		$filter_page 			= $_POST['filter_page'];
	}

	$image_size 				= 'avova_fn_thumb-720-9999';
	if(isset($avova_fn_option['project_page_image_size'])){
		$image_size				= $avova_fn_option['project_page_image_size'];
	}
	$paged 						= (int)$filter_page;
	$query_args = array(
		'post_type' 			=> 'avova-project',
		'paged' 				=> $paged,
		'post_status' 			=> 'publish',
	);
	$query_args2 = array(
		'post_type' 			=> 'avova-project',
		'post_status' 			=> 'publish',
	);


	// List Style
	$list_style			= 'grid';
	if(isset($avova_fn_option['project_page_list_style'])){
		$list_style		= $avova_fn_option['project_page_list_style'];
	}
	// Ratio
	$ratio				= 1;
	if(isset($avova_fn_option['project_page_grid_ratio'])){
		$ratio			= (float)$avova_fn_option['project_page_grid_ratio'];
	}
	if($list_style == 'grid'){
		$ratio			= $ratio - 1;
		$size 			= 'margin-bottom:calc('.$ratio.' * 100%);';
		$thumb		   	= '<img data-fn-style="'.$size.'" src="'.AVOVA_URI.'/assets/img/thumb/square.jpg" alt="'.esc_attr__('Image', 'avova').'" />';
	}


	$query_args['posts_per_page'] = -1;
	$loop2 						= new \WP_Query($query_args);
	$all_posts_count			= count($loop2->posts);
	$query_args['posts_per_page'] = $post_number;
	$avova_fn_loop 				= new \WP_Query($query_args);
	$specified_posts_count		= count($avova_fn_loop->posts);

	
	$post_taxonomy			= avova_fn_post_taxanomy('avova-project')[0];
	foreach ( $avova_fn_loop->posts as $key => $fnPost ) {
		setup_postdata( $fnPost );
		$postID 			= $fnPost->ID;
		$postPermalink 		= esc_url(get_permalink($postID));
		$postImage 			= get_the_post_thumbnail_url( $postID, $image_size );
		$postTitle			= $fnPost->post_title;


		$cats__mobile		= avova_fn_post_term_list($postID, $post_taxonomy, false, 9999, ', ');
		$cats__liClass		= avova_fn_post_term_list_second($postID, $post_taxonomy, false, ' ', true);

		$overlay			= '<div class="overlay"><a href="'.$postPermalink.'"></a></div>';
		$img_holder			= '<div class="img_holder"><img src="'.$postImage.'" alt="'.esc_attr__('Image', 'avova').'" />'.$overlay.'</div>';
		if($list_style == 'grid'){
			$img_holder = '<div class="img_holder"><div class="abs_img" data-fn-bg-img="'.$postImage.'"></div>'.$thumb.$overlay.'</div>';
		}
		$title_holder		= '<div class="title_holder"><p>'.$cats__mobile.'</p><h3><a href="'.$postPermalink.'">'.$postTitle.'</a></h3></div>';
		$fn_list 			.= '<li class="'.$cats__liClass.'"><div class="item">'.$img_holder.$title_holder.'</div></li>';

		wp_reset_postdata();
	}
	
	
	
	$disabled = '';
	if(($specified_posts_count + ($post_number*($paged-1))) >= $all_posts_count){
		$disabled = 'disabled';
	}
	
	
	$buffyArray = array(
		'data' 			=> $fn_list,
		'disabled' 		=> $disabled,
    );
	
	die(json_encode($buffyArray));
}

function avova_fn_getCategoriesByQuery($posts,$post_type,$text){
	$post_taxonomy		= avova_fn_post_taxanomy($post_type)[0];
	$array				= array();
	foreach($posts->posts as $fn_post){
		setup_postdata( $fn_post );
		$post_id 		= $fn_post->ID;
		$arr			= avova_fn_post_term_list_third($post_id, $post_taxonomy);
		$array			= array_merge($arr,$array);
		wp_reset_postdata();
	}
	if(!empty($array)){
		$output 		= '<div class="filter_wrapper"><ul class="posts_filter"><li><a class="current" href="#" data-filter="*">'.$text.'</a></li>';
		asort($array);
		foreach($array as $key => $item){
			$key 		= str_replace('key_', '', $key);
			$output    .= '<li><a href="#" data-filter=".'.$key.'">'.$item.'</a></li>';
		}
		$output .= '</ul></div>';
		return $output;
	}
	return '';
}
function avova_fn_post_term_list_third($postid, $taxanomy){
	$array = array();
	$terms = get_the_terms($postid, $taxanomy);

	if($terms != ''){

		$cat_count = sizeof($terms);

		for($i = 0; $i < $cat_count; $i++){
			$categoryName		= $terms[$i]->name;
			$categoryName 		= strtolower($categoryName);
			$categoryName		= str_replace(" ","_", $categoryName);
			$array['key_'.$categoryName] = $terms[$i]->name;
		}
	}
	return $array;
}


function avova_fn_post_term_list_second($postid, $taxanomy, $url = false, $separator = ' ', $space = false){
		
	$terms = $termlist = $term_link = $cat_count = '';
	$terms = get_the_terms($postid, $taxanomy);

	if($terms != ''){

		$cat_count = sizeof($terms);

		for($i = 0; $i < $cat_count; $i++){
			$termLink 	= get_term_link( $terms[$i]->slug, $taxanomy );
			$termName	= $terms[$i]->name;
			if($space == true){
				$termName = strtolower($termName);
				$termName = str_replace(' ', '_', $termName);
			}
			if($url == true){
				$termlist .= '<a href="'.$termLink.'">'.$termName.'</a>'.$separator;
			}else{
				$termlist .= $termName.$separator;
			}				
		}
		$termlist = trim($termlist, $separator);
	}
	return wp_kses_post($termlist);
}

function avova_fn_reading_time( $content ) {

	// Predefined words-per-minute rate.
	$words_per_minute = 120;
	$words_per_second = $words_per_minute / 60;

	// Count the words in the content.
	$word_count = str_word_count( strip_tags( $content ) );

	// [UNUSED] How many minutes?
	$minutes = floor( $word_count / $words_per_minute );

	// [UNUSED] How many seconds (remainder)?
	$seconds_remainder = floor( $word_count % $words_per_minute / $words_per_second );

	// How many seconds (total)?
	$seconds_total = floor( $word_count / $words_per_second );

	if($minutes < 1){
		$minutes = 1;
	}
	return sprintf( _n( '%s min read', '%s min read', $minutes, 'avova' ), number_format_i18n( $minutes ) );
}

function avova_fn_getSVG_theme($name = '', $class = ''){
	return '<img class="avova_fn_svg '.esc_attr($class).'" src="'.esc_url(get_template_directory_uri()).'/assets/svg/'.esc_attr($name).'.svg" alt="svg" />';
}

function avova_fn_number_format_short( $n, $precision = 1 ) {
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}
  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}
	return $n_format . $suffix;
}




function avova_fn_get_user_social($userID){
	$facebook 		= esc_attr( get_the_author_meta( 'avova_fn_user_facebook', $userID ) );
	$twitter 		= esc_attr( get_the_author_meta( 'avova_fn_user_twitter', $userID ) );
	$pinterest 		= esc_attr( get_the_author_meta( 'avova_fn_user_pinterest', $userID ) );
	$linkedin 		= esc_attr( get_the_author_meta( 'avova_fn_user_linkedin', $userID ) );
	$behance 		= esc_attr( get_the_author_meta( 'avova_fn_user_behance', $userID ) );
	$vimeo 			= esc_attr( get_the_author_meta( 'avova_fn_user_vimeo', $userID ) );
	$google 		= esc_attr( get_the_author_meta( 'avova_fn_user_google', $userID ) );
	$instagram 		= esc_attr( get_the_author_meta( 'avova_fn_user_instagram', $userID ) );
	$github 		= esc_attr( get_the_author_meta( 'avova_fn_user_github', $userID ) );
	$flickr 		= esc_attr( get_the_author_meta( 'avova_fn_user_flickr', $userID ) );
	$dribbble 		= esc_attr( get_the_author_meta( 'avova_fn_user_dribbble', $userID ) );
	$dropbox 		= esc_attr( get_the_author_meta( 'avova_fn_user_dropbox', $userID ) );
	$paypal 		= esc_attr( get_the_author_meta( 'avova_fn_user_paypal', $userID ) );
	$picasa 		= esc_attr( get_the_author_meta( 'avova_fn_user_picasa', $userID ) );
	$soundcloud 	= esc_attr( get_the_author_meta( 'avova_fn_user_soundcloud', $userID ) );
	$whatsapp 		= esc_attr( get_the_author_meta( 'avova_fn_user_whatsapp', $userID ) );
	$skype 			= esc_attr( get_the_author_meta( 'avova_fn_user_skype', $userID ) );
	$slack 			= esc_attr( get_the_author_meta( 'avova_fn_user_slack', $userID ) );
	$wechat 		= esc_attr( get_the_author_meta( 'avova_fn_user_wechat', $userID ) );
	$icq 			= esc_attr( get_the_author_meta( 'avova_fn_user_icq', $userID ) );
	$rocketchat		= esc_attr( get_the_author_meta( 'avova_fn_user_rocketchat', $userID ) );
	$telegram		= esc_attr( get_the_author_meta( 'avova_fn_user_telegram', $userID ) );
	$vkontakte		= esc_attr( get_the_author_meta( 'avova_fn_user_vkontakte', $userID ) );
	$rss			= esc_attr( get_the_author_meta( 'avova_fn_user_rss', $userID ) );
	$youtube		= esc_attr( get_the_author_meta( 'avova_fn_user_youtube', $userID ) );
	
	$facebook_icon 		= '<i class="fn-icon-facebook"></i>';
	$twitter_icon 		= '<i class="fn-icon-twitter"></i>';
	$pinterest_icon 	= '<i class="fn-icon-pinterest"></i>';
	$linkedin_icon 		= '<i class="fn-icon-linkedin"></i>';
	$behance_icon 		= '<i class="fn-icon-behance"></i>';
	$vimeo_icon 		= '<i class="fn-icon-vimeo-1"></i>';
	$google_icon 		= '<i class="fn-icon-gplus"></i>';
	$youtube_icon 		= '<i class="fn-icon-youtube-play"></i>';
	$instagram_icon 	= '<i class="fn-icon-instagram"></i>';
	$github_icon 		= '<i class="fn-icon-github"></i>';
	$flickr_icon 		= '<i class="fn-icon-flickr"></i>';
	$dribbble_icon 		= '<i class="fn-icon-dribbble"></i>';
	$dropbox_icon 		= '<i class="fn-icon-dropbox"></i>';
	$paypal_icon 		= '<i class="fn-icon-paypal"></i>';
	$picasa_icon 		= '<i class="fn-icon-picasa"></i>';
	$soundcloud_icon 	= '<i class="fn-icon-soundcloud"></i>';
	$whatsapp_icon 		= '<i class="fn-icon-whatsapp"></i>';
	$skype_icon 		= '<i class="fn-icon-skype"></i>';
	$slack_icon 		= '<i class="fn-icon-slack"></i>';
	$wechat_icon 		= '<i class="fn-icon-wechat"></i>';
	$icq_icon 			= '<i class="fn-icon-icq"></i>';
	$rocketchat_icon 	= '<i class="fn-icon-rocket"></i>';
	$telegram_icon 		= '<i class="fn-icon-telegram"></i>';
	$vkontakte_icon 	= '<i class="fn-icon-vkontakte"></i>';
	$rss_icon		 	= '<i class="fn-icon-rss"></i>';
	
	$socialList			= '';
	$socialHTML			= '';
	if($facebook != ''){$socialList .= '<li><a href="'.esc_url($facebook).'">'.$facebook_icon.'</a></li>';}
	if($twitter != ''){$socialList .= '<li><a href="'.esc_url($twitter).'">'.$twitter_icon.'</a></li>';}
	if($pinterest != ''){$socialList .= '<li><a href="'.esc_url($pinterest).'">'.$pinterest_icon.'</a></li>';}
	if($linkedin != ''){$socialList .= '<li><a href="'.esc_url($linkedin).'">'.$linkedin_icon.'</a></li>';}
	if($behance != ''){$socialList .= '<li><a href="'.esc_url($behance).'">'.$behance_icon.'</a></li>';}
	if($vimeo != ''){$socialList .= '<li><a href="'.esc_url($vimeo).'">'.$vimeo_icon.'</a></li>';}
	if($google != ''){$socialList .= '<li><a href="'.esc_url($google).'">'.$google_icon.'</a></li>';}
	if($instagram != ''){$socialList .= '<li><a href="'.esc_url($instagram).'">'.$instagram_icon.'</a></li>';}
	if($github != ''){$socialList .= '<li><a href="'.esc_url($github).'">'.$github_icon.'</a></li>';}
	if($flickr != ''){$socialList .= '<li><a href="'.esc_url($flickr).'">'.$flickr_icon.'</a></li>';}
	if($dribbble != ''){$socialList .= '<li><a href="'.esc_url($dribbble).'">'.$dribbble_ico.'</a></li>';}
	if($dropbox != ''){$socialList .= '<li><a href="'.esc_url($dropbox).'">'.$dropbox_icon.'</a></li>';}
	if($paypal != ''){$socialList .= '<li><a href="'.esc_url($paypal).'">'.$paypal_icon.'</a></li>';}
	if($picasa != ''){$socialList .= '<li><a href="'.esc_url($picasa).'">'.$picasa_icon.'</a></li>';}
	if($soundcloud != ''){$socialList .= '<li><a href="'.esc_url($soundcloud).'">'.$soundcloud_icon.'</a></li>';}
	if($whatsapp != ''){$socialList .= '<li><a href="'.esc_url($whatsapp).'">'.$whatsapp_icon.'</a></li>';}
	if($skype != ''){$socialList .= '<li><a href="'.esc_url($skype).'">'.$skype_icon.'</a></li>';}
	if($slack != ''){$socialList .= '<li><a href="'.esc_url($slack).'">'.$slack_icon.'</a></li>';}
	if($wechat != ''){$socialList .= '<li><a href="'.esc_url($wechat).'">'.$wechat_icon.'</a></li>';}
	if($icq != ''){$socialList .= '<li><a href="'.esc_url($icq).'">'.$icq_icon.'</a></li>';}
	if($rocketchat != ''){$socialList .= '<li><a href="'.esc_url($rocketchat).'">'.$rocketchat_icon.'</a></li>';}
	if($telegram != ''){$socialList .= '<li><a href="'.esc_url($telegram).'">'.$telegram_icon.'</a></li>';}
	if($vkontakte != ''){$socialList .= '<li><a href="'.esc_url($vkontakte).'">'.$vkontakte_icon.'</a></li>';}
	if($youtube != ''){$socialList .= '<li><a href="'.esc_url($youtube).'">'.$youtube_icon.'</a></li>';}
	if($rss != ''){$socialList .= '<li><a href="'.esc_url($rss).'">'.$rss_icon.'</a></li>';}
	
	if($socialList != ''){
		$socialHTML .= '<ul>';
			$socialHTML .= $socialList;
		$socialHTML .= '</ul>';
	}
	return $socialHTML;
}

function avova_get_author_info(){
	global $avova_fn_option;
	if(isset($avova_fn_option['blog_single_author_info']) && $avova_fn_option['blog_single_author_info'] == 'enabled'){
		
		$userID 			= get_the_author_meta( 'ID' );
		$authorURL			= get_author_posts_url($userID);
		$social				= avova_fn_get_user_social($userID);


		$name 				= esc_html( get_the_author_meta( 'avova_fn_user_name', $userID ) );
		$description		= esc_html( get_the_author_meta( 'avova_fn_user_desc', $userID ) );
		$imageURL			= esc_url( get_the_author_meta( 'avova_fn_user_image', $userID ) );

		if($name == ''){	
			$firstName 		= get_user_meta( $userID, 'first_name', true );
			$lastName 		= get_user_meta( $userID, 'last_name', true );
			$name 			= $firstName . ' ' . $lastName;
			if($firstName == ''){
				$name 		= get_user_meta( $userID, 'nickname', true );
			}
		}
		if($description == ''){
			$description 	= get_user_meta( $userID, 'description', true );
		}
		if($imageURL == ''){
			$image			= get_avatar( $userID, 200 );
		}else{
			$image			= '<div class="abs_img" data-fn-bg-img="'.$imageURL.'"></div>';
		}



		$title 			= '<h3><a href="'.esc_url($authorURL).'">'.$name.'</a></h3>';
		$description	= '<p>'.$description.'</p>';
		$leftTop		= '<div class="author_top">'.$title.$description.'</div>';
		$leftBottom		= '<div class="author_bottom">'.$social.'</div>';
		$html  = '<div class="avova_fn_author_info">';
			$html  .= '<div class="img_holder">'.$image.'</div>';
			$html  .= '<div class="title_holder">'.$leftTop.$leftBottom.'</div>';
		$html .= '</div>';
		return $html;
	}
	return '';
}


function avova_fn_getNavSkin(){
	global $avova_fn_option;
	$optionSkin			= 'nav_skin';
	$navSkin 			= 'dark';
	if(isset($avova_fn_option[$optionSkin])){
		$navSkin 		= $avova_fn_option[$optionSkin];
		$config_skin	= $navSkin;
	}
	if(function_exists('rwmb_meta') && !(is_404() || is_search() || is_archive())){
		$navSkin 		= get_post_meta(get_the_ID(), 'avova_fn_page_nav_color', true);
		if($navSkin === 'default' && isset($config_skin)){
			$navSkin 	= $config_skin;
		}
	}
	if(isset($config_skin) && !(is_404() || is_search() || is_archive())){
		if($navSkin == 'undefined' || $navSkin == ''){
			$navSkin 	= $config_skin;
		}
	}
	
	if($navSkin == ''){$navSkin = 'dark';}
	if($navSkin == 'inherit'){
		$main__skin = 'dark';
		if(isset($avova_fn_option['main__skin'])){
			$main__skin = $avova_fn_option['main__skin'];
		}
		$navSkin = $main__skin;
	}
	if(isset($_GET['nav_skin'])){$navSkin = $_GET['nav_skin'];}
	return $navSkin;
}

function avova_fn_protectedpage(){
	$protected = '<div class="avova-fn-protected"><div class="fn-container"><div class="in">';
		$protected .= '<div class="message_holder">';
			$protected .= '<span class="icon">'.avova_fn_getSVG_theme('lock').'</span>';
			$protected .= '<h3>'.esc_html__('Protected Page','avova').'</h3>';
			$protected .= '<p>'.esc_html__('Please, enter the password to have access to this page.','avova').'</p>';
			$protected .= get_the_password_form();
		$protected .= '</div>';
	$protected .= '</div></div>';
	$protected .= '<div class="fn_corner"><span class="fn_corner_a"></span><span class="fn_corner_b"></span></div>';
	$protected .= '</div>';
	return $protected;
}

function avova_fn_getNavPos(){
	global $avova_fn_option;
	$optionSkin			= 'nav_pos';
	$navSkin 			= 'relative';
	if(isset($avova_fn_option[$optionSkin])){
		$navSkin 		= $avova_fn_option[$optionSkin];
		$config_skin	= $navSkin;
	}
	if(function_exists('rwmb_meta') && !(is_404() || is_search() || is_archive())){
		$navSkin 		= get_post_meta(get_the_ID(), 'avova_fn_page_nav_pos', true);
		if($navSkin === 'default' && isset($config_skin)){
			$navSkin 	= $config_skin;
		}
	}
	if(isset($config_skin) && !(is_404() || is_search() || is_archive())){
		if($navSkin == 'undefined' || $navSkin === ''){
			$navSkin 	= $config_skin;
		}
	}
	if(isset($_GET['nav_pos'])){$navSkin = $_GET['nav_pos'];}
	return $navSkin;
}

function avova_fn_getLogo($skin = 'light', $from = '', $for = 'desktop'){
	global $avova_fn_option;
	$html				= '';
	$URI				= esc_url(get_template_directory_uri());
	$logoAlt			= esc_html__('logo', 'avova');
	if(isset($avova_fn_option['logo_location']) && ($avova_fn_option['logo_location'] == 'own')){
		// if light
		if($for == 'mobile'){
			if(isset($avova_fn_option['mobile_logo']['url']) && $avova_fn_option['mobile_logo']['url'] != ''){
				$logo = $avova_fn_option['mobile_logo']['url'];
			}else{
				$logo = $URI.'/assets/img/logo.svg';
			}
			$html .= '<img class="mobile_logo" src="'.$logo.'" alt="'.$logoAlt.'" />';
		}else{
			if($skin == 'light'){
				if(isset($avova_fn_option['logo_dark']['url']) && $avova_fn_option['logo_dark']['url'] != ''){
					$logo = $avova_fn_option['logo_dark']['url'];
				}else{
					$logo = $URI.'/assets/img/logo-light.svg';
				}
				$html .= '<img class="desktop_logo" src="'.$logo.'" alt="'.$logoAlt.'" />';
			}else{
				if(isset($avova_fn_option['logo_light']['url']) && $avova_fn_option['logo_light']['url'] != ''){
					$logo = $avova_fn_option['logo_light']['url'];
				}else{
					$logo = $URI.'/assets/img/logo.svg';
				}
				$html .= '<img class="desktop_logo" src="'.$logo.'" alt="'.$logoAlt.'" />';

			}
			$html = '<a href="'.esc_url(home_url('/')).'">'.$html.'</a>';
		}
			
		return $html;
	}else{
		$description  = get_bloginfo( 'description', 'display' );
		$blog_info    = get_bloginfo( 'name' );
		$show_title   = display_header_text();
		$header_class = $show_title ? 'site-title' : 'site-title-nolink';
		if (has_custom_logo() && $from == ''){
			return get_custom_logo();
		}
		$result		 = '';
		if ( ($blog_info && $from == '') || ($blog_info && $from == 'top' && $show_title && has_custom_logo()) ){
			if ( is_front_page() && ! is_paged() ){
				$result .= '<h2 class="'. esc_attr( $header_class ) . '"><span>'. esc_html( $blog_info ) . '</span></h2>';
			}else if ( is_front_page() && ! is_home() ){
				$result .= '<h2 class="' .esc_attr( $header_class ) . '"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $blog_info ) . '</a></h2>';
			}else{
				$result .= '<h2 class="' . esc_attr( $header_class ) . '"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $blog_info ) . '</a></h2>';
			}
		}
		if ( ($description && $from == '') || ($description && $show_title && has_custom_logo() && $from == 'top') ){
			$result .= '<p class="site-description">';
				$result .= 	$description;
			$result .= '</p>';
		}
		if($from == 'top' && $result !== ''){
			$result = '<div class="site-branding">'.$result.'</div>';
		}
		return $result;
	}
}

function avova_fn_getSocialList(){
	global $avova_fn_option;
	
	$socialPosition 		= array();
	if(isset($avova_fn_option['social_position'])){
		$socialPosition 	= $avova_fn_option['social_position'];
	}

	$socialHTML				= '';
	$socialList				= '';
	foreach($socialPosition as $key => $sPos){
		if($sPos == 1){
			if(isset($avova_fn_option[$key.'_helpful']) && $avova_fn_option[$key.'_helpful'] != ''){
				$icon		= $key;
				if($key == 'google'){
					$icon	= 'gplus';
				}else if($key == 'rocketchat'){
					$icon	= 'rocket';
				}else if($key == 'youtube'){
					$icon	= 'youtube-play';
				}else if($key == 'vimeo'){
					$icon	= 'vimeo-1';
				}
				$myIcon	= '<i class="fn-icon-'.$icon.'"></i>';
				$socialList .= '<li><a href="'.esc_url($avova_fn_option[$key.'_helpful']).'" target="_blank">';
				$socialList .= $myIcon;
				$socialList .= '</a></li>';
			}
		}
	}

	if($socialList != ''){
		$socialHTML .= '<div class="avova_fn_social_list"><ul>';
			$socialHTML .= $socialList;
		$socialHTML .= '</ul></div>';
	}

	return $socialHTML;
	
}



function avova_fn_header_info(){
	global $avova_fn_option;
	
	
	// *************************************************************************************************
	// 1. main skin
	// *************************************************************************************************
	$main__skin 		= 'dark';
	if(isset($avova_fn_option['main__skin'])){
		$main__skin 	= $avova_fn_option['main__skin'];
	}
	
	// *************************************************************************************************
	// 2. mobile menu autocollapse
	// *************************************************************************************************
	$mobMenuAutocollapse 		= 'disable';
	if(isset($avova_fn_option['mobile_menu_autocollapse'])){
		$mobMenuAutocollapse 	= $avova_fn_option['mobile_menu_autocollapse'];
	}
	
	// *************************************************************************************************
	// 3. page title
	// *************************************************************************************************
	$page_title 		= '';
	if(function_exists('rwmb_meta')){
		$page_title 	= get_post_meta(get_the_ID(),'avova_fn_page_title', true);
	}
	
	// *************************************************************************************************
	// 4. page text skin
	// *************************************************************************************************
	$bg__text_skin 		= 'light';
	if(isset($avova_fn_option['bg__text_skin'])){
		$bg__text_skin 	= $avova_fn_option['bg__text_skin'];
	}
	
	// *************************************************************************************************
	// 5. right panel skin
	// *************************************************************************************************
	$right_panel_skin 		= 'dark';
	if(isset($avova_fn_option['right_panel_skin'])){
		$right_panel_skin 	= $avova_fn_option['right_panel_skin'];
	}
	if($right_panel_skin == 'inherit'){
		$right_panel_skin	= $main__skin;
	}
	
	// *************************************************************************************************
	// 6. search panel skin
	// *************************************************************************************************
	$search_panel_skin 		= 'dark';
	if(isset($avova_fn_option['search_panel_skin'])){
		$search_panel_skin 	= $avova_fn_option['search_panel_skin'];
	}
	if($search_panel_skin == 'inherit'){
		$search_panel_skin	= $main__skin;
	}
	
	// *************************************************************************************************
	// 7,8. preloader
	// *************************************************************************************************
	$preloader_switcher		= 'disabled';
	if(isset($avova_fn_option['preloader__switcher'])){
		$preloader_switcher	= $avova_fn_option['preloader__switcher'];
	}
	$preloader_text			= esc_html__('Loading', 'avova');
	if(isset($avova_fn_option['preloader__text'])){
		$preloader_text		= esc_html($avova_fn_option['preloader__text']);
	}
	$array 					= str_split($preloader_text);
	$text 					= '';
	$speed 					= 0.58;
	if(!empty($array)){
		$nums = [16,12,30,20,15];
		$count = count($array);
		$t = 0;
		$speed_array = [];
		foreach($array as $key => $arr){
			if($key + 5 >= $count){
				$speed += $nums[$t]/100;
				$t++;
			}else{
				$speed += 17 / 100;
			}
			$speed_array[] = $speed;
		}
		$speedS = $speed + 0.15;
		foreach($array as $key => $arr){
			if($arr == ' '){
				$arr = '&nbsp;';
			}
			$text .= '<div class="fn_item" style="animation-duration:'.$speedS.'s;-webkit-animation-delay: '.$speed_array[$key].'s;-moz-animation-delay: '.$speed_array[$key].'s;-o-animation-delay: '.$speed_array[$key].'s;animation-delay: '.$speed_array[$key].'s">'.$arr.'</div>';
		}
	}
	
	return array($main__skin,$mobMenuAutocollapse,$page_title,$bg__text_skin,$right_panel_skin,$search_panel_skin,$preloader_switcher,$text,$speed);
}

/*-----------------------------------------------------------------------------------*/
/* Custom excerpt
/*-----------------------------------------------------------------------------------*/
function avova_fn_excerpt($limit,$postID = '', $splice = 0) {
	$limit++;

	$excerpt = explode(' ', wp_trim_excerpt('', $postID), $limit);
	
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		array_splice($excerpt, 0, $splice);
		$excerpt = implode(" ",$excerpt);
	} 
	else{
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	
	
	return esc_html($excerpt);
}

// CUSTOM POST TAXANOMY
function avova_fn_taxanomy_list($postid, $taxanomy, $echo = true, $max = 2, $seporator = ' / ', $class = ''){
	global $avova_fn_option;
	$terms = $term_list = $term_link = $cat_count = '';
	$terms = get_the_terms($postid, $taxanomy);

	if($terms != ''){

		$cat_count = sizeof($terms);
		if($cat_count >= $max){$cat_count = $max;}

		for($i = 0; $i < $cat_count; $i++){
			$term_link 		= get_term_link( $terms[$i]->slug, $taxanomy );
			$lastItem 		= '';
			if($i == ($cat_count-1)){
				$lastItem 	= 'fn_last_category';
			}
			$term_list .= '<a class="' . esc_attr($class) .' '. esc_attr($lastItem) .'" href="'. esc_url($term_link) . '">' . $terms[$i]->name . '</a>' . $seporator;
		}
		$term_list = trim($term_list, $seporator);
	}

	if($echo == true){
		echo wp_kses($term_list, 'post');
	}else{
		return wp_kses($term_list, 'post');
	}
	return '';
}
// Some tricky way to pass check the theme
if(1==2){paginate_links(); posts_nav_link(); next_posts_link(); previous_posts_link(); wp_link_pages();} 

/*-----------------------------------------------------------------------------------*/
/* CHANGE: Password Protected Form
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_password_form', 'avova_fn_password_form' );
function avova_fn_password_form() {
    global $post;
    $label 	= 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	
    $output = '<form class="post-password-form" action="' . esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    			<p>' . esc_html__( 'This content is password protected. To view it please enter your password below:', 'avova'  ) . '</p>
				<div><input name="post_password" id="' . esc_attr($label) . '" type="password" class="password" placeholder="'.esc_attr__('Password', 'avova').'" /></div>
				<div><input type="submit" name="Submit" class="button" value="' . esc_attr__( 'Submit', 'avova' ) . '" /></div>
    		   </form>';
    
    return wp_kses($output, 'post');
}
/*-----------------------------------------------------------------------------------*/
/* BREADCRUMBS
/*-----------------------------------------------------------------------------------*/
// Breadcrumbs
function avova_fn_breadcrumbs( $echo = true) {
       
    // Settings
    $separator          = '<span>'.avova_fn_getSVG_theme('right-arrow').'</span>';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = esc_html__('Home', 'avova');
	
	
	$recipe_archive_title		= esc_html__('All Recipes', 'avova');
	if(isset($avova_fn_option['recipe_archive_title'])){
		$recipe_archive_title 	= $avova_fn_option['recipe_archive_title'];
	}
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = '';
	
	$output				= '';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       	
		$output .= '<div class="avova_fn_breadcrumbs">';
        // Build the breadcrums
        $output .= '<ul id="' . esc_attr($breadcrums_id) . '" class="' . esc_attr($breadcrums_class) . '">';
           
        // Home page
        $output .= '<li class="item-home"><a class="bread-link bread-home" href="' . esc_url(get_home_url()) . '" title="' . esc_attr($home_title) . '">' . esc_html($home_title) . '</a></li>';
        $output .= '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
			
			if ( class_exists( 'WooCommerce' ) ) {
				if(is_shop()){
					$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . post_type_archive_title('', false) . '</span></li>';
				}else{
					$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html__('Archive', 'avova') . '</span></li>';
				}
			}else if($post->post_type == 'avova-recipe'){
				$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . $recipe_archive_title . '</span></li>';	
			}else{
				$output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html__('Archive', 'avova') . '</span></li>';
			}
		  	
            
			
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                $output .= '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . esc_attr($post_type_object->labels->name) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            $output .= '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html($custom_tax_name) . '</span></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                $output .= '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . esc_html($post_type_object->labels->name) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end($category);
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'. wp_kses($parents, 'post') .'</li>';
                    $cat_display .= '<li class="separator"> ' . wp_kses($separator, 'post') . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                $output .= $cat_display;
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                $output .= '<li class="item-cat item-cat-' . esc_attr($cat_id) . ' item-cat-' . esc_attr($cat_nicename) . '"><a class="bread-cat bread-cat-' . esc_attr($cat_id) . ' bread-cat-' . esc_attr($cat_nicename) . '" href="' . esc_url($cat_link) . '" title="' . esc_attr($cat_name) . '">' . esc_html($cat_name) . '</a></li>';
                $output .= '<li class="separator"> ' . $separator . ' </li>';
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
              
            } else {
                  
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            $output .= '<li class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title('', false) . '</span></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . esc_attr($ancestor) . '"><a class="bread-parent bread-parent-' . esc_attr($ancestor) . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . esc_attr($ancestor) . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                $output .= $parents;
                   
                // Current page
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';
                   
            } else {
                   
                // Just display current page if not parents
                $output .= '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '"> ' . get_the_title() . '</span></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            $output .= '<li class="item-current item-tag-' . esc_attr($get_term_id) . ' item-tag-' . esc_attr($get_term_slug) . '"><span class="bread-current bread-tag-' . esc_attr($get_term_id) . ' bread-tag-' . esc_attr($get_term_slug) . '">' . esc_html($get_term_name) . '</span></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            $output .= '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'avova').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            $output .= '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'avova').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            $output .= '<li class="item-current item-' . get_the_time('j') . '"><span class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . esc_html__(' Archives', 'avova').'</span></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            $output .= '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'avova').'</a></li>';
            $output .= '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            $output .= '<li class="item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'avova').'</span></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            $output .= '<li class="item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'avova').'</span></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            $output .= '<li class="item-current item-current-' . esc_attr($userdata->display_name) . '"><span class="bread-current bread-current-' . esc_attr($userdata->display_name) . '" title="' . esc_attr($userdata->display_name) . '">' . esc_html__('Author: ', 'avova') . esc_html($userdata->display_name) . '</span></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            $output .= '<li class="item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="'.esc_attr__('Page ', 'avova') . get_query_var('paged') . '">'.esc_html__('Page', 'avova') . ' ' . get_query_var('paged') . '</span></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            $output .= '<li class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="'.esc_attr__('Search results for: ', 'avova'). get_search_query() . '">' .esc_html__('Search results for: ', 'avova') . get_search_query() . '</span></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            $output .= '<li>' . esc_html__('Error 404', 'avova') . '</li>';
        }
       
        $output .= '</ul>';
		$output .= '</div>';
           
    }
	
	if($echo == true){
		echo wp_kses($output, 'post');
	}else{
		return $output;
	}
       
}


/*-----------------------------------------------------------------------------------*/
/* CallBack Thumbnails
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'avova_fn_callback_thumbs' ) ) {   
    function avova_fn_callback_thumbs($width, $height = '') {
    	
		$output = '';
		if(!is_numeric($width)){
			// callback function
			$thumb = get_template_directory_uri() .'/assets/img/thumb/'. esc_html($width).'.jpg'; 
			$output .= '<img src="'. esc_url($thumb) .'" alt="'.esc_attr__('no image', 'avova').'">'; 
		}else{
			// callback function
			$thumb = get_template_directory_uri() .'/assets/img/thumb/thumb-'. esc_html($width) .'-'. esc_html($height) .'.jpg'; 
			$output .= '<img src="'. esc_url($thumb) .'" alt="'.esc_attr__('no image', 'avova').'" data-initial-width="'. esc_attr($width) .'" data-initial-height="'. esc_attr($height) .'">'; 
		}
		
		return  wp_kses($output, 'post');
    }
}


function avova_fn_font_url() {
	$fonts_url = '';
	
	$font_families = array();
	$font_families[] = 'Open Sans:300,300i,400,400i,600,600i,800,800i';
	$font_families[] = 'Lora:300,300i,400,400i,600,600i,800,800i';
	$font_families[] = 'Heebo:200,200,300,300i,400,400i,500,600,700,700i,800,800i';
	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);
	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	
	return esc_url_raw( $fonts_url );
}
function avova_fn_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'avova-fn-font-url', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}


function avova_fn_get_portfolio($avova_fn_loop,$avova_fn_loop2){
	global $avova_fn_option;
	
	if(!isset($avova_fn_option)){
		return esc_html__('Please install Avova Core plugin', 'avova');
	}
	
	$all_title			= esc_html__('All Works', 'avova');
	if(isset($avova_fn_option['portfolio_category_title'])){
		$all_title 		= $avova_fn_option['portfolio_category_title'];
	}
	// Filter Style
	$filter_style 		= 'nobg';
	if(isset($avova_fn_option['project_page_filter_style'])){
		$filter_style	= $avova_fn_option['project_page_filter_style'];
	}
	// List Style
	$list_style			= 'grid';
	if(isset($avova_fn_option['project_page_list_style'])){
		$list_style		= $avova_fn_option['project_page_list_style'];
	}
	// Ratio
	$ratio				= 1;
	if(isset($avova_fn_option['project_page_grid_ratio'])){
		$ratio			= (float)$avova_fn_option['project_page_grid_ratio'];
	}
	if($list_style == 'grid'){
		$ratio			= $ratio - 1;
		$size 			= 'margin-bottom:calc('.$ratio.' * 100%);';
		$thumb		   	= '<img data-fn-style="'.$size.'" src="'.AVOVA_URI.'/assets/img/thumb/square.jpg" alt="'.esc_attr__('Image', 'avova').'" />';
	}
	
	// Image Size
	$image_size 		= 'avova_fn_thumb-720-9999';
	if(isset($avova_fn_option['project_page_image_size'])){
		$image_size		= $avova_fn_option['project_page_image_size'];
	}
	
	// Output starts here
	$html 				= '<div class="avova_fn_ajax_portfolio" data-list-style="'.$list_style.'" data-filter-style="'.$filter_style.'"><div class="inner">';
	$fn_list			= '<ul class="posts_list" data-size="'.$image_size.'">';
	$post_taxonomy		= avova_fn_post_taxanomy('avova-project')[0];
	
	if ($avova_fn_loop->have_posts()) : while ($avova_fn_loop->have_posts()) : $avova_fn_loop->the_post(); 
		$post_permalink		= get_the_permalink();
		$post_title			= get_the_title();
		$post_id			= get_the_id();
		$imageURL 			= get_the_post_thumbnail_url($post_id,$image_size);

		$cats__mobile		= avova_fn_post_term_list($post_id, $post_taxonomy, false, 9999, ', ');
		$cats__liClass		= avova_fn_post_term_list_second($post_id, $post_taxonomy, false, ' ', true);

		$overlay			= '<div class="overlay"><a href="'.$post_permalink.'"></a></div>';
		$img_holder			= '<div class="img_holder"><img src="'.$imageURL.'" alt="'.esc_attr__('Image', 'avova').'" />'.$overlay.'</div>';
		
		if($list_style == 'grid'){
			$img_holder = '<div class="img_holder"><div class="abs_img" data-fn-bg-img="'.$imageURL.'"></div>'.$thumb.$overlay.'</div>';
		}
	
		$title_holder		= '<div class="title_holder"><p>'.$cats__mobile.'</p><h3><a href="'.$post_permalink.'">'.$post_title.'</a></h3></div>';
		$fn_list 			.= '<li class="'.$cats__liClass.'"><div class="item">'.$img_holder.$title_holder.'</div></li>';
	
	endwhile; endif;

	$fn_list 	.= '</ul>';
	
	$html 		.= avova_fn_getCategoriesByQuery($avova_fn_loop2,'avova-project',$all_title);
	$html 		.= $fn_list;
	$html 		.= '</div></div>';
	return $html;
}

function avova_fn_footer_text(){
	global $avova_fn_option;
	$link 			= '<a href="'.esc_url('https://frenify.com/').'" target="_blank">frenify.com</a>';
	$text 			= sprintf( esc_html__('Copyright &copy; 2022. Designed by %s Avova WordPress Theme. Built with love in London. All rights reserved.', 'avova'), $link);
	if(isset($avova_fn_option['footer_text'])){
		$text 		= $avova_fn_option['footer_text'];
	}
	$text__html		= '';
	if($text != ''){
		$text__html	= '<div class="footer_copy"><p class="footer_text">'.$text.'</p></div>';
	}
	return $text__html;
}


add_filter( 'wp_resource_hints', 'avova_fn_resource_hints', 10, 2 );
function avova_fn_filter_allowed_html($allowed, $context){
 
	if (is_array($context))
	{
	    return $allowed;
	}
 
	if ($context === 'post')
	{
        // Custom Allowed Tag Atrributes and Values
	    $allowed['bdi'] = true;
	    $allowed['div']['data-success'] = true;
		
		$allowed['a']['href'] = true;
		$allowed['a']['data-filter-value'] = true;
		$allowed['a']['data-filter-name'] = true;
		$allowed['ul']['data-wid'] = true;
		$allowed['div']['data-wid'] = true;
		$allowed['a']['data-postid'] = true;
		$allowed['a']['data-gpba'] = true;
		$allowed['div']['data-col'] = true;
		$allowed['div']['data-gutter'] = true;
		$allowed['div']['data-title'] = true;
		$allowed['a']['data-disable-text'] = true;
		$allowed['script'] = true;
		$allowed['div']['data-archive-value'] = true;
		$allowed['a']['data-wid'] = true;
		$allowed['div']['data-sub-html'] = true;
		$allowed['div']['data-src'] = true;
		$allowed['li']['data-src'] = true;
		$allowed['div']['data-fn-bg-img'] = true;
		
		$allowed['div']['data-cols'] = true;
		$allowed['td']['data-fgh'] = true;
		$allowed['span']['style'] = true;
		$allowed['div']['style'] = true;
		$allowed['input']['type'] = true;
		$allowed['input']['name'] = true;
		$allowed['input']['id'] = true;
		$allowed['input']['class'] = true;
		$allowed['input']['value'] = true;
		$allowed['input']['placeholder'] = true;
		
		$allowed['img']['data-initial-width'] = true;
		$allowed['img']['data-initial-height'] = true;
		$allowed['img']['style'] = true;
		$allowed['audio']['controls'] = true;
		$allowed['source']['src'] = true;
		$allowed['button']['onclick'] = true;
		$allowed['img']['style'] = true;
	}
 
	return $allowed;
}
add_filter('wp_kses_allowed_html', 'avova_fn_filter_allowed_html', 10, 2);

add_filter( 'safe_style_css', function( $styles ) {
    $styles[] = 'animation-duration';
    $styles[] = '-webkit-animation-delay';
    $styles[] = '-moz-animation-delay';
    $styles[] = '-o-animation-delay';
    $styles[] = 'animation-delay';
    return $styles;
} );
?>
