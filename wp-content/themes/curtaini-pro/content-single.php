<?php
/**
 * @package Curtaini Pro
 */
?>
<div class="Unicare-Article-Listing">
 <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
   <div class="Unicare-ContentStyle"> 
   
    <?php if (has_post_thumbnail() ){ ?>
                <div class="BlogImgDiv">
                 <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                </div>
             <?php } ?>   
    <header class="entry-header">
        
           <div class="Unicare-BlogPostMeta">
			 <?php if( get_theme_mod( 'curtaini_pro_hide_postdate_fromsingle' ) == '') { ?> 
                  <div class="post-date"> <i class="far fa-clock"></i>  <?php echo esc_html( get_the_date() ); ?></div><!-- post-date --> 
                <?php } ?> 
                
                <?php if( get_theme_mod( 'curtaini_pro_hide_postcats_fromsingle' ) == '') { ?> 
                  <span class="blogpost_cat"> <i class="far fa-folder-open"></i> <?php the_category( __( ', ', 'curtaini-pro' ));?></span>
               <?php } ?>  
             </div><!-- .Unicare-BlogPostMeta --> 
             <?php the_title( '<h3 class="single-title">', '</h3>' ); ?>      
    </header><!-- .entry-header -->
    <div class="entry-content">		
        <?php the_content(); ?>
        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'curtaini-pro' ),
            'after'  => '</div>',
        ) );
        ?>
        <div class="postmeta">          
            <div class="post-tags"><?php the_tags(); ?> </div>
            <div class="clear"></div>
        </div><!-- postmeta -->
    </div><!-- .entry-content -->   
    <footer class="entry-meta">
      <?php edit_post_link( __( 'Edit', 'curtaini-pro' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->
    </div><!-- .Unicare-ContentStyle--> 
 </article>
</div><!-- .Unicare-Article-Listing-->