<?php

namespace FAU\ORGA\Breadcrumb;

add_action( "load-plugins.php", 'FAU\ORGA\Breadcrumb\plugin_help_tab' , 20 );

function plugin_help_tab () {
    $current_screen = get_current_screen();
    
    if( $current_screen->id === "plugins" ) {

    $current_screen->add_help_tab( array(
        'id'            => 'fau_orga_breadcrumb_plugin_help',
        'title'         => __(' FAU Orga Breadcrumb'),
        'content'	=> '<h3>' . __( 'FAU Orga Breadcrumb', 'rrze-video' ) . '</h3>'      
                           .'<p>' . __( 'Dieses Plugin erstellt eine organisatorische Breadcrumb für Einrichtungen 
der Friedrich-Alexaner-Universität Erlangen-Nürnberg (FAU). Die Konfiguration erfolgt über den WordPress Customizer.', 'rrze-video' ) . '</p>' 
        ) );
    }
}