<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * ElementalMenu
 *
 * Renders the FAU-Elemental hierarchical menu and its breadcrumb section.
 * This class avoids globals by accepting the menu array via constructor.
 *
 * Expected menu item keys:
 *  - 'title'   (string)  : item label
 *  - 'url'     (string)  : optional link
 *  - 'parent'  (string)  : optional parent ID to build hierarchy
 *  - 'class'   (string)  : optional CSS class (e.g., 'phil')
 *  - 'faculty' (string)  : optional faculty slug (e.g., 'phil' -> adds 'faculty-phil')
 */
final class ElementalMenu
{
    /** Injected org dataset */
    private static array $data = [];

    public function __construct()
    {
        // optional fallback, if new ElementalMenu() is used
        $data = Data::read('fau-elemental-orga');
        self::$data = is_array($data) ? $data : [];
    }

    /**
     * Inject org data (keyed by FAU.ORG ID).
     *
     * @param array<string,array<string,mixed>> $data
     */
    public static function setData(array $data): void
    {
        self::$data = $data;
    }

    /**
     * Builds ONLY the modal content (breadcrumb + hierarchical menu).
     * This mirrors the old get_fau_elemental_menu_html() behavior.
     */

    public static function renderContentHtml(): string
    {
        $html = '';

        // Breadcrumb
        $breadcrumb = self::renderBreadcrumb();
        if ($breadcrumb !== '') {
            $html .= '<div class="fau-elemental-breadcrumb">' . $breadcrumb . '</div>';
        }

        // working copy + restore
        $rootId = OrgaService::ROOT_ID;
        $original = self::$data;         // <-- backup of the original data
        $working = self::$data;          // <-- working copy

        if (!self::shouldShowFauRoot()) {
            unset($working[$rootId]);    // <-- no FAU.de in structure menu
        }

        self::$data = $working;          // <-- set temporarily so renderTree() works


        // Main container + hierarchical UL
        $html .= '<div class="menu-meta-nav__modal__content">';
        $html .= self::renderTree();     // <-- uses self::$data (now the working copy)
        $html .= '</div>';

        //restore original
        self::$data = $original;


        return $html;
    }

    /**
     * Renders the hierarchical <ul>/<li> structure starting at $parentId.
     *
     * @param string|null $parentId Start node (null means top-level items without 'parent')
     * @param int $depth Current depth for CSS classes
     */
    public static function renderTree(?string $parentId = null, int $depth = 0): string
    {
        // Filter items by parent
        $items = array_filter(self::$data, static function ($item) use ($parentId) {
            if ($parentId === null) {
                return !isset($item['parent']);
            }
            return isset($item['parent']) && (string)$item['parent'] === (string)$parentId;
        });

        if (empty($items)) {
            return '';
        }

        // Root vs. nested UL class
        $ulClass = $depth === 0
            ? 'menu-meta-nav__menu menu-meta-nav__menu--hierarchy menu-meta-nav__menu--hierarchy--top-header-nav-structure'
            : 'sub-menu sub-menu--level-' . $depth;

        $html = '<ul class="' . esc_attr($ulClass) . '">';

        foreach ($items as $id => $item) {
            $title = isset($item['title']) && $item['title'] !== '' ? (string)$item['title'] : 'NO TITLE for ID ' . $id;

            // Determine if this item has children
            $hasChildren = !empty(array_filter(
                self::$data,
                static fn($child) => isset($child['parent']) && (string)$child['parent'] === (string)$id
            ));

            // Base <li> classes
            $classes = [
                'menu-item',
                'menu-item-depth-' . $depth,
            ];

            // Optional class from data (e.g., 'phil')
            if (!empty($item['class']) && \is_string($item['class'])) {
                $classes[] = sanitize_html_class($item['class']);
            }

            // Optional faculty slug → 'faculty-<slug>'
            if (!empty($item['faculty']) && \is_string($item['faculty'])) {
                $classes[] = 'faculty-' . sanitize_html_class($item['faculty']);
            }

            // Children flags
            if ($hasChildren) {
                $classes[] = 'menu-item-has-children';
                $classes[] = 'has-children';
            }

            // Open <li>
            $html .= sprintf(
                '<li id="menu-item-%s" class="%s" data-menu-item-id="%s">',
                esc_attr((string)$id),
                esc_attr(implode(' ', $classes)),
                esc_attr((string)$id)
            );

            if ($hasChildren) {
                // Parent node: toggle button + nested UL
                $html .= sprintf(
                    '<button class="menu-modal__submenu-toggle menu-modal__submenu-row" aria-expanded="false" aria-label="%s" data-parent-title="%s">' .
                    '<span class="menu-modal__item-title">%s</span>' .
                    '<span class="menu-modal__submenu-arrow"></span>' .
                    '</button>',
                    esc_attr('Open ' . $title . ' submenu'),
                    esc_attr($title),
                    esc_html($title)
                );

                // Recurse into children
                $html .= self::renderTree((string)$id, $depth + 1);
            } else {
                // Leaf node: anchor
                $url = isset($item['url']) && $item['url'] !== '' ? (string)$item['url'] : '#';
                $html .= '<a href="' . esc_url($url) . '">' . esc_html($title) . '</a>';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }

    /**
     * Builds the breadcrumb HTML shown above the menu.
     * Uses plugin options and falls back to theme-based org resolution.
     */
    public static function renderBreadcrumb(): string
    {
        // Resolve current org from plugin option
        $options = get_option('fau_orga_breadcrumb_options');
        $formOrg = isset($options['site-orga']) ? sanitize_text_field((string)$options['site-orga']) : '';

        // Fallback via theme
        if ($formOrg === '') {
            $formOrg = OrgaService::orgByTheme();
        }

        // No breadcrumb when at FAU root
        $rootId = \class_exists(OrgaService::class) ? OrgaService::ROOT_ID : '0000000000';
        if ($formOrg === $rootId) {
            return '';
        }

        // Generate breadcrumb HTML
        return (string)OrgaService::breadcrumb($formOrg);
    }

    /**
     * Whether the top-level FAU item should be shown in the modal menu.
     * Faculty/chair/other/cooperation → show; "fau.de" → don´t show
     */
        public static function shouldShowFauRoot(): bool
    {
        // Prefer OrgaService when available
        if (\class_exists(OrgaService::class)) {
            $siteType = OrgaService::elementalSiteType();

            if (\in_array($siteType, ['faculty', 'chair', 'cooperation', 'other'], true)) {
                return true;
            }
            return false;
        }

        // Legacy fallback via theme_mods
        $siteType = (string)get_theme_mod('faue_website_type', '');

        if (\in_array($siteType, ['faculty', 'chair', 'cooperation', 'other'], true)) {
            return true;
        }
        return false;
    }
}

