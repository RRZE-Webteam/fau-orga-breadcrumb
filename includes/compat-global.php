<?php

declare(strict_types=1);

/**
 * Kompatibilitätsebene für ältere FAU-Themes:
 * Stellt eine globale Funktion bereit, die intern die neue, namespacete Funktion aufruft.
 *
 * Hintergrund:
 * Ältere Themes/Plugins erwarten die globale Funktion `get_fau_orga_breadcrumb_customizer_choices()`.
 * Diese Datei sorgt dafür, dass der Aufruf weiterhin funktioniert, auch wenn die Implementierung
 * inzwischen in den Namespace FAU\ORGA\Breadcrumb verschoben wurde.
 */
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
