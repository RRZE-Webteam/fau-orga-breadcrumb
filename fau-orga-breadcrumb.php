<?php

/**
 * Plugin Name: FAU ORGA Breadcrumb
 * Plugin URI:  https://github.com/RRZE-Webteam/fau-orga-breadcrumb
 * Description: Displays an organisational breadcrumb
 * Version:     1.1.19
 * Author:      RRZE-Webteam
 * Author URI:  http://blogs.fau.de/webworking/
 * License:     GNU GPLv2
 * License URI: https://gnu.org/licenses/gpl.html
 * Text Domain: fau-orga-breadcrumb
 */

/* This plugin is free software: you can redistribute it and/or modify
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

const RRZE_PHP_VERSION = '7.4';
const RRZE_WP_VERSION = '5.8';
load_textdomain();// funktioniert aktuell nicht anders???
require_once __DIR__ . '/constants.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/compat-global.php';

add_action('plugins_loaded', 'FAU\ORGA\Breadcrumb\init');
register_activation_hook(__FILE__, __NAMESPACE__ . '\activation');


/*-----------------------------------------------------------------------------------*/
/* Init
/*-----------------------------------------------------------------------------------*/
/**
 * Initialisiert Plugin-Funktionalität.
 */
function init(): void
{

    global $fau_orga_fautheme;
    if ($fau_orga_fautheme) {
        require_once __DIR__ . '/includes/shortcode.php';
        require_once __DIR__ . '/includes/menu-elemental.php';
        require_once __DIR__ . '/includes/settings.php';

        add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\register_styles');
        add_action('customize_register', __NAMESPACE__ . '\\fau_orga_customizer_settings');
        add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\fau_orga_enqueue_admin_script');
    }
}


/*-----------------------------------------------------------------------------------*/
/* Textdomain
/*-----------------------------------------------------------------------------------*/
/**
 * Lädt Sprachdateien.
 */
function load_textdomain(): void
{
    load_plugin_textdomain(
        'fau-orga-breadcrumb',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
}


// -----------------------------------------------------------------------------
// Aktivierung
// -----------------------------------------------------------------------------
/**
 * Wird bei Aktivierung des Plugins ausgeführt.
 */
function activation(): void
{
    system_requirements();
}

/*-----------------------------------------------------------------------------------*/
/* Anforderungen
/*-----------------------------------------------------------------------------------*/
/**
 * Prüft Systemanforderungen (PHP, WP, Theme).
 */
function system_requirements(): void
{
    $errors = [];

    if (version_compare(PHP_VERSION, RRZE_PHP_VERSION, '<')) { // Saubere Versionsprüfung.
        $errors[] = sprintf(
        /* translators: 1: current PHP version, 2: required PHP version */
            __('Your server is running PHP version %1$s. Please upgrade at least to PHP version %2$s.', 'fau-orga-breadcrumb'),
            PHP_VERSION,
            RRZE_PHP_VERSION
        );
    }

    if (isset($GLOBALS['wp_version']) && version_compare($GLOBALS['wp_version'], RRZE_WP_VERSION, '<')) {
        $errors[] = sprintf(
        /* translators: 1: current WP version, 2: required WP version */
            __('Your WordPress version is %1$s. Please upgrade at least to WordPress version %2$s.', 'fau-orga-breadcrumb'),
            $GLOBALS['wp_version'],
            RRZE_WP_VERSION
        );
    }

    global $fau_orga_fautheme; // Hinweis für falsches Theme – kein harter Fehler, aber hier als Blocker gewertet.
    if ($fau_orga_fautheme === false) {
        $errors[] = __('This plugin is intended for FAU themes only.', 'fau-orga-breadcrumb');
    }

}


/*-----------------------------------------------------------------------------------*/
/* Styles
/*-----------------------------------------------------------------------------------*/
/**
 * Registriert Frontend-Styles.
 */
function register_styles(): void
{
    wp_register_style(
        'fau-orga-breadcrumb',
        plugin_dir_url(__FILE__) . 'css/fau-orga-breadcrumb.css',
        [],
        FAU_ORGA_BREADCRUMB_VERSION
    );
}

/*-----------------------------------------------------------------------------------*/
/* Admin Styles
/*-----------------------------------------------------------------------------------*/
/**
 * Registriert & lädt Admin-Styles.
 */
function fau_orga_enqueue_admin_script(string $hook = ''): void
{
    wp_register_style(
        'fau-orga-breadcrumb-admin',
        plugin_dir_url(__FILE__) . 'css/fau-orga-breadcrumb-admin.css',
        [],
        FAU_ORGA_BREADCRUMB_VERSION
    );
    wp_enqueue_style('fau-orga-breadcrumb-admin');
}

