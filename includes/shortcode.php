<?php
namespace FAU\ORGA\Breadcrumb;

add_shortcode('fauorga', 'FAU\ORGA\Breadcrumb\show_breadcrumb'); 

function show_breadcrumb( $atts ) {
    global $post;
    
    $shortcode_attr = shortcode_atts( array(
        'org'                   => '',
    ), $atts );
    
    $org = $shortcode_attr['org'];
  
    if( !empty( $org ) ) { 
        wp_enqueue_style( 'fau-orga-breadcrumb');
        ob_start();
        include( plugin_dir_path( __DIR__ ) . 'templates/shortcode-template.php');
        return ob_get_clean();
    }
}



