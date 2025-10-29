<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * Settings: registers the admin settings page, settings section/field,
 * renders the form, and prints contextual help/preview.
 */
class Settings
{

    public function __construct()
    {
        // FAU Elemental no Settings Page
        if (OrgaService::isElementalTheme()) {
            return;
        }

        // Register admin page and settings on appropriate hooks
        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Add the options page under "Settings".
     */
    public function register_admin_menu(): void
    {
        add_options_page(
            __('FAU ORGA Breadcrumb', 'fau-orga-breadcrumb'), // page title
            __('FAU.ORG Breadcrumb', 'fau-orga-breadcrumb'),  // menu title
            'manage_options',                                 // capability
            'fau_orga_breadcrumb_settings',                   // menu slug
            [$this, 'render_options_page']                    // callback
        );
    }

    /**
     * Register setting, section and field for the breadcrumb options.
     */
    public function register_settings(): void
    {
        // Register a single options array: fau_orga_breadcrumb_options
        register_setting(
            'fau_orga_breadcrumb_options',   // settings group
            'fau_orga_breadcrumb_options'    // option name
        );

        // Section (printed above the field + help text)
        add_settings_section(
            'plugin_main',                                              // id
            __('FAU.ORG Breadcrumb Settings', 'fau-orga-breadcrumb'),   // title
            [$this, 'print_section_text'],                              // callback
            'fau_orga_textfield'                                        // page (slug used in do_settings_sections)
        );

        // Field: the organization selector
        add_settings_field(
            'fau_orga_site_orga',                       // id
            __('Institution', 'fau-orga-breadcrumb'),   // label (left column)
            [$this, 'render_site_orga_field'],          // callback (prints the field)
            'fau_orga_textfield',                       // page (same as section's page)
            'plugin_main'                               // section id
        );
    }

    /**
     * Render the HTML for the options page wrapper + form.
     */
    public function render_options_page(): void
    {
        // Standard WP options form: outputs nonce/fields and sections
?>
        <div class="wrap fau_orga_breadcrumb_optionpage">
            <h1><?php echo esc_html__('FAU ORGA Breadcrumb', 'fau-orga-breadcrumb'); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('fau_orga_breadcrumb_options');
                do_settings_sections('fau_orga_textfield');
                submit_button(__('Save', 'fau-orga-breadcrumb'));
                ?>
            </form>
        </div>
    <?php
    }

    /**
     * Field callback: renders the <select> for organizational assignment.
     *
     * Keeps the original logic for deciding when to show the "None" option
     * based on legacy website_type and Elemental keys.
     */
    public function render_site_orga_field(): void
    {
        // Pull current selection from options array
        $options = get_option('fau_orga_breadcrumb_options');
        $orga    = isset($options['site-orga']) ? esc_attr($options['site-orga']) : '0000000000';

        // Read legacy and Elemental theme mods
        $legacy_type = get_theme_mod('website_type', null); // int|null
        $faue_type   = get_theme_mod('faue_website_type', ''); // string|'' (chair|faculty|central|other|…)
        $faue_fac    = (string) get_theme_mod('faue_faculty', ''); // faculty for 'other'

        // Decide whether the "None" (Keine) option should be shown
        // Legacy: show when website_type != 1
        // Elemental: hide for 'chair' or ('other' + faculty set); show otherwise
        $show_none = true;
        if ($faue_type !== '') {
            $t = strtolower((string) $faue_type);
            if ($t === 'chair' || ($t === 'other' && $faue_fac !== '')) {
                $show_none = false;
            } else {
                $show_none = true; // faculty/central/other(no faculty)
            }
        } else {
            // Legacy path (numeric)
            $show_none = (isset($legacy_type) && (int) $legacy_type !== 1);
        }

        // Normalize root id (your original code mixed 9×0 and 10×0)
        $root = OrgaService::ROOT_ID;

        // Build <option> list using your existing helper that returns HTML
        $optionlist = '';
        if ($show_none) {
            $optionlist .= '<option value="">' . esc_html__('None (No faculty assignment or central unit)', 'fau-orga-breadcrumb') . '</option>';
        }

        // Append the org structure (expects HTML with <option>/<optgroup>)
        // NOTE: Ensure this function exists and outputs trusted HTML.
        $optionlist .= OrgaService::buildOptionList($root, $orga ?: $root, 0);

        // This is only used for a debug comment; guard against missing function
        $fau_orga_fautheme = (string) OrgaService::getLegacyFauThemeFaculty();

        // Print the select (size unchanged from original)
    ?>
        <select size="10"
            id="fau_orga_breadcrumb_options[site-orga]"
            name="fau_orga_breadcrumb_options[site-orga]">
            <?php
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $optionlist;
            ?>
        </select>
        <!-- legacy type: <?php echo esc_html((string) $legacy_type); ?> / faue type: <?php echo esc_html((string) $faue_type); ?> faculty: <?php echo esc_html((string) $fau_orga_fautheme); ?> -->
<?php
    }

    /**
     * Section text: prints explanatory notes below the field and a live preview.
     */
    public function print_section_text(): void
    {
        // Intro/help text
        echo '<p>' . wp_kses_post(
            __('Organizational Assignment: Please select the <strong>next higher</strong> organizational unit to which the website can be assigned.', 'fau-orga-breadcrumb')
        ) . '</p>';

        // Website type notices (legacy numeric)
        $website_type = get_theme_mod('website_type');

        if ($website_type !== null && $website_type !== '') {
            if ((int) $website_type === 0) {
                echo '<div class="notice notice-warning is-dismissible"><p>' .
                    esc_html__('Warning: The website has been defined in the Customizer as a faculty portal. Therefore, subunits of the faculty are not available for selection. The Orga Breadcrumb will not be displayed.', 'fau-orga-breadcrumb') .
                    '</p></div>';
            } elseif ((int) $website_type === 1) {
                echo '<div class="notice notice-info is-dismissible"><p>' .
                    esc_html__('The website has been defined in the Customizer as a faculty subunit. Therefore, only central units and subunits of the faculty are available for selection.', 'fau-orga-breadcrumb') .
                    '</p></div>';
            } elseif ((int) $website_type === 2) {
                echo '<div class="notice notice-info is-dismissible"><p>' .
                    esc_html__('The website has been defined in the Customizer as a central unit. Therefore, only central units are available for selection.', 'fau-orga-breadcrumb') .
                    '</p></div>';
            } elseif ((int) $website_type === 3) {
                echo '<div class="notice notice-warning is-dismissible"><p>' .
                    esc_html__('Warning: The website has been defined in the Customizer as a cooperation. The Orga Breadcrumb will not be displayed.', 'fau-orga-breadcrumb') .
                    '</p></div>';
            } elseif ((int) $website_type === -1) {
                echo '<div class="notice notice-warning is-dismissible"><p>' .
                    esc_html__('Warning: The website has been defined as the central FAU portal. The Orga Breadcrumb will not be displayed.', 'fau-orga-breadcrumb') .
                    '</p></div>';
            }
        }

        // Preview currently selected orga (uses global data + helper)
        $options = get_option('fau_orga_breadcrumb_options');
        if (!empty($options['site-orga'])) {
            $orga = esc_attr($options['site-orga']);

            // Expecting global data array filled elsewhere in your plugin/theme.
            global $fau_orga_breadcrumb_data;

            if (isset($fau_orga_breadcrumb_data[$orga]['title'])) {
                echo '<p><strong>' . esc_html__('Currently selected', 'fau-orga-breadcrumb') . ':</strong> <em>' .
                    esc_html($fau_orga_breadcrumb_data[$orga]['title']) .
                    '</em></p>';
            }

            // Breadcrumb preview
            echo '<div class="fau_org_breadcrumb_preview">';
            echo '<strong>' . esc_html__('Breadcrumb', 'fau-orga-breadcrumb') . ': &nbsp; &nbsp; &nbsp; </strong>';
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo (string) OrgaService::breadcrumb($orga);
            echo '</div>';
        }
    }
}
