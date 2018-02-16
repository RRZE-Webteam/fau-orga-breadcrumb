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
  echo "ORG: ".$form_org;
    if(isset( $form_org ) ) { 
        wp_enqueue_style( 'fau-orga-breadcrumb');
        ob_start();
        include( plugin_dir_path( __DIR__ ) . 'templates/shortcode-template.php');
        return ob_get_clean();
    }
}



