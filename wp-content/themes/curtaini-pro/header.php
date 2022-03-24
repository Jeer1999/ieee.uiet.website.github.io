<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Curtaini Pro
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
?>
<a class="skip-link screen-reader-text" href="#TabNavigator">
<?php esc_html_e( 'Skip to content', 'curtaini-pro' ); ?>
</a>
<?php
$curtaini_pro_show_hdrsocial_options  		 	= esc_attr( get_theme_mod('curtaini_pro_show_hdrsocial_options', false) ); 
$curtaini_pro_show_contactdetails_settings 	   	= esc_attr( get_theme_mod('curtaini_pro_show_contactdetails_settings', false) ); 
$curtaini_pro_show_frontslide_settings 	  		= esc_attr( get_theme_mod('curtaini_pro_show_frontslide_settings', false) );
$curtaini_pro_show_aboutpharmacy_settings       = esc_attr( get_theme_mod('curtaini_pro_show_aboutpharmacy_settings', false) );
$curtaini_pro_show_fourpageboxes_sections      	= esc_attr( get_theme_mod('curtaini_pro_show_fourpageboxes_sections', false) );

?>
<div id="SiteWrapper" <?php if( get_theme_mod( 'curtaini_pro_layouttype' ) ) { echo 'class="boxlayout"'; } ?>>
<?php
if ( is_front_page() && !is_home() ) {
	if( !empty($curtaini_pro_show_frontslide_settings)) {
	 	$innerpage_cls = '';
	}
	else {
		$innerpage_cls = 'innerpage_header';
	}
}
else {
$innerpage_cls = 'innerpage_header';
}
?>

<header id="masthead" class="site-header <?php echo esc_attr($innerpage_cls); ?> "> 
    
  <div class="header-section">    
       <div class="container"> 
       
        
        <?php if( $curtaini_pro_show_hdrsocial_options != ''){ ?>       
              <div class="uc-topbox">
                  <div class="hdr3col">
                    <div class="search-box">
                       <?php get_search_form(); ?>
                    </div>
                  </div>
              
              
                  <div class="hdr3col">               
                    <div class="hdrsocial">                                                
					   <?php $curtaini_pro_hdrfb_link = get_theme_mod('curtaini_pro_hdrfb_link');
                        if( !empty($curtaini_pro_hdrfb_link) ){ ?>
                        <a class="fab fa-facebook-f" target="_blank" href="<?php echo esc_url($curtaini_pro_hdrfb_link); ?>"></a>
                       <?php } ?>
                    
                       <?php $curtaini_pro_hdrtw_link = get_theme_mod('curtaini_pro_hdrtw_link');
                        if( !empty($curtaini_pro_hdrtw_link) ){ ?>
                        <a class="fab fa-twitter" target="_blank" href="<?php echo esc_url($curtaini_pro_hdrtw_link); ?>"></a>
                       <?php } ?>
                
                      <?php $curtaini_pro_hdrin_link = get_theme_mod('curtaini_pro_hdrin_link');
                        if( !empty($curtaini_pro_hdrin_link) ){ ?>
                        <a class="fab fa-linkedin" target="_blank" href="<?php echo esc_url($curtaini_pro_hdrin_link); ?>"></a>
                      <?php } ?> 
                      
                      <?php $curtaini_pro_hdrigram_link = get_theme_mod('curtaini_pro_hdrigram_link');
                        if( !empty($curtaini_pro_hdrigram_link) ){ ?>
                        <a class="fab fa-instagram" target="_blank" href="<?php echo esc_url($curtaini_pro_hdrigram_link); ?>"></a>
                      <?php } ?> 
                 </div><!--end .hdrsocial--> 
                </div>             
                            
            
              <div class="hdr3col">              
				<?php
                $curtaini_pro_orderonlinetext = get_theme_mod('curtaini_pro_orderonlinetext');
                if( !empty($curtaini_pro_orderonlinetext) ){ ?>        
                <?php $curtaini_pro_orderonlinelink = get_theme_mod('curtaini_pro_orderonlinelink');
                if( !empty($curtaini_pro_orderonlinelink) ){ ?>              
                    <a class="orderonline" target="_blank" href="<?php echo esc_url($curtaini_pro_orderonlinelink); ?>">
                    <?php echo esc_html($curtaini_pro_orderonlinetext); ?>            
                    </a>                 
                <?php }} ?> 
              
              </div>
              <div class="clear"></div>
           </div><!-- .uc-topbox -->  
          <?php } ?>  
        
            
        <div class="logo">
           <?php curtaini_pro_the_custom_logo(); ?>
            <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
                <p><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </div><!-- logo --> 
        <div class="header-right-70"> 
          <div id="navigationpanel">            
            <nav id="main-navigation" class="primary-navigation" role="navigation" aria-label="Primary Menu">
                <button type="button" class="menu-toggle">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php
               	wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                ) );
                ?>
            </nav><!-- #main-navigation -->
	       </div><!-- #navigationpanel -->     
         </div><!-- .header-right-70 -->     
        <div class="clear"></div>
     </div><!-- .container -->   
 </div><!-- .header-section --> 
 <div class="clear"></div> 
