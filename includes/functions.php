<?php

/**
 * Plugin bootstrap using OrgaService
 */

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

// ---------------------------------------------------------
// Customizer sync (Elemental only): mirror site type/faculty to plugin option
// ---------------------------------------------------------
add_action('customize_save_after', static function (\WP_Customize_Manager $manager) {
    // Only act for FAU-Elemental (or child)
    if (!OrgaService::isElementalTheme()) {
        return;
    }

    // Read freshly saved values directly from the Customizer post values (with fallback)
    $type    = (string) ($manager->post_value('faue_website_type') ?? get_theme_mod('faue_website_type', ''));
    $faculty = (string) ($manager->post_value('faue_faculty')       ?? get_theme_mod('faue_faculty',       ''));

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
});

// ---------------------------------------------------------
// Enqueue CSS depending on active theme (Elemental/FAU/Other)
// ---------------------------------------------------------
add_action('wp_enqueue_scripts', static function () {
    OrgaService::enqueueStyle('fau-orga-breadcrumb'); // fallback handle if not Elemental/FAU
}, 99);


// ===================================================================
// Legacy wrappers (BC): keep old function names working transparently
// ===================================================================

/**
 * Legacy: is FAU-Elemental active?
 */
if (!function_exists(__NAMESPACE__ . '\\fau_is_elemental_theme')) {
    function fau_is_elemental_theme(): bool
    {
        return OrgaService::isElementalTheme();
    }
}

/**
 * Legacy: Elemental site type ('fau','faculty','chair','other','cooperation').
 */
if (!function_exists(__NAMESPACE__ . '\\fau_elemental_site_type')) {
    function fau_elemental_site_type(): string
    {
        return OrgaService::elementalSiteType();
    }
}

/**
 * Legacy: Elemental faculty slug ('phil','nat','med','rw','tf' or '').
 */
if (!function_exists(__NAMESPACE__ . '\\fau_elemental_faculty_slug')) {
    function fau_elemental_faculty_slug(): string
    {
        return OrgaService::elementalFaculty();
    }
}

/**
 * Legacy: map faculty slug to FAU.ORG ID.
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_orga_fauorg_by_faculty')) {
    function get_fau_orga_fauorg_by_faculty($faculty = ''): string
    {
        return OrgaService::getOrgaByFaculty((string) $faculty);
    }
}

/**
 * Legacy: return direct children of an org ID.
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_orga_childs')) {
    function get_fau_orga_childs($fauorg = OrgaService::ROOT_ID): array
    {
        return OrgaService::childrenOf((string) $fauorg);
    }
}

/**
 * Legacy: get nearest upper CSS class for an org ID.
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_orga_upperclass')) {
    function get_fau_orga_upperclass($fauorg = ''): string
    {
        return OrgaService::upperClass((string) $fauorg);
    }
}

/**
 * Legacy: build recursive <option> list for a <select>.
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_orga_form_optionlist')) {
    function get_fau_orga_form_optionlist(
        $fauorg   = OrgaService::ROOT_ID,
        $preorg   = OrgaService::ROOT_ID,
        $level    = 0,
        $maxdepth = 4
    ): string {
        return OrgaService::buildOptionList((string) $fauorg, (string) $preorg, (int) $level, (int) $maxdepth);
    }
}

/**
 * Legacy: flat key=>label list for Customizer choices.
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_orga_breadcrumb_customizer_choices')) {
    function get_fau_orga_breadcrumb_customizer_choices(): array
    {
        return OrgaService::customizerChoices();
    }
}

/**
 * Legacy: strict sanitizer for FAU.ORG numbers (digits only).
 */
if (!function_exists(__NAMESPACE__ . '\\san_fauorg_number')) {
    function san_fauorg_number($s): string
    {
        return OrgaService::sanitizeFauOrgNumber($s);
    }
}

/**
 * Legacy: build breadcrumb HTML (or null if unavailable).
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_orga_breadcrumb')) {
    function get_fau_orga_breadcrumb($form_org)
    {
        return OrgaService::breadcrumb($form_org !== null ? (string) $form_org : null);
    }
}

/**
 * Legacy: resolve faculty by theme/customizer.
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_faculty_by_theme')) {
    function get_fau_faculty_by_theme(): string
    {
        return OrgaService::facultyByTheme();
    }
}

/**
 * Legacy: resolve org by theme/customizer (faculty → FAU.ORG ID).
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_orga_by_theme')) {
    function get_fau_orga_by_theme(): string
    {
        return OrgaService::orgByTheme();
    }
}

/**
 * Legacy: enqueue style based on theme context.
 */
