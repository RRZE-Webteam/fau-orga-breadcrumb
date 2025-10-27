<?php
// filepath: includes/Ajax.php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;


/**
 * This class manages Ajax for selecting the Organization via the WordPress Customizer
 */
final class Ajax
{

    /**
     * Register AJAX actions used by the Customizer control.
     *
     * Hooks AJAX requests to `fau_orga_refresh_orga_options` into the handler.
     *
     * @return void
     */
    public static function register(): void
    {
        add_action('wp_ajax_fau_orga_refresh_orga_options', [self::class, 'refreshOrgaOptions']);
    }

    /**
     * AJAX handler: returns the `<option>` list for the Customizer select.
     *
     * Checks permissions, validates the nonce, filters the request values, and echoes the updated option HTML.
     *
     * @return void
     */

    public static function refreshOrgaOptions(): void
    {
        if (!OrgaService::isElementalTheme()) {
            wp_die(-1);
        }

        if (!current_user_can('edit_theme_options')) {
            wp_die(-1);
        }
        check_ajax_referer('fau_orga_refresh');

        $website_type = sanitize_text_field($_POST['website_type'] ?? '');
        $faculty = sanitize_text_field($_POST['faculty'] ?? '');
        $orga = sanitize_text_field($_POST['current_orga'] ?? '');

        $options = '';
        if (!in_array($website_type, ['1', 'faculty', 'chair'], true)) {
            $options .= '<option value="">' . __('None (no faculty assignment or central unit)', 'fau-orga-breadcrumb') . '</option>';
        }
        $options .= OrgaService::buildOptionList(OrgaService::ROOT_ID, $orga, 0, 4, $website_type, $faculty);

        echo $options;
        wp_die();
    }
}