<?php

/*
Plugin Name:        FAU ORGA Breadcrumb
Plugin URI:         https://github.com/RRZE-Webteam/fau-orga-breadcrumb
Version:            1.2.1
Description:        Displays an organizational breadcrumb
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

/**
 * Registers uninstall Hook
 *
 */

register_uninstall_hook(__FILE__, __NAMESPACE__ . '\uninstall');

/**
 * Add an action hook for the 'plugins_loaded' hook.
 *
 */
add_action('plugins_loaded', __NAMESPACE__ . '\loaded');


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


/**
 * Enqueue front-end script that removes duplicate Elemental modal breadcrumbs.
 *
 * @return void
 */
function enqueueModalCleanupScript(): void
{
    if (!OrgaService::isElementalTheme()) {
        return;
    }

    $assetPath = FAU_ORGA_BREADCRUMB_PLUGIN_DIR . 'build/modal-cleanup.asset.php';
    $asset = file_exists($assetPath) ? include $assetPath : [
        'dependencies' => [],
        'version' => plugin()->getVersion(),
    ];

    wp_enqueue_script(
        'fau-orga-breadcrumb-modal-cleanup',
        FAU_ORGA_BREADCRUMB_PLUGIN_URL . 'build/modal-cleanup.js',
        $asset['dependencies'],
        $asset['version'],
        true
    );
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\enqueueModalCleanupScript');

function uninstall(): void
{
    delete_option('fau_orga_breadcrumb_options');
}
