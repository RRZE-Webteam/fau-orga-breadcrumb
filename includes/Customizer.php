<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * Bootstrap class to register Customizer settings & controls
 * for the "Organizational assignment" dropdown.
 *
 * Uses the native `select` control with an array of choices.
 */
class Customizer
{
    public function __construct()
    {
        // Hook into the Customizer
        add_action('customize_register', [$this, 'register']);

        // Hook into save action to sanitize (only for FAU-Elemental or child)
        add_action('customize_save_after', [$this, 'saveAfter']);
        // ENQUEUE-Hook
        add_action('customize_controls_enqueue_scripts', [$this, 'enqueueCustomizerScript']);
    }

    /**
     * Register the setting and control with the Customizer.
     *
     * @param \WP_Customize_Manager $wp_customize
     * @return void
     */
    public function register(\WP_Customize_Manager $wp_customize): void
    {
        $is_elemental = OrgaService::isElementalTheme();

        $section = 'title_tagline';

        $website_type = $is_elemental ? (string)get_theme_mod('faue_website_type', '') : (string)get_theme_mod('website_type', '');
        $options = get_option('fau_orga_breadcrumb_options');
        $orga = isset($options['site-orga']) ? sanitize_text_field($options['site-orga']) : '';

        if ($is_elemental) {
            $faculty = OrgaService::elementalFaculty();
            $optionlist = OrgaService::buildOptionList('0000000000', $orga, 0, 4, $website_type, $faculty);
            $choices = $optionlist;
        } else {
            $faculty = OrgaService::getLegacyFauThemeFaculty();
            $optionlist = '';
            $website_type = get_theme_mod('website_type');
            if (isset($website_type) && (int)$website_type !== 1) {
                $optionlist .= '<option value="">' . __('None (no faculty assignment or central unit)', 'fau-orga-breadcrumb') . '</option>';
            }
            $optionlist .= OrgaService::buildOptionList('0000000000', $orga, 0, 4, $website_type, $faculty);
            $choices = $optionlist;
        }

        $wp_customize->add_setting('fau_orga_breadcrumb_options[site-orga]', [
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => [$this, 'sanitize_orga_id'],
        ]);

        $wp_customize->add_control(new \FAU\ORGA\Breadcrumb\CustomizeControlSelect(
            $wp_customize,
            'fau_orga_site-orga',
            [
                'settings' => 'fau_orga_breadcrumb_options[site-orga]',
                'label' => esc_html__('Organizational Breadcrumb', 'fau-orga-breadcrumb'),
                'description' => esc_html__('Select the organizational unit to which your institution or website belongs.', 'fau-orga-breadcrumb'),
                'section' => $section,
                'type' => 'select',
                'transport' => 'refresh',
                'choices' => $choices,
                'priority' => 11,
                // Callback matches theme
                'active_callback' => function () use ($is_elemental) {
                    if ($is_elemental) {
                        $t = (string)get_theme_mod('faue_website_type', '');
                        return !in_array($t, ['fau', 'cooperation'], true);
                    } else {
                        $t = (int)get_theme_mod('website_type', -999);
                        return !in_array($t, [-1, 3], true);
                    }
                },
            ]
        ));
    }


    /**
     * After the Customizer settings have been saved, update the plugin option
     * to reflect the current theme context (only for FAU-Elemental or child).
     *
     * @param \WP_Customize_Manager $manager
     * @return void
     */
    public function saveAfter(\WP_Customize_Manager $manager): void
    {
        // Only run for Elemental themes
        if (!OrgaService::isElementalTheme()) {
            return;
        }

        // Read freshly saved values directly from the Customizer post values (with fallback)
        $type = (string)($manager->post_value('faue_website_type') ?? get_theme_mod('faue_website_type', ''));
        $faculty = (string)($manager->post_value('faue_faculty') ?? get_theme_mod('faue_faculty', ''));

        // Load current plugin option
        $options = get_option('fau_orga_breadcrumb_options', []);
        $options = is_array($options) ? $options : [];
        $currentOrg = isset($options['site-orga']) ? (string)$options['site-orga'] : '';

        // For FAU root or cooperation → clear assignment
        if ($type === 'fau' || $type === 'cooperation') {
            if ($currentOrg !== '') {
                $options['site-orga'] = '';
                update_option('fau_orga_breadcrumb_options', $options);
            }
            return;
        }


    }

    /**
     * Sanitize the orga ID.
     * Adjust this method to your real ID format.
     */
    public function sanitize_orga_id($value): string
    {
        $value = (string)$value;
        // Example: only digits, max length 10
        $value = preg_replace('/\D+/', '', $value);
        return substr($value, 0, 10);
    }

    /**
     * Loads the JavaScript for the WordPress Customiser and passes
     *  necessary configuration data to the script.
     *
     */
    public function enqueueCustomizerScript()
    {
        if (!OrgaService::isElementalTheme()) {
            return;
        }

        wp_enqueue_script(
            'fau-orga-customizer',
            FAU_ORGA_BREADCRUMB_PLUGIN_URL . 'build/customizer-orga-sync.js',
            ['jquery', 'customize-controls'],
            plugin()->getVersion(),
            true
        );
        wp_localize_script('fau-orga-customizer', 'FAU_ORGA_BREADCRUMB', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('fau_orga_refresh'),
            'controlId' => 'fau_orga_site-orga',
        ]);
    }

}



