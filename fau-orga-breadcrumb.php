<?php

/*
Plugin Name: FAU ORGA Breadcrumb
Plugin URI: https://github.com/RRZE-Webteam/fau-orga-breadcrumb
Description: Displays an organisational breadcrumb
Version: 1.0.6
Author: RRZE-Webteam
Author URI: http://blogs.fau.de/webworking/
License: GNU GPLv2
License URI: https://gnu.org/licenses/gpl.html
Text Domain: fau-orga-breadcrumb

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this plugin. If not, see https://gnu.org/licenses/gpl.html 
*/



namespace FAU\ORGA\Breadcrumb;

const RRZE_PHP_VERSION = '7.0';
const RRZE_WP_VERSION = '4.7';

include('constants.php');
        // get all constants

include('includes/functions.php');
        // Global functions

add_action('plugins_loaded', 'FAU\ORGA\Breadcrumb\init');
register_activation_hook(__FILE__, 'FAU\ORGA\Breadcrumb\activation');

/*-----------------------------------------------------------------------------------*/
/* Init
/*-----------------------------------------------------------------------------------*/
function init() {
    textdomain();


 
    include_once('includes/shortcode.php');
        // define shortcodes
    include_once('includes/widget.php');
        // define widgets
    include_once('help/tabmenu.php');
        // set helper menu
    include_once('includes/settings.php');
    
    add_action( 'wp_enqueue_scripts', 'FAU\ORGA\Breadcrumb\custom_libraries_scripts');
}
/*-----------------------------------------------------------------------------------*/
/* Load textdomain
/*-----------------------------------------------------------------------------------*/
function textdomain() {
    load_plugin_textdomain('fau-orga-breadcrumb', FALSE, sprintf('%s/languages/', dirname(plugin_basename(__FILE__))));
}
/*-----------------------------------------------------------------------------------*/
/* On plugin activation
/*-----------------------------------------------------------------------------------*/
function activation() {
    textdomain();
    system_requirements();
    
}
/*-----------------------------------------------------------------------------------*/
/* Check requirements
/*-----------------------------------------------------------------------------------*/
function system_requirements() {
    $error = '';

    if (version_compare(PHP_VERSION, RRZE_PHP_VERSION, '<')) {
        $error = sprintf(__('Your server is running PHP version %s. Please upgrade at least to PHP version %s.', 'rrze-test'), PHP_VERSION, RRZE_PHP_VERSION);
    }

    if (version_compare($GLOBALS['wp_version'], RRZE_WP_VERSION, '<')) {
        $error = sprintf(__('Your Wordpress version is %s. Please upgrade at least to Wordpress version %s.', 'rrze-test'), $GLOBALS['wp_version'], RRZE_WP_VERSION);
    }

    // Wenn die Überprüfung fehlschlägt, dann wird das Plugin automatisch deaktiviert.
    if (!empty($error)) {
        deactivate_plugins(plugin_basename(__FILE__), FALSE, TRUE);
        wp_die($error);
    }
}
/*-----------------------------------------------------------------------------------*/
/* Register styles and scripts
/*-----------------------------------------------------------------------------------*/
function custom_libraries_scripts() { 
    global $post;
     
    wp_register_style( 'fau-orga-breadcrumb', plugins_url( 'fau-orga-breadcrumb/css/fau-orga-breadcrumb.css', dirname(__FILE__) ) );    
}
/*-----------------------------------------------------------------------------------*/
/*EOF
/*-----------------------------------------------------------------------------------*/