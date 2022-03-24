<?php    
/**
 *curtaini-pro Theme Customizer
 *
 * @package Curtaini Pro
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function curtaini_pro_customize_register( $wp_customize ) {	
	
	function curtaini_pro_sanitize_dropdown_pages( $page_id, $setting ) {
	  // Ensure $input is an absolute integer.
	  $page_id = absint( $page_id );	
	  // If $page_id is an ID of a published page, return it; otherwise, return the default.
	  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	function curtaini_pro_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	} 
	
	function curtaini_pro_sanitize_phone_number( $phone ) {
		// sanitize phone
		return preg_replace( '/[^\d+]/', '', $phone );
	} 
	
	
	function curtaini_pro_sanitize_excerptrange( $number, $setting ) {	
		// Ensure input is an absolute integer.
		$number = absint( $number );	
		// Get the input attributes associated with the setting.
		$atts = $setting->manager->get_control( $setting->id )->input_attrs;	
		// Get minimum number in the range.
		$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );	
		// Get maximum number in the range.
		$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );	
		// Get step.
		$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );	
		// If the number is within the valid range, return it; otherwise, return the default
		return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
	}

	function curtaini_pro_sanitize_number_absint( $number, $setting ) {
		// Ensure $number is an absolute integer (whole number, zero or greater).
		$number = absint( $number );		
		// If the input is an absolute integer, return it; otherwise, return the default
		return ( $number ? $number : $setting->default );
	}
	
	// Ensure is an absolute integer
	function curtaini_pro_sanitize_choices( $input, $setting ) {
		global $wp_customize; 
		$control = $wp_customize->get_control( $setting->id ); 
		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
	
		
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.logo h1 a',
		'render_callback' => 'curtaini_pro_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.logo p',
		'render_callback' => 'curtaini_pro_customize_partial_blogdescription',
	) );
		
	 	
	 //Panel for section & control
	$wp_customize->add_panel( 'curtaini_pro_themeoptions_panel', array(
		'priority' => 4,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Curtaini Pro Settings', 'curtaini-pro' ),		
	) );

	$wp_customize->add_section('curtaini_pro_siteboxlayout_settings',array(
		'title' => __('Site Layout Options','curtaini-pro'),			
		'priority' => 1,
		'panel' => 	'curtaini_pro_themeoptions_panel',          
	));		
	
	$wp_customize->add_setting('curtaini_pro_layouttype',array(
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'curtaini_pro_layouttype', array(
    	'section'   => 'curtaini_pro_siteboxlayout_settings',    	 
		'label' => __('Check to Show Box Layout','curtaini-pro'),
		'description' => __('check for box layout','curtaini-pro'),
    	'type'      => 'checkbox'
     )); //Box Layout Options 
	
	$wp_customize->add_setting('curtaini_pro_themecoloroption',array(
		'default' => '#1bbde3',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'curtaini_pro_themecoloroption',array(
			'label' => __('Site Color Settings','curtaini-pro'),			
			'section' => 'colors',
			'settings' => 'curtaini_pro_themecoloroption'
		))
	);
	
	$wp_customize->add_setting('curtaini_pro_secondcolorcode',array(
		'default' => '#46298f',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'curtaini_pro_secondcolorcode',array(
			'label' => __('Second Color Scheme','curtaini-pro'),			
			'section' => 'colors',
			'settings' => 'curtaini_pro_secondcolorcode'
		))
	);
	
	$wp_customize->add_setting('curtaini_pro_appbtncolor',array(
		'default' => '#6b54a5',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'curtaini_pro_appbtncolor',array(
			'label' => __('Appointment and meet doctor button','curtaini-pro'),			
			'section' => 'colors',
			'settings' => 'curtaini_pro_appbtncolor'
		))
	);
	
	
	$wp_customize->add_setting('curtaini_pro_menucolor',array(
		'default' => '#333333',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'curtaini_pro_menucolor',array(
			'label' => __('Navigation font Color','curtaini-pro'),			
			'section' => 'colors',
			'settings' => 'curtaini_pro_menucolor'
		))
	);
	
	
	$wp_customize->add_setting('curtaini_pro_menuactive',array(
		'default' => '#1bbde3',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'curtaini_pro_menuactive',array(
			'label' => __('Navigation Hover/Active Color','curtaini-pro'),			
			'section' => 'colors',
			'settings' => 'curtaini_pro_menuactive'
		))
	);
	
	 //Social icons Section
	$wp_customize->add_section('curtaini_pro_hdrsocial_options',array(
		'title' => __('Header Social icons and Order Online Button  Bar','curtaini-pro'),
		'description' => __( 'Add social icons link here to display icons in header ', 'curtaini-pro' ),			
		'priority' => null,
		'panel' => 	'curtaini_pro_themeoptions_panel', 
	));
	
	$wp_customize->add_setting('curtaini_pro_hdrfb_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('curtaini_pro_hdrfb_link',array(
		'label' => __('Add facebook link here','curtaini-pro'),
		'section' => 'curtaini_pro_hdrsocial_options',
		'setting' => 'curtaini_pro_hdrfb_link'
	));	
	
	$wp_customize->add_setting('curtaini_pro_hdrtw_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('curtaini_pro_hdrtw_link',array(
		'label' => __('Add twitter link here','curtaini-pro'),
		'section' => 'curtaini_pro_hdrsocial_options',
		'setting' => 'curtaini_pro_hdrtw_link'
	));

	
	$wp_customize->add_setting('curtaini_pro_hdrin_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('curtaini_pro_hdrin_link',array(
		'label' => __('Add linkedin link here','curtaini-pro'),
		'section' => 'curtaini_pro_hdrsocial_options',
		'setting' => 'curtaini_pro_hdrin_link'
	));
	
	$wp_customize->add_setting('curtaini_pro_hdrigram_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('curtaini_pro_hdrigram_link',array(
		'label' => __('Add instagram link here','curtaini-pro'),
		'section' => 'curtaini_pro_hdrsocial_options',
		'setting' => 'curtaini_pro_hdrigram_link'
	));
	
	$wp_customize->add_setting('curtaini_pro_orderonlinetext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_orderonlinetext',array(	
		'type' => 'text',
		'label' => __('enter order online button name here','curtaini-pro'),
		'section' => 'curtaini_pro_hdrsocial_options',
		'setting' => 'curtaini_pro_orderonlinetext'
	)); //write button name here
	
	$wp_customize->add_setting('curtaini_pro_orderonlinelink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('curtaini_pro_orderonlinelink',array(	
		'type' => 'text',
		'label' => __('enter order online button link here','curtaini-pro'),
		'section' => 'curtaini_pro_hdrsocial_options',
		'setting' => 'curtaini_pro_orderonlinelink'
	)); //enter button link		
	
	
	$wp_customize->add_setting('curtaini_pro_show_hdrsocial_options',array(
		'default' => false,
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'curtaini_pro_show_hdrsocial_options', array(
	   'settings' => 'curtaini_pro_show_hdrsocial_options',
	   'section'   => 'curtaini_pro_hdrsocial_options',
	   'label'     => __('Check To show This Section','curtaini-pro'),
	   'type'      => 'checkbox'
	 ));//Show Footer Social settings
	
	
	 //Contact details section below the slider
	$wp_customize->add_section('curtaini_pro_contactdetails_settings',array(
		'title' => __('Contact Details Sections','curtaini-pro'),				
		'priority' => null,
		'panel' => 	'curtaini_pro_themeoptions_panel',
	));	
	
	$wp_customize->add_setting('curtaini_pro_appointmentbtn',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_appointmentbtn',array(	
		'type' => 'text',
		'label' => __('Enter Request Appointment button name here','curtaini-pro'),
		'section' => 'curtaini_pro_contactdetails_settings',
		'setting' => 'curtaini_pro_appointmentbtn'
	)); //Request Appointment button
	
	
	
	$wp_customize->add_setting('curtaini_pro_appointmentbtnlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('curtaini_pro_appointmentbtnlink',array(	
		'type' => 'text',
		'label' => __('enter Appointment button link here','curtaini-pro'),
		'section' => 'curtaini_pro_contactdetails_settings',
		'setting' => 'curtaini_pro_appointmentbtnlink'
	)); //Request Appointment button link	
	
	
	$wp_customize->add_setting('curtaini_pro_meetdoctorbtn',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_meetdoctorbtn',array(	
		'type' => 'text',
		'label' => __('enter meet the doctor button name here','curtaini-pro'),
		'section' => 'curtaini_pro_contactdetails_settings',
		'setting' => 'curtaini_pro_meetdoctorbtn'
	)); //meet the doctor button	
	
	
	$wp_customize->add_setting('curtaini_pro_meetdoctorbtnlink',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('curtaini_pro_meetdoctorbtnlink',array(	
		'type' => 'text',
		'label' => __('enter meet the doctor button link here','curtaini-pro'),
		'section' => 'curtaini_pro_contactdetails_settings',
		'setting' => 'curtaini_pro_meetdoctorbtnlink'
	)); //meet the doctor button link	
	
		
	$wp_customize->add_setting('curtaini_pro_emergency_contact',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_emergency_contact',array(	
		'type' => 'text',
		'label' => __('write Emergency Contact text here','curtaini-pro'),
		'section' => 'curtaini_pro_contactdetails_settings',
		'setting' => 'curtaini_pro_emergency_contact'
	)); //write Emergency Contact text here		
	
	
	$wp_customize->add_setting('curtaini_pro_contactno',array(
		'default' => null,
		'sanitize_callback' => 'curtaini_pro_sanitize_phone_number'	
	));
	
	$wp_customize->add_control('curtaini_pro_contactno',array(	
		'type' => 'text',
		'label' => __('Enter phone number here','curtaini-pro'),
		'section' => 'curtaini_pro_contactdetails_settings',
		'setting' => 'curtaini_pro_contactno'
	));	
		
	
	$wp_customize->add_setting('curtaini_pro_show_contactdetails_settings',array(
		'default' => false,
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'curtaini_pro_show_contactdetails_settings', array(
	   'settings' => 'curtaini_pro_show_contactdetails_settings',
	   'section'   => 'curtaini_pro_contactdetails_settings',
	   'label'     => __('Check To show This Section','curtaini-pro'),
	   'type'      => 'checkbox'
	 ));//Show Contact Details Sections
	
	 	
	//Slider Section		
	$wp_customize->add_section( 'curtaini_pro_frontslide_settings', array(
		'title' => __('Frontapage Slider Settings', 'curtaini-pro'),
		'priority' => null,
		'description' => __('Default image size for slider is 1400 x 657 pixel.','curtaini-pro'), 
		'panel' => 	'curtaini_pro_themeoptions_panel',           			
    ));
	
	$wp_customize->add_setting('curtaini_pro_frontslide1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'curtaini_pro_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('curtaini_pro_frontslide1',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 1:','curtaini-pro'),
		'section' => 'curtaini_pro_frontslide_settings'
	));	
	
	$wp_customize->add_setting('curtaini_pro_frontslide2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'curtaini_pro_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('curtaini_pro_frontslide2',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 2:','curtaini-pro'),
		'section' => 'curtaini_pro_frontslide_settings'
	));	
	
	$wp_customize->add_setting('curtaini_pro_frontslide3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'curtaini_pro_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('curtaini_pro_frontslide3',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 3:','curtaini-pro'),
		'section' => 'curtaini_pro_frontslide_settings'
	));	//frontpage Slider Section	
	
	//Slider Excerpt Length
	$wp_customize->add_setting( 'curtaini_pro_excerpt_length_frontslide', array(
		'default'              => 15,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'curtaini_pro_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'curtaini_pro_excerpt_length_frontslide', array(
		'label'       => __( 'Slider Excerpt length','curtaini-pro' ),
		'section'     => 'curtaini_pro_frontslide_settings',
		'type'        => 'range',
		'settings'    => 'curtaini_pro_excerpt_length_frontslide','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	$wp_customize->add_setting('curtaini_pro_frontslide_btntext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_frontslide_btntext',array(	
		'type' => 'text',
		'label' => __('enter button name here','curtaini-pro'),
		'section' => 'curtaini_pro_frontslide_settings',
		'setting' => 'curtaini_pro_frontslide_btntext'
	)); // slider read more button text
	
	$wp_customize->add_setting('curtaini_pro_show_frontslide_settings',array(
		'default' => false,
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'curtaini_pro_show_frontslide_settings', array(
	    'settings' => 'curtaini_pro_show_frontslide_settings',
	    'section'   => 'curtaini_pro_frontslide_settings',
	    'label'     => __('Check To Show This Section','curtaini-pro'),
	   'type'      => 'checkbox'
	 ));//Show Front Slider Settings	
	 
	 
	 //Four pages Services Sections
	$wp_customize->add_section('curtaini_pro_fourpageboxes_sections', array(
		'title' => __('Four Page Boxes Sections','curtaini-pro'),
		'description' => __('Select pages from the dropdown for four boxes section','curtaini-pro'),
		'priority' => null,
		'panel' => 	'curtaini_pro_themeoptions_panel',          
	));	
	
	
	$wp_customize->add_setting('curtaini_pro_fourpageboxes_sectiontitle',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_fourpageboxes_sectiontitle',array(	
		'type' => 'text',
		'label' => __('write four page boxes section title here','curtaini-pro'),
		'section' => 'curtaini_pro_fourpageboxes_sections',
		'setting' => 'curtaini_pro_fourpageboxes_sectiontitle'
	)); //write four page boxes sections title here	
	
	
	$wp_customize->add_setting('curtaini_pro_fourpageboxes_shortdesc',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_fourpageboxes_shortdesc',array(	
		'type' => 'text',
		'label' => __('write four page boxes short description here','curtaini-pro'),
		'section' => 'curtaini_pro_fourpageboxes_sections',
		'setting' => 'curtaini_pro_fourpageboxes_shortdesc'
	)); //write four boxes short description here	
	
		
	$wp_customize->add_setting('curtaini_pro_fourbxpage1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'curtaini_pro_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'curtaini_pro_fourbxpage1',array(
		'type' => 'dropdown-pages',			
		'section' => 'curtaini_pro_fourpageboxes_sections',
	));		
	
	$wp_customize->add_setting('curtaini_pro_fourbxpage2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'curtaini_pro_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'curtaini_pro_fourbxpage2',array(
		'type' => 'dropdown-pages',			
		'section' => 'curtaini_pro_fourpageboxes_sections',
	));
	
	$wp_customize->add_setting('curtaini_pro_fourbxpage3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'curtaini_pro_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'curtaini_pro_fourbxpage3',array(
		'type' => 'dropdown-pages',			
		'section' => 'curtaini_pro_fourpageboxes_sections',
	));	
	
	$wp_customize->add_setting('curtaini_pro_fourbxpage4',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'curtaini_pro_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'curtaini_pro_fourbxpage4',array(
		'type' => 'dropdown-pages',			
		'section' => 'curtaini_pro_fourpageboxes_sections',
	));	

	$wp_customize->add_setting( 'curtaini_pro_fourpageboxes_excerpt_length', array(
		'default'              => 10,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'curtaini_pro_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'curtaini_pro_fourpageboxes_excerpt_length', array(
		'label'       => __( 'four page box excerpt length','curtaini-pro' ),
		'section'     => 'curtaini_pro_fourpageboxes_sections',
		'type'        => 'range',
		'settings'    => 'curtaini_pro_fourpageboxes_excerpt_length','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	$wp_customize->add_setting('curtaini_pro_fourpageboxes_readmorebutton',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_fourpageboxes_readmorebutton',array(	
		'type' => 'text',
		'label' => __('Read more button name here','curtaini-pro'),
		'section' => 'curtaini_pro_fourpageboxes_sections',
		'setting' => 'curtaini_pro_fourpageboxes_readmorebutton'
	)); //four box read more button text
	
	
	$wp_customize->add_setting('curtaini_pro_show_fourpageboxes_sections',array(
		'default' => false,
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));		
	
	$wp_customize->add_control( 'curtaini_pro_show_fourpageboxes_sections', array(
	   'settings' => 'curtaini_pro_show_fourpageboxes_sections',
	   'section'   => 'curtaini_pro_fourpageboxes_sections',
	   'label'     => __('Check To Show This Section','curtaini-pro'),
	   'type'      => 'checkbox'
	 ));//Show four page boxes sections
	 
	 
	//Abous Pharmacy section
	$wp_customize->add_section('curtaini_pro_aboutpharmacy_settings', array(
		'title' => __('About Pharmacy Section','curtaini-pro'),
		'description' => __('Select Pages from the dropdown for about pharmacy section','curtaini-pro'),
		'priority' => null,
		'panel' => 	'curtaini_pro_themeoptions_panel',          
	));	
	
	$wp_customize->add_setting('curtaini_pro_aboutpharmacy_subtitle',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_aboutpharmacy_subtitle',array(	
		'type' => 'text',
		'label' => __('write about pharmacy sub title here','curtaini-pro'),
		'section' => 'curtaini_pro_aboutpharmacy_settings',
		'setting' => 'curtaini_pro_aboutpharmacy_subtitle'
	)); //write about pharmacy sub title here	
	
	$wp_customize->add_setting('curtaini_pro_aboutpharmacy_singlepage',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'curtaini_pro_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'curtaini_pro_aboutpharmacy_singlepage',array(
		'type' => 'dropdown-pages',			
		'section' => 'curtaini_pro_aboutpharmacy_settings',
	));	
	
	
	$wp_customize->add_setting('curtaini_pro_aboutpharmacy_quote',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('curtaini_pro_aboutpharmacy_quote',array(	
		'type' => 'text',
		'label' => __('write about pharmacy quote text here','curtaini-pro'),
		'section' => 'curtaini_pro_aboutpharmacy_settings',
		'setting' => 'curtaini_pro_aboutpharmacy_quote'
	)); //write about pharmacy quote here	
	
	
	//About us Excerpt Length
	$wp_customize->add_setting( 'curtaini_pro_aboutpharmacy_excerptlength', array(
		'default'              => 40,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'curtaini_pro_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'curtaini_pro_aboutpharmacy_excerptlength', array(
		'label'       => __( 'About us excerpt length','curtaini-pro' ),
		'section'     => 'curtaini_pro_aboutpharmacy_settings',
		'type'        => 'range',
		'settings'    => 'curtaini_pro_aboutpharmacy_excerptlength','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	
	$wp_customize->add_setting('curtaini_pro_show_aboutpharmacy_settings',array(
		'default' => false,
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'curtaini_pro_show_aboutpharmacy_settings', array(
	    'settings' => 'curtaini_pro_show_aboutpharmacy_settings',
	    'section'   => 'curtaini_pro_aboutpharmacy_settings',
	    'label'     => __('Check To Show This Section','curtaini-pro'),
	    'type'      => 'checkbox'
	));//Show About Us sections	
		 
	 
	 //Blog Posts Settings
	$wp_customize->add_panel( 'curtaini_pro_blogsettings_panel', array(
		'priority' => 3,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Blog Posts Settings', 'curtaini-pro' ),		
	) );
	
	$wp_customize->add_section('curtaini_pro_blogmeta_options',array(
		'title' => __('Blog Meta Options','curtaini-pro'),			
		'priority' => null,
		'panel' => 	'curtaini_pro_blogsettings_panel', 	         
	));		
	
	$wp_customize->add_setting('curtaini_pro_hide_blogdate',array(
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'curtaini_pro_hide_blogdate', array(
    	'label' => __('Check to hide post date','curtaini-pro'),	
		'section'   => 'curtaini_pro_blogmeta_options', 
		'setting' => 'curtaini_pro_hide_blogdate',		
    	'type'      => 'checkbox'
     )); //Blog Date
	 
	 
	 $wp_customize->add_setting('curtaini_pro_hide_postcats',array(
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'curtaini_pro_hide_postcats', array(
		'label' => __('Check to hide post category','curtaini-pro'),	
    	'section'   => 'curtaini_pro_blogmeta_options',		
		'setting' => 'curtaini_pro_hide_postcats',		
    	'type'      => 'checkbox'
     )); //blogposts category	 
	 
	 
	 $wp_customize->add_section('curtaini_pro_postfeatured_image',array(
		'title' => __('Posts Featured image','curtaini-pro'),			
		'priority' => null,
		'panel' => 	'curtaini_pro_blogsettings_panel', 	         
	));		
	
	$wp_customize->add_setting('curtaini_pro_hide_postfeatured_image',array(
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'curtaini_pro_hide_postfeatured_image', array(
		'label' => __('Check to hide post featured image','curtaini-pro'),
    	'section'   => 'curtaini_pro_postfeatured_image',		
		'setting' => 'curtaini_pro_hide_postfeatured_image',	
    	'type'      => 'checkbox'
     )); //Posts featured image
	 
	 
	 $wp_customize->add_setting('curtaini_pro_postimg_left30',array(
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'curtaini_pro_postimg_left30', array(
		'label' => __('Check to featured image Left Align','curtaini-pro'),
    	'section'   => 'curtaini_pro_postfeatured_image',		
		'setting' => 'curtaini_pro_postimg_left30',	
    	'type'      => 'checkbox'
     )); //posts featured images30
	 
	  
	 $wp_customize->add_section('curtaini_pro_postmorebtn',array(
		'title' => __('Posts Read More Button','curtaini-pro'),			
		'priority' => null,
		'panel' => 	'curtaini_pro_blogsettings_panel', 	         
	 ));	
	 
	 $wp_customize->add_setting('curtaini_pro_postmorebuttontext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	)); //blog read more button text
	
	$wp_customize->add_control('curtaini_pro_postmorebuttontext',array(	
		'type' => 'text',
		'label' => __('Read more button text for blog posts','curtaini-pro'),
		'section' => 'curtaini_pro_postmorebtn',
		'setting' => 'curtaini_pro_postmorebuttontext'
	)); //Post read more button text	
	
	$wp_customize->add_section('curtaini_pro_postcontent_settings',array(
		'title' => __('Posts Excerpt Options','curtaini-pro'),			
		'priority' => null,
		'panel' => 	'curtaini_pro_blogsettings_panel', 	         
	 ));	 
	 
	$wp_customize->add_setting( 'curtaini_pro_postexcerptrange', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'curtaini_pro_sanitize_excerptrange',		
	) );
	
	$wp_customize->add_control( 'curtaini_pro_postexcerptrange', array(
		'label'       => __( 'Excerpt length','curtaini-pro' ),
		'section'     => 'curtaini_pro_postcontent_settings',
		'type'        => 'range',
		'settings'    => 'curtaini_pro_postexcerptrange','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('curtaini_pro_postsfullcontent_options',array(
        'default' => 'Excerpt',     
        'sanitize_callback' => 'curtaini_pro_sanitize_choices'
	));
	
	$wp_customize->add_control('curtaini_pro_postsfullcontent_options',array(
        'type' => 'select',
        'label' => __('Posts Content','curtaini-pro'),
        'section' => 'curtaini_pro_postcontent_settings',
        'choices' => array(
        	'Content' => __('Content','curtaini-pro'),
            'Excerpt' => __('Excerpt','curtaini-pro'),
            'No Content' => __('No Excerpt','curtaini-pro')
        ),
	) ); 
	
	
	$wp_customize->add_section('curtaini_pro_postsinglemeta',array(
		'title' => __('Posts Single Settings','curtaini-pro'),			
		'priority' => null,
		'panel' => 	'curtaini_pro_blogsettings_panel', 	         
	));	
	
	$wp_customize->add_setting('curtaini_pro_hide_postdate_fromsingle',array(
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'curtaini_pro_hide_postdate_fromsingle', array(
    	'label' => __('Check to hide post date from single','curtaini-pro'),	
		'section'   => 'curtaini_pro_postsinglemeta', 
		'setting' => 'curtaini_pro_hide_postdate_fromsingle',		
    	'type'      => 'checkbox'
     )); //Hide Posts date from single
	 
	 
	 $wp_customize->add_setting('curtaini_pro_hide_postcats_fromsingle',array(
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'curtaini_pro_hide_postcats_fromsingle', array(
		'label' => __('Check to hide post category from single','curtaini-pro'),	
    	'section'   => 'curtaini_pro_postsinglemeta',		
		'setting' => 'curtaini_pro_hide_postcats_fromsingle',		
    	'type'      => 'checkbox'
     )); //Hide blogposts category single
	 
	 
	 //Sidebar Settings
	$wp_customize->add_section('curtaini_pro_sidebarsettings', array(
		'title' => __('Sidebar Settings','curtaini-pro'),		
		'priority' => null,
		'panel' => 	'curtaini_pro_blogsettings_panel',          
	));		
	 
	$wp_customize->add_setting('curtaini_pro_hidesidebar_blogposts',array(
		'default' => false,
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'curtaini_pro_hidesidebar_blogposts', array(
	   'settings' => 'curtaini_pro_hidesidebar_blogposts',
	   'section'   => 'curtaini_pro_sidebarsettings',
	   'label'     => __('Check to hide sidebar from homepage','curtaini-pro'),
	   'type'      => 'checkbox'
	 ));//hide sidebar blog posts 
	
		 
	 $wp_customize->add_setting('curtaini_pro_hidesidebar_singleposts',array(
		'default' => false,
		'sanitize_callback' => 'curtaini_pro_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'curtaini_pro_hidesidebar_singleposts', array(
	   'settings' => 'curtaini_pro_hidesidebar_singleposts',
	   'section'   => 'curtaini_pro_sidebarsettings',
	   'label'     => __('Check to hide sidebar from single post','curtaini-pro'),
	   'type'      => 'checkbox'
	 ));// Hide sidebar single post	 
		 
}
add_action( 'customize_register', 'curtaini_pro_customize_register' );

function curtaini_pro_custom_css(){ 
?>
	<style type="text/css"> 					
        a,
        #sidebar ul li a:hover,
		#sidebar ol li a:hover,							
        .Unicare-Article-Listing h3 a:hover,		
        .postmeta a:hover,
		.hdrsocial a:hover,
		h4.sub_title,			 			
        .button:hover,		
		h2.services_title span,			
		.Unicare-BlogPostMeta a:hover,
		.Unicare-BlogPostMeta a:focus,
		.site-footer ul li a:hover, 
		.site-footer ul li.current_page_item a,
		blockquote::before	
            { color:<?php echo esc_html( get_theme_mod('curtaini_pro_themecoloroption','#1bbde3')); ?>;}					 
            
        .pagination ul li .current, .pagination ul li a:hover, 
        #commentform input#submit:hover,		
        .nivo-controlNav a.active,
		.sd-search input, .sd-top-bar-nav .sd-search input,			
		a.blogreadmore,				
		a.servicesemore,		
		.copyrigh-wrapper:before,										
        #sidebar .search-form input.search-submit,				
        .wpcf7 input[type='submit'],				
        nav.pagination .page-numbers.current,		
		.morebutton,
		.orderonline:hover,	
		.nivo-directionNav a:hover,	
		.menu-toggle,		
		.footericons a:hover,
		.UnicareBX-25:hover a.UniMore:after			
            { background-color:<?php echo esc_html( get_theme_mod('curtaini_pro_themecoloroption','#1bbde3')); ?>;}
			
		
		.tagcloud a:hover,
		blockquote,
		#sidebar h3.widget-title:after,
		#sidebar h2:after
            { border-color:<?php echo esc_html( get_theme_mod('curtaini_pro_themecoloroption','#1bbde3')); ?>;}			
			
		#SiteWrapper a:focus,
		input[type="date"]:focus,
		input[type="search"]:focus,
		input[type="number"]:focus,
		input[type="tel"]:focus,
		input[type="button"]:focus,
		input[type="month"]:focus,
		button:focus,
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="range"]:focus,		
		input[type="password"]:focus,
		input[type="datetime"]:focus,
		input[type="week"]:focus,
		input[type="submit"]:focus,
		input[type="datetime-local"]:focus,		
		input[type="url"]:focus,
		input[type="time"]:focus,
		input[type="reset"]:focus,
		input[type="color"]:focus,
		textarea:focus
            { border:2px solid <?php echo esc_html( get_theme_mod('curtaini_pro_themecoloroption','#1bbde3')); ?>;}	
			
		
		.primary-navigation a,
		.primary-navigation ul li.current_page_parent ul.sub-menu li a,
		.primary-navigation ul li.current_page_parent ul.sub-menu li.current_page_item ul.sub-menu li a,
		.primary-navigation ul li.current-menu-ancestor ul.sub-menu li.current-menu-item ul.sub-menu li a  			
            { color:<?php echo esc_html( get_theme_mod('curtaini_pro_menucolor','#333333')); ?>;}	
			
		
		.primary-navigation ul.nav-menu .current_page_item > a,
		.primary-navigation ul.nav-menu .current-menu-item > a,
		.primary-navigation ul.nav-menu .current_page_ancestor > a,
		.primary-navigation ul.nav-menu .current-menu-ancestor > a, 
		.primary-navigation .nav-menu a:hover,
		.primary-navigation .nav-menu a:focus,
		.primary-navigation .nav-menu ul a:hover,
		.primary-navigation .nav-menu ul a:focus,
		.primary-navigation ul li a:hover, 
		.primary-navigation ul li.current-menu-item a,			
		.primary-navigation ul li.current_page_parent ul.sub-menu li.current-menu-item a,
		.primary-navigation ul li.current_page_parent ul.sub-menu li a:hover,
		.primary-navigation ul li.current-menu-item ul.sub-menu li a:hover,
		.primary-navigation ul li.current-menu-ancestor ul.sub-menu li.current-menu-item ul.sub-menu li a:hover 	 			
            { color:<?php echo esc_html( get_theme_mod('curtaini_pro_menuactive','#1bbde3')); ?>;}	
			
		.contactsection,
		.orderonline,
		.menu-toggle:hover,
		.menu-toggle:focus,
		.UnicareBX-25:hover,
		a.servicesemore:hover,
		.nivo-caption .slidermorebtn:hover
            { background-color:<?php echo esc_html( get_theme_mod('curtaini_pro_secondcolorcode','#46298f')); ?>;}
			
		.infobxfix a.appointbtn,
		.emergencybox::after,
		.emergencybox::before
            { background-color:<?php echo esc_html( get_theme_mod('curtaini_pro_appbtncolor','#6b54a5')); ?>;}								
							
	
    </style> 
<?php                                                                                                                                                                   
}
         
add_action('wp_head','curtaini_pro_custom_css');	 

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function curtaini_pro_customize_preview_js() {
	wp_enqueue_script( 'curtaini_pro_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '19062019', true );
}
add_action( 'customize_preview_init', 'curtaini_pro_customize_preview_js' );