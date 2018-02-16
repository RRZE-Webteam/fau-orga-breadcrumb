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
	$options = get_option( 'fau_orga_breadcrumb_options' );
	if (isset($options['site-orga'])) {
	     $form_org = esc_attr($options['site-orga']);     
	}
    
    }

    if(isset( $form_org ) ) { 
        wp_enqueue_style( 'fau-orga-breadcrumb');
        ob_start();
        include( plugin_dir_path( __DIR__ ) . 'templates/shortcode-template.php');
        return ob_get_clean();
    }
}



