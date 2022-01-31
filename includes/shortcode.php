<?php
namespace FAU\ORGA\Breadcrumb;

add_shortcode('fauorga', 'FAU\ORGA\Breadcrumb\show_breadcrumb'); 

function show_breadcrumb( $atts ) {
    global $post;
    global $fau_orga_breadcrumb_config;
    
    
    $shortcode_attr = shortcode_atts( array(
        'org'                   => '',
    ), $atts );
    

    $form_org = $shortcode_attr['org'];

    if (empty($form_org)) {
	
	$website_type = get_theme_mod("website_type");
       if (isset($website_type)) {
	   if (($website_type==-1) || ($website_type==3) || ($website_type==0)) {
	       return;
	       // No orga breadcrumb for these website types

	       /*
		*     0 => __('Fakultätsportal','fau'), 
		       1 => __('Department, Lehrstuhl, Einrichtung','fau'),  
		       2 => __('Zentrale Einrichtung','fau') ,
		       3 => __('Website für uniübergreifende Kooperationen mit Externen','fau') ,
		       -1 => __('Zentrales FAU-Portal www.fau.de','fau') 
		*/
	       
	   }		   
       }

	$options = get_option( 'fau_orga_breadcrumb_options' );
	if (isset($options['site-orga'])) {
	     $form_org = esc_attr($options['site-orga']);     
	} 
	if (empty($form_org)) {
	    // Es handelt sich um eine Website, die ein Lehrstuhl ist und einer Fakultät zugeordnet ist, 
	    // aber (noch) keinen Wert ausgewählt hat. Daher nehme als Oberpunkt die aktuelle Fakultät
	    $fau_orga_fautheme = get_fau_orga_fautheme();

	    if ($fau_orga_fautheme) {
		$faculty = $fau_orga_fautheme;
		$debug_website_fakultaet = get_theme_mod('debug_website_fakultaet');
		if (isset($debug_website_fakultaet)) {
		    $faculty = $debug_website_fakultaet;
		}
		// Suche nach der FAU ORG
		$form_org = get_fau_orga_fauorg_by_faculty($faculty);

	    }
	    
	}

    }
    
    if (isset( $form_org ) ) { 
        fau_orga_enqueue_style( 'fau-orga-breadcrumb');
	return get_fau_orga_breadcrumb($form_org);

    }
}



