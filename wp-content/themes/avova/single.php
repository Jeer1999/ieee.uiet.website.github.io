<?php

get_header();

global $post, $avova_fn_option;
$avova_fn_pagestyle = 'ws';

if(function_exists('rwmb_meta')){
	if(isset(get_post_meta(get_the_ID())['avova_fn_page_style'])){
		$avova_fn_pagestyle = get_post_meta(get_the_ID(), 'avova_fn_page_style', true);
	}
}
if($avova_fn_pagestyle == 'ws' && !avova_fn_if_has_sidebar()){
	$avova_fn_pagestyle		= 'full';
}

// CHeck if page is password protected	
if(post_password_required($post)){
	$protected = '<div class="avova-fn-protected"><div class="in">';
		$protected .= '<div class="message_holder">';
			$protected .= '<span class="icon">'.avova_fn_getSVG_theme('lock').'</span>';
			$protected .= '<h3>'.esc_html__('Protected','avova').'</h3>';
			$protected .= '<p>'.esc_html__('Please, enter the password to have access to this page.','avova').'</p>';
			$protected .= get_the_password_form();
		$protected .= '</div>';
	$protected .= '</div></div>';
	echo wp_kses($protected, 'post');
}
else
{

?>
<div class="avova_fn_single_template">

	<?php if($avova_fn_pagestyle == 'full'){ ?>

	<!-- WITHOUT SIDEBAR -->
	<div class="avova_fn_nosidebar">
		<div class="inner">
			<div class="avova_fn_blog_single">
				<?php get_template_part( 'inc/templates/template-post-single' );?>
			</div>
		</div>
	</div>
	<!-- /WITHOUT SIDEBAR -->

	<?php }else{ ?>
	
	<!-- WITH SIDEBAR -->
	<?php get_template_part( 'inc/templates/template-post-single', '', array('has_sidebar' => $avova_fn_pagestyle) );?>
	<!-- /WITH SIDEBAR -->

	<?php } ?>
				
</div>
<?php } ?>

<?php get_footer(); ?>  