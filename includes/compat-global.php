<?php

declare(strict_types=1);

namespace {
    if (!function_exists('get_fau_orga_breadcrumb_customizer_choices')) {
        /**
         * Legacy shim für alte FAU-Themes: liefert Customizer-Choices global.
         */
        function get_fau_orga_breadcrumb_customizer_choices(): array
        {
            return \FAU\ORGA\Breadcrumb\get_fau_orga_breadcrumb_customizer_choices();
        }
    }
}