</header><!--.site-header --> 
 
<?php 
if ( is_front_page() && !is_home() ) {
if($curtaini_pro_show_frontslide_settings != '') {
	for($i=1; $i<=3; $i++) {
	  if( get_theme_mod('curtaini_pro_frontslide'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('curtaini_pro_frontslide'.$i,true));
	  }
	}
?> 
<div class="HeaderSlider">              
<?php if(!empty($slider_Arr)){ ?>
<div id="slider" class="nivoSlider">
<?php 
$i=1;
$slidequery = new WP_Query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
while( $slidequery->have_posts() ) : $slidequery->the_post();
$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); 
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
?>
<?php if(!empty($image)){ ?>
<img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php }else{ ?>
<img src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/slides/slider-default.jpg" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php } ?>
<?php $i++; endwhile; ?>
</div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo esc_attr( $j ); ?>" class="nivo-html-caption">         
     <h2><?php the_title(); ?></h2>
     <p><?php $excerpt = get_the_excerpt(); echo esc_html( curtaini_pro_string_limit_words( $excerpt, esc_attr(get_theme_mod('curtaini_pro_excerpt_length_frontslide','15')))); ?></p>
		<?php
        $curtaini_pro_frontslide_btntext = get_theme_mod('curtaini_pro_frontslide_btntext');
        if( !empty($curtaini_pro_frontslide_btntext) ){ ?>
            <a class="slidermorebtn" href="<?php the_permalink(); ?>"><?php echo esc_html($curtaini_pro_frontslide_btntext); ?></a>
        <?php } ?>                  
    </div>   
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>   
<?php } ?>
 </div><!-- .HeaderSlider -->    
<?php } } ?> 

