<?php

declare(strict_types=1);

/**
 * Compatibility layer for older FAU themes:
 * Provides a global function that internally calls the new class-based API.
 */

namespace {
    if (!function_exists('get_fau_orga_breadcrumb_customizer_choices')) {
        /**
         * Legacy shim for old FAU themes: returns Customizer choices globally.
         *
         * @return array<string,string>
         */
        function get_fau_orga_breadcrumb_customizer_choices(): array
        {
            // Prefer the class-based shim (avoids duplicating logic)
            if (class_exists('\FAU\ORGA\Breadcrumb\LegacyShim')) {
                return \FAU\ORGA\Breadcrumb\LegacyShim::customizerChoices();
            }

            // Fallback: prevent fatals if class not yet loaded
            if (function_exists('trigger_error')) {
                trigger_error(
                    'FAU shim: \FAU\ORGA\Breadcrumb\LegacyShim not found. Returning empty choices.',
                    E_USER_NOTICE
                );
            }
            return [];
        }
    }
}
