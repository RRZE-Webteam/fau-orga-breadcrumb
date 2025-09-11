<?php

declare(strict_types=1);

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * LegacyShim
 *
 * Centralizes legacy compatibility for older FAU themes/plugins that still call
 * the global function `get_fau_orga_breadcrumb_customizer_choices()`.
 *
 * New code should call:
 *   OrgaService::customizerChoices()
 *
 * Older code can keep calling the global function; the global wrapper defined
 * below will delegate to this class.
 */
final class LegacyShim
{
    /**
     * Return Customizer choices using the new service. Also emits a deprecation notice.
     *
     * @return array<string,string>
     */
    public static function customizerChoices(): array
    {
        // Deprecation hint (shows up in logs/tools if available)
        if (\function_exists('_deprecated_function')) {
            _deprecated_function(
                'get_fau_orga_breadcrumb_customizer_choices',   // deprecated
                'fau-orga-breadcrumb 1.2.0',                    // since
                __METHOD__                                      // replacement
            );
        }

        // Ensure the new service is available; fail soft if not
        if (!\class_exists(\FAU\ORGA\Breadcrumb\OrgaService::class)) {
            if (\function_exists('trigger_error')) {
                \trigger_error(
                    'FAU shim: OrgaService not loaded. Returning empty choices.',
                    E_USER_NOTICE
                );
            }
            return [];
        }

        return OrgaService::customizerChoices();
    }
}
