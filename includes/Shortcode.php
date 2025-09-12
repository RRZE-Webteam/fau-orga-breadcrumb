<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * Registers and renders the [fauorga] shortcode.
 *
 * Usage:
 *   [fauorga]                      -> prints breadcrumb based on settings/theme
 *   [fauorga org="0000000001"]     -> prints breadcrumb for a specific org
 *   [fauorga show="menu"]          -> prints the hard-coded Elemental menu
 */
class Shortcode
{
    /**
     * Shortcode tag.
     */
    private const TAG = 'fauorga';

    public function __construct()
    {
        add_shortcode(self::TAG, [$this, 'render']);
    }

    /**
     * Shortcode callback.
     *
     * @param array<string,mixed> $atts
     * @return string|null HTML output or null to print nothing
     */
    public function render($atts)
    {
        // Merge shortcode attributes with defaults
        $atts = shortcode_atts(
            [
                'org'  => '',
                'show' => 'breadcrumb',
            ],
            (array) $atts,
            self::TAG
        );

        $form_org  = (string) $atts['org'];
        $show_type = (string) $atts['show'];

        // If show="menu", output the hard-coded Elemental menu HTML
        if (strtolower($show_type) === 'menu') {
            return (string) ElementalMenu::fromGlobal()->renderContentHtml();
        }

        // Resolve org if not explicitly provided
        if ($form_org === '') {

            // For certain website types, do not display orga breadcrumb at all
            $website_type = get_theme_mod('website_type');
            if (isset($website_type)) {
                //  -1: Central FAU portal
                //   0: Faculty portal
                //   3: Cross-university cooperation
                if ((int) $website_type === -1 || (int) $website_type === 0 || (int) $website_type === 3) {
                    return null; // print nothing
                }
            }

            // Try plugin option
            $options = get_option('fau_orga_breadcrumb_options');
            if (is_array($options) && !empty($options['site-orga'])) {
                $form_org = sanitize_text_field($options['site-orga']);
            }

            // Fallback: infer from theme if still empty
            if ($form_org === '') {
                $form_org = (string) OrgaService::orgByTheme();
            }
        }

        // Finally, render the breadcrumb for the resolved org
        if ($form_org !== '') {
            // Enqueue styles if available
            OrgaService::enqueueStyle('fau-orga-breadcrumb');

            // Render breadcrumb HTML (guard against missing helper)
            return (string) OrgaService::breadcrumb($form_org);
        }

        // Nothing to show (missing org or helpers)
        return '';
    }
}
