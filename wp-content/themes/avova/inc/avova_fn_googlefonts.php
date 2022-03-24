<?php
function avova_fn_fonts() {
	global $avova_fn_option;
	$customfont = '';
	
	$default = array(
					'arial',
					'verdana',
					'trebuchet',
					'georgia',
					'times',
					'tahoma',
					'helvetica');
	$bodyFont = $navFont = $navMobFont = $headingFont = $blockquoteFont = $extraFont = '';
	if(isset($avova_fn_option['body_font']['font-family'])){$bodyFont = $avova_fn_option['body_font']['font-family'];}
	if(isset($avova_fn_option['nav_font']['font-family'])){$navFont = $avova_fn_option['nav_font']['font-family'];}
	if(isset($avova_fn_option['nav_mob_font']['font-family'])){$navMobFont = $avova_fn_option['nav_mob_font']['font-family'];}
	if(isset($avova_fn_option['heading_font']['font-family'])){$headingFont = $avova_fn_option['heading_font']['font-family'];}
	if(isset($avova_fn_option['blockquote_font']['font-family'])){$blockquoteFont = $avova_fn_option['blockquote_font']['font-family'];}
	if(isset($avova_fn_option['extra_font']['font-family'])){$extraFont = $avova_fn_option['extra_font']['font-family'];}
	
	$googlefonts = array(
					$bodyFont,
					$navFont,
					$navMobFont,
					$headingFont,
					$blockquoteFont,
					$extraFont,
					);
	$googlefonts = array_filter($googlefonts);

				
	foreach($googlefonts as $getfonts) {
		if(!in_array($getfonts, $default)) {
			$customfont = str_replace(' ', '+', $getfonts). ':400,400italic,500,500italic,600,600italic,700,700italic|' . $customfont;
		}
	}
	
	if($customfont != '' && isset($avova_fn_option)){
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'avova_fn_googlefonts', "$protocol://fonts.googleapis.com/css?family=" . substr_replace($customfont ,"",-1) . "&subset=latin,cyrillic,greek,vietnamese" );
	}	
}
add_action( 'wp_enqueue_scripts', 'avova_fn_fonts' );
?>