<?php if ( is_front_page() && ! is_home() ) { ?>
<?php if( $curtaini_pro_show_contactdetails_settings != ''){ ?> 
<div class="contactsection">
	<div class="container">
       <div class="infobxfix">              
            <?php
                $curtaini_pro_appointmentbtn = get_theme_mod('curtaini_pro_appointmentbtn');
                if( !empty($curtaini_pro_appointmentbtn) ){ ?>        
                <?php $curtaini_pro_appointmentbtnlink = get_theme_mod('curtaini_pro_appointmentbtnlink');
                if( !empty($curtaini_pro_appointmentbtnlink) ){ ?>              
                    <a class="appointbtn" target="_blank" href="<?php echo esc_url($curtaini_pro_appointmentbtnlink); ?>">
                    <i class="far fa-calendar-alt"></i> <?php echo esc_html($curtaini_pro_appointmentbtn); ?>            
                    </a>                 
                <?php }} ?> 
                
                
                <?php
                $curtaini_pro_meetdoctorbtn = get_theme_mod('curtaini_pro_meetdoctorbtn');
                if( !empty($curtaini_pro_meetdoctorbtn) ){ ?>        
                <?php $curtaini_pro_meetdoctorbtnlink = get_theme_mod('curtaini_pro_meetdoctorbtnlink');
                if( !empty($curtaini_pro_meetdoctorbtnlink) ){ ?>              
                    <a class="appointbtn" target="_blank" href="<?php echo esc_url($curtaini_pro_meetdoctorbtnlink); ?>">
                    <i class="fas fa-user-md"></i> <?php echo esc_html($curtaini_pro_meetdoctorbtn); ?>            
                    </a>                 
                <?php }} ?>           
                                     
             
            
            <?php $curtaini_pro_contactno = get_theme_mod('curtaini_pro_contactno');
               if( !empty($curtaini_pro_contactno) ){ ?>              
                 <div class="emergencybox">
                     <div class="phoneicon"><i class="fas fa-phone-volume"></i></div>
                      <h4><?php echo esc_html($curtaini_pro_contactno); ?>
					  <span><?php
						$curtaini_pro_emergency_contact = get_theme_mod('curtaini_pro_emergency_contact');
						if( !empty($curtaini_pro_emergency_contact) ){ ?>
						<?php echo esc_html($curtaini_pro_emergency_contact); ?>
                     <?php } ?></span></h4>  
                 </div>       
         <?php } ?>           
        </div>
	  </div><!--end .container-->
  </div><!-- .contactsection -->
  <?php } ?>
  

	<?php if( $curtaini_pro_show_fourpageboxes_sections != ''){ ?> 
   <section id="home-sections1">
     <div class="container">       
			<?php
            $curtaini_pro_fourpageboxes_sectiontitle = get_theme_mod('curtaini_pro_fourpageboxes_sectiontitle');
            if( !empty($curtaini_pro_fourpageboxes_sectiontitle) ){ ?>
                <h2 class="section_title"><?php echo esc_html($curtaini_pro_fourpageboxes_sectiontitle); ?></h2>
             <?php } ?>
             
             <?php
            $curtaini_pro_fourpageboxes_shortdesc = get_theme_mod('curtaini_pro_fourpageboxes_shortdesc');
            if( !empty($curtaini_pro_fourpageboxes_shortdesc) ){ ?>
                <div class="shortdesc"><?php echo esc_html($curtaini_pro_fourpageboxes_shortdesc); ?></div>
             <?php } ?> 
                         
          <?php 
                for($n=1; $n<=4; $n++) {    
                if( get_theme_mod('curtaini_pro_fourbxpage'.$n,false)) {      
                    $queryvar = new WP_Query('page_id='.absint(get_theme_mod('curtaini_pro_fourbxpage'.$n,true)) );		
                    while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
                     <div class="UnicareBX-25 <?php if($n % 4 == 0) { echo "last_column"; } ?>">                                                                   
							 <?php if(has_post_thumbnail() ) { ?>
                                <div class="Uni-IconBX">
                                  <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>                                
                                </div>        
                             <?php } ?>
                             <div class="Unicare-DesBX">              	
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4> 
                                <p><?php $excerpt = get_the_excerpt(); echo esc_html( curtaini_pro_string_limit_words( $excerpt, esc_attr(get_theme_mod('curtaini_pro_fourpageboxes_excerpt_length','10')))); ?></p> 
								<?php
                                    $curtaini_pro_fourpageboxes_readmorebutton = get_theme_mod('curtaini_pro_fourpageboxes_readmorebutton');
                                    if( !empty($curtaini_pro_fourpageboxes_readmorebutton) ){ ?>
                                    <a class="UniMore" href="<?php the_permalink(); ?>"><?php echo esc_html($curtaini_pro_fourpageboxes_readmorebutton); ?></a>
                                <?php } ?>  
                             </div>                                                      
                     </div>
                    <?php endwhile;
                    wp_reset_postdata();                                  
                } } ?>                                 
               <div class="clear"></div>        
      </div><!-- .container -->
    </section><!-- #home-sections1 -->
  <?php } ?>   

	 <?php if( $curtaini_pro_show_aboutpharmacy_settings != ''){ ?>  
      <section id="home-sections2">
        <div class="container">                               
            <?php 
            if( get_theme_mod('curtaini_pro_aboutpharmacy_singlepage',false)) {     
            $queryvar = new WP_Query('page_id='.absint(get_theme_mod('curtaini_pro_aboutpharmacy_singlepage',true)) );			
                while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>                  
                  <div class="Unicare-Left45">
                    <?php the_post_thumbnail();?>
                  </div>                  
                  <div class="Unicare-Right55">  
					  <?php
                        $curtaini_pro_aboutpharmacy_subtitle = get_theme_mod('curtaini_pro_aboutpharmacy_subtitle');
                        if( !empty($curtaini_pro_aboutpharmacy_subtitle) ){ ?>
                        <h4 class="sub_title"><?php echo esc_html($curtaini_pro_aboutpharmacy_subtitle); ?></h4>
                       <?php } ?>    
                      <h3><?php the_title(); ?></h3>   
                      <p><?php $excerpt = get_the_excerpt(); echo esc_html( curtaini_pro_string_limit_words( $excerpt, esc_attr(get_theme_mod('curtaini_pro_aboutpharmacy_excerptlength','40')))); ?></p> 
                      
					   <?php
                        $curtaini_pro_aboutpharmacy_quote = get_theme_mod('curtaini_pro_aboutpharmacy_quote');
                        if( !empty($curtaini_pro_aboutpharmacy_quote) ){ ?>
                        <h5 class="quote"><?php echo esc_html($curtaini_pro_aboutpharmacy_quote); ?></h5>
                       <?php } ?>   
                       <a href="<?php the_permalink(); ?>" class="servicesemore"><?php esc_html_e( 'Read More', 'curtaini-pro' ); ?></a> 
                  </div>                  
                                                                           
                <?php endwhile;
                 wp_reset_postdata(); ?>                                    
                <?php } ?>                                 
           <div class="clear"></div>                       
         </div><!-- .container -->
        </section><!-- #home-sections2-->
     <?php } ?>
<?php } ?>