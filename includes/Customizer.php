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
    }

    /**
     * Register the setting and control with the Customizer.
     *
     * @param \WP_Customize_Manager $wp_customize
     * @return void
     */
    public function register(\WP_Customize_Manager $wp_customize): void
    {
        global $fau_orga_fautheme;

        // Only run inside FAU ORGA context
        if ($fau_orga_fautheme === false) {
            return;
        }

        // Default section where the control should appear
        $section = 'title_tagline';

        // Detect current theme and check for FAU Elemental
        $theme = wp_get_theme();
        $is_elemental = false;

        if ($theme) {
            $name       = (string) $theme->get('Name');
            $template   = strtolower((string) $theme->get_template());
            $stylesheet = strtolower((string) $theme->get_stylesheet());

            $is_elemental =
                (stripos($name, 'elemental') !== false)
                || in_array($template, ['fau-elemental', 'fauelemental'], true)
                || in_array($stylesheet, ['fau-elemental', 'fauelemental'], true);

            // In Elemental themes, use a custom section
            if ($is_elemental) {
                $section = 'faue_theme_settings';
            }
        }

        // Website type key differs depending on the theme
        $website_type_key = $is_elemental ? 'faue_website_type' : 'website_type';
        $website_type     = get_theme_mod($website_type_key);

        // Do not show breadcrumb control for central portals / cooperations
        if (isset($website_type) && ($website_type == -1 || $website_type == 3)) {
            return;
        }

        // Current option value
        $options = get_option('fau_orga_breadcrumb_options');
        $orga    = isset($options['site-orga']) ? sanitize_text_field($options['site-orga']) : '';

        $optionlist = '';
        if (isset($website_type) && ($website_type <> 1)) {

            $optionlist .= '<option value="">' . __('None (no faculty assignment or central unit)', 'fau-orga-breadcrumb') . '</option>';
        }
        $optionlist .= OrgaService::buildOptionList(OrgaService::ROOT_ID, $orga);

        // Register setting (stored in options table)
        $wp_customize->add_setting('fau_orga_breadcrumb_options[site-orga]', [
            'default'           => '',
            'capability'        => 'edit_theme_options',
            'type'              => 'option',
            'sanitize_callback' => [$this, 'sanitize_orga_id'],
        ]);

        // Register the control (native select)
        $wp_customize->add_control(new CustomizeControlSelect($wp_customize, 'fau_orga_site-orga', [
            'settings'      => 'fau_orga_breadcrumb_options[site-orga]',
            'label'         => esc_html__('Organizational Assignment', 'fau-orga-breadcrumb'),
            'description'   => esc_html__('Select the organizational unit to which your institution or website belongs.', 'fau-orga-breadcrumb'),
            'section'       => 'title_tagline',
            'type'          => 'select',
            'choices'       => $optionlist,
            'priority'      => 11,
            // Optional: hide dynamically when website_type is disallowed
            'active_callback' => function () use ($website_type) {
                return ! (isset($website_type) && ($website_type == -1 || $website_type == 3));
            },
        ]));
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
        $type    = (string) ($manager->post_value('faue_website_type') ?? get_theme_mod('faue_website_type', ''));
        $faculty = (string) ($manager->post_value('faue_faculty') ?? get_theme_mod('faue_faculty', ''));

        // Load current plugin option
        $options    = get_option('fau_orga_breadcrumb_options', []);
        $options    = is_array($options) ? $options : [];
        $currentOrg = isset($options['site-orga']) ? (string) $options['site-orga'] : '';

        // For FAU root or cooperation → clear assignment
        if ($type === 'fau' || $type === 'cooperation') {
            if ($currentOrg !== '') {
                $options['site-orga'] = '';
                update_option('fau_orga_breadcrumb_options', $options);
            }
            return;
        }

        // Faculty context → map faculty slug to FAU.ORG ID and store
        $isFacultyContext = in_array($type, ['faculty', 'chair'], true) || ($type === 'other' && $faculty !== '');
        if ($isFacultyContext) {
            $newOrg = $faculty !== '' ? OrgaService::getOrgaByFaculty($faculty) : '';
            if ($newOrg !== '' && $newOrg !== $currentOrg) {
                $options['site-orga'] = $newOrg;
                update_option('fau_orga_breadcrumb_options', $options);
            }
        }
    }

    /**
     * Sanitize the orga ID.
     * Adjust this method to your real ID format.
     */
    public function sanitize_orga_id($value): string
    {
        $value = (string) $value;
        // Example: only digits, max length 10
        $value = preg_replace('/\D+/', '', $value);
        return substr($value, 0, 10);
    }
}