if (!function_exists(__NAMESPACE__ . '\\fau_orga_enqueue_style')) {
    function fau_orga_enqueue_style($style = 'fau-orga-breadcrumb'): void
    {
        OrgaService::enqueueStyle((string) $style);
    }
}

/**
 * Legacy: legacy FAU theme → faculty code (or false if not FAU theme).
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_orga_fautheme')) {
    function get_fau_orga_fautheme()
    {
        return OrgaService::getLegacyFauThemeFaculty();
    }
}

/**
 * Legacy wrapper: returns the Elemental menu modal content (breadcrumb + menu).
 * Delegates to ElementalMenu. Kept for backward compatibility.
 *
 * @return string
 */
if (!function_exists(__NAMESPACE__ . '\\get_fau_elemental_menu_html')) {
    function get_fau_elemental_menu_html(): string
    {
        // Deprecation hint (visible in logs/tools)
        if (function_exists('_deprecated_function')) {
            _deprecated_function(
                __FUNCTION__,
                'fau-orga-breadcrumb 1.2.0',
                '\FAU\ORGA\Breadcrumb\ElementalMenu::renderContentHtml'
            );
        }

        // Prefer class-based renderer; fail soft if not available
        if (class_exists(\FAU\ORGA\Breadcrumb\ElementalMenu::class)) {
            return ElementalMenu::fromGlobal()->renderContentHtml();
        }

        // Fallback: minimal safe output
        return '';
    }
}

/**
 * Legacy wrapper: renders a subtree of the Elemental menu (ul/li).
 * Delegates to ElementalMenu::renderTree(). Kept for backward compatibility.
 *
 * @param array<string,array<string,mixed>> $menu
 * @param string|null $parentId
 * @param int $depth
 * @return string
 */
if (!function_exists(__NAMESPACE__ . '\\render_elemental_menu')) {
    function render_elemental_menu(array $menu, ?string $parentId = null, int $depth = 0): string
    {
        if (function_exists('_deprecated_function')) {
            _deprecated_function(
                __FUNCTION__,
                'fau-orga-breadcrumb 1.2.0',
                '\FAU\ORGA\Breadcrumb\ElementalMenu::renderTree'
            );
        }

        if (class_exists(\FAU\ORGA\Breadcrumb\ElementalMenu::class)) {
            $renderer = new ElementalMenu($menu);
            return $renderer->renderTree($menu, $parentId, $depth);
        }

        return '';
    }
}

/**
 * Legacy wrapper: builds the breadcrumb shown above the Elemental menu.
 * Delegates to ElementalMenu::renderBreadcrumb(). Kept for backward compatibility.
 *
 * @return string
 */
if (!function_exists(__NAMESPACE__ . '\\generate_breadcrumb_for_menu')) {
    function generate_breadcrumb_for_menu(): string
    {
        if (function_exists('_deprecated_function')) {
            _deprecated_function(
                __FUNCTION__,
                'fau-orga-breadcrumb 1.2.0',
                '\FAU\ORGA\Breadcrumb\ElementalMenu::renderBreadcrumb'
            );
        }

        if (class_exists(\FAU\ORGA\Breadcrumb\ElementalMenu::class)) {
            $renderer = ElementalMenu::fromGlobal();
            return $renderer->renderBreadcrumb();
        }

        return '';
    }
}

/**
 * Legacy wrapper: decides whether to show the top-level FAU item.
 * Delegates to ElementalMenu::shouldShowFauRoot(). Kept for backward compatibility.
 *
 * @return bool
 */
if (!function_exists(__NAMESPACE__ . '\\should_show_fau_menu_item')) {
    function should_show_fau_menu_item(): bool
    {
        if (function_exists('_deprecated_function')) {
            _deprecated_function(
                __FUNCTION__,
                'fau-orga-breadcrumb 1.2.0',
                '\FAU\ORGA\Breadcrumb\ElementalMenu::shouldShowFauRoot'
            );
        }

        if (class_exists(\FAU\ORGA\Breadcrumb\ElementalMenu::class)) {
            return ElementalMenu::fromGlobal()->shouldShowFauRoot();
        }

        // Conservative default: hide when uncertain
        return false;
    }
}
