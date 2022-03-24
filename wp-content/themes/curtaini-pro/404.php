<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Curtaini Pro
 */

get_header(); ?>

<div class="container">
    <div id="TabNavigator">
        <div class="SiteContent-Left">
           <div class="Unicare-Article-Listing">
            <div class="Unicare-ContentStyle"> 
             <header class="page-header">
                <h1 class="entry-title"><?php esc_html_e( '404 Not Found', 'curtaini-pro' ); ?></h1>                
            </header><!-- .page-header -->
            <div class="page-content">
                <p><?php esc_html_e( 'Looks like you have taken a wrong turn....Dont worry... it happens to the best of us.', 'curtaini-pro' ); ?></p>  
            </div><!-- .page-content -->
           </div><!--.Unicare-ContentStyle-->
          </div><!--.Unicare-Article-Listing-->      
       </div><!-- SiteContent-Left-->   
        <?php get_sidebar();?>       
        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>