<?php

namespace FAU\ORGA\Breadcrumb;

use Dom\Element;

defined('ABSPATH') || exit;

class Main
{
    public function __construct()
    {
        require_once 'functions.php';
        require_once 'legacy-shim-global.php';

        // Load FAU ORGA data
        $orgaData = Data::read('fau-orga');
        OrgaService::setData($orgaData);

        // Load FAU Elemental ORGA data
        $elementalData = Data::read('fau-elemental-orga');
        ElementalMenu::setData($elementalData);

        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        add_action('admin_notices', [$this, 'fau_orga_admin_notice']);

        if (is_admin()) {
            new \FAU\ORGA\Breadcrumb\Settings();
        }

        new Customizer();

        add_filter('plugin_action_links_' . plugin()->getBaseName(), [$this, 'settingsLink']);

        add_action('init', static function () {
            new \FAU\ORGA\Breadcrumb\Shortcode();
        });
    }

    /**
     * Shows an admin notice on the Dashboard if no org assignment has been set yet.
     *
     * @return void
     */
    public function fau_orga_admin_notice()
    {
        global $pagenow;
        //    global $fau_orga_fautheme;

        $website_type = get_theme_mod("website_type");

        // Do not show for central portals, cooperations, and faculty portals
        if (isset($website_type)) {
            if (($website_type == -1) || ($website_type == 3) || ($website_type == 0)) {
                return;
            }
        }
        $form_org = '';
        $options = get_option('fau_orga_breadcrumb_options');
        if (isset($options['site-orga'])) {
            $form_org = esc_attr($options['site-orga']);
        }
        // If we are in an FAU theme
        // AND the website type = 1 (faculty subunit) 
        // AND no assignment has been made yet,
        // then show the notice asking to set an assignment

        if (empty($form_org)) {
            if ($pagenow == 'index.php') {
                $user = wp_get_current_user();
                if (in_array('administrator', (array)$user->roles)) {
                    echo '<div class="notice notice-warning">';
                    printf(
                        /* translators: 1: Line break, 2: Link start tag, 3: Link end tag. */
                        esc_html__('The website has not yet been organizationally assigned. %1$sPlease go to the %2$sFAU.ORG Breadcrumb settings%3$s and specify which organizational unit the website belongs to.', 'fau-orga-breadcrumb'),
                        '<br>',
                        '<a href="' . admin_url('options-general.php?page=fau_orga_breadcrumb_settings') . '">',
                        '</a>'
                    );
                    echo '</div>';
                }
            }
        }
    }

    /**
     * Add the settings link to the list of plugins.
     * 
     * @param array $links
     * @return array
     */
    public function settingsLink($links)
    {
        $settingsLink = sprintf(
            '<a href="%s">%s</a>',
            admin_url('options-general.php?page=fau_orga_breadcrumb_settings'),
            __('Settings', 'fau-orga-breadcrumb')
        );
        array_unshift($links, $settingsLink);
        return $links;
    }

    public function enqueueAdminScripts()
    {
        wp_enqueue_style(
            'fau-orga-breadcrumb-admin',
            plugins_url('build/admin.css', plugin()->getBasename()),
            [],
            plugin()->getVersion()
        );
    }
}
