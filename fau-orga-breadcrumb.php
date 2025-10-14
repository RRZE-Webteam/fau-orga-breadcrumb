<?php

/*
Plugin Name:        FAU ORGA Breadcrumb
Plugin URI:         https://github.com/RRZE-Webteam/fau-orga-breadcrumb
Version:            1.2.0
Description:        Displays an organisational breadcrumb
Author:             RRZE Webteam
Author URI:         https://www.wp.rrze.fau.de/
License:            GNU General Public License Version 3
License URI:        https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:        fau-orga-breadcrumb
Domain Path:        /languages
Requires at least:  6.8
Requires PHP:       8.2
*/

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

define('FAU_ORGA_BREADCRUMB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FAU_ORGA_BREADCRUMB_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * SPL Autoloader (PSR-4).
 * 
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {
    $prefix = __NAMESPACE__;
    $baseDir = __DIR__ . '/includes/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Register the AJAX handler for Customizer updating
require_once __DIR__ . '/includes/Ajax.php';
\FAU\ORGA\Breadcrumb\Ajax::register();

// Register activation hook for the plugin
register_activation_hook(__FILE__, __NAMESPACE__ . '\activation');

// Register deactivation hook for the plugin
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\deactivation');

/**
 * Add an action hook for the 'plugins_loaded' hook.
 * This code hooks into the 'plugins_loaded' action hook to execute a callback function when
 * WordPress has fully loaded all active plugins and the theme's functions.php file.
 */
add_action('plugins_loaded', __NAMESPACE__ . '\loaded');

/**
 * Activation callback function.
 * 
 * @return void
 */
function activation()
{
    // No special actions are required upon activation.
}

/**
 * Deactivation callback function.
 * 
 * @return void
 */
function deactivation()
{
    // No special actions are required upon deactivation.
}

/**
 * Instantiate Plugin class.
 * 
 * @return object Plugin
 */
function plugin()
{
    static $instance;
    if (null === $instance) {
        $instance = new Plugin(__FILE__);
    }
    return $instance;
}

/**
 * Callback function to load the plugin textdomain.
 * 
 * @return void
 */
function loadTextdomain()
{
    load_plugin_textdomain(
        'fau-orga-breadcrumb',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
}

/**
 * Check system requirements for the plugin.
 *
 * This method checks if the server environment meets the minimum WordPress and PHP version requirements
 * for the plugin to function properly.
 *
 * @return string An error message string if requirements are not met, or an empty string if requirements are satisfied.
 */
function systemRequirements(): string
{
    // Initialize an error message string.
    $error = '';

    // Check if the WordPress version is compatible with the plugin's requirement.
    if (!is_wp_version_compatible(plugin()->getRequiresWP())) {
        $error = sprintf(
            /* translators: 1: Server WordPress version number, 2: Required WordPress version number. */
            __('The server is running WordPress version %1$s. The plugin requires at least WordPress version %2$s.', 'fau-orga-breadcrumb'),
            wp_get_wp_version(),
            plugin()->getRequiresWP()
        );
    } elseif (!is_php_version_compatible(plugin()->getRequiresPHP())) {
        // Check if the PHP version is compatible with the plugin's requirement.
        $error = sprintf(
            /* translators: 1: Server PHP version number, 2: Required PHP version number. */
            __('The server is running PHP version %1$s. The plugin requires at least PHP version %2$s.', 'fau-orga-breadcrumb'),
            phpversion(),
            plugin()->getRequiresPHP()
        );
    }

    // Return the error message string, which will be empty if requirements are satisfied.
    return $error;
}

/**
 * Handle the loading of the plugin.
 *
 * This function is responsible for initializing the plugin, loading text domains for localization,
 * checking system requirements, and displaying error notices if necessary.
 */
function loaded()
{
    // Load the plugin text domain for translations.
    loadTextDomain();

    // Trigger the 'loaded' method of the main plugin instance.
    plugin()->loaded();

    // Check system requirements and store any error messages.
    if ($error = systemRequirements()) {
        // If there is an error, add an action to display an admin notice with the error message.
        add_action('admin_init', function () use ($error) {
            // Check if the current user has the capability to activate plugins.
            if (current_user_can('activate_plugins')) {
                // Get plugin data to retrieve the plugin's name.
                $pluginName = plugin()->getName();

                // Determine the admin notice tag based on network-wide activation.
                $tag = is_plugin_active_for_network(plugin()->getBaseName()) ? 'network_admin_notices' : 'admin_notices';

                // Add an action to display the admin notice.
                add_action($tag, function () use ($pluginName, $error) {
                    printf(
                        '<div class="notice notice-error"><p>' .
                            /* translators: 1: The plugin name, 2: The error string. */
                            esc_html__('Plugins: %1$s: %2$s', 'fau-orga-breadcrumb') .
                            '</p></div>',
                        $pluginName,
                        $error
                    );
                });
            }
        });

        // Return to prevent further initialization if there is an error.
        return;
    }

    // If there are no errors, create an instance of the 'Main' class and trigger its 'loaded' method.
    new Main();
}



// Removing the FAU Elemental Theme Modal Breadcrumbs
add_action('wp_footer', function() {
    ?>
    <script>
        function removeThemeModalBreadcrumbs() {
            document.querySelectorAll('.menu-meta-nav__modal__content .menu-modal__breadcrumbs').forEach(function(bc) {
                bc.parentNode.removeChild(bc);
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            removeThemeModalBreadcrumbs();
            var observer = new MutationObserver(function() {
                removeThemeModalBreadcrumbs();
            });
            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>
    <?php
});