<?php

get_header();

global $post, $avova_fn_option;
$avova_fn_pagetitle = '';

if(function_exists('rwmb_meta')){
	$avova_fn_pagetitle 			= get_post_meta(get_the_ID(),'avova_fn_page_title', true);
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


	<!-- WITHOUT SIDEBAR -->
	<div class="avova_fn_nosidebar">
		<div class="inner">
			<div class="avova_fn_portfolio_single">
				<?php get_template_part( 'inc/templates/template-portfolio-single' );?>
			</div>
		</div>
	</div>
	<!-- /WITHOUT SIDEBAR -->
				
</div>
<?php } ?>

<?php get_footer(); ?>  