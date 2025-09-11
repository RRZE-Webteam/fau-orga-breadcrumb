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
    /** @var array<string,array<string,mixed>> Flat menu array (id => item) */
    private array $menu;

    /**
     * @param array<string,array<string,mixed>> $menu Flat menu data
     */
    public function __construct(array $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Factory that uses the legacy global $elemental_menu for convenience.
     * Prefer explicit construction where possible.
     */
    public static function fromGlobal(): self
    {
        /** @var array<string,array<string,mixed>> $elemental_menu */
        $elemental_menu = $GLOBALS['elemental_menu'] ?? [];
        return new self(is_array($elemental_menu) ? $elemental_menu : []);
    }

    /**
     * Builds ONLY the modal content (breadcrumb + hierarchical menu).
     * This mirrors the old get_fau_elemental_menu_html() behavior.
     */
    public function renderContentHtml(): string
    {
        $html = '';

        // Render breadcrumb (omit when empty)
        $breadcrumb = $this->renderBreadcrumb();
        if ($breadcrumb !== '') {
            $html .= '<div class="fau-elemental-breadcrumb">' . $breadcrumb . '</div>';
        }

        // Optionally remove FAU top-level node from menu if conditions don't match
        $menu = $this->menu;
        $rootId = \class_exists(OrgaService::class) ? OrgaService::ROOT_ID : '0000000000';

        if (!$this->shouldShowFauRoot()) {
            unset($menu[$rootId]);
        }

        // Main container + hierarchical UL
        $html .= '<div class="menu-meta-nav__modal__content">';
        $html .= $this->renderTree($menu);
        $html .= '</div>';

        return $html;
    }

    /**
     * Renders the hierarchical <ul>/<li> structure starting at $parentId.
     *
     * @param array<string,array<string,mixed>> $menu  Flat menu data to use for this render
     * @param string|null $parentId  Start node (null means top-level items without 'parent')
     * @param int $depth             Current depth for CSS classes
     */
    public function renderTree(array $menu, ?string $parentId = null, int $depth = 0): string
    {
        // Filter items by parent
        $items = array_filter($menu, static function ($item) use ($parentId) {
            if ($parentId === null) {
                return !isset($item['parent']);
            }
            return isset($item['parent']) && (string) $item['parent'] === (string) $parentId;
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
            $title = isset($item['title']) && $item['title'] !== '' ? (string) $item['title'] : 'NO TITLE for ID ' . $id;

            // Determine if this item has children
            $hasChildren = !empty(array_filter(
                $menu,
                static fn($child) => isset($child['parent']) && (string) $child['parent'] === (string) $id
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
                esc_attr((string) $id),
                esc_attr(implode(' ', $classes)),
                esc_attr((string) $id)
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
                $html .= $this->renderTree($menu, (string) $id, $depth + 1);
            } else {
                // Leaf node: anchor
                $url = isset($item['url']) && $item['url'] !== '' ? (string) $item['url'] : '#';
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
    public function renderBreadcrumb(): string
    {
        // Resolve current org from plugin option
        $options  = get_option('fau_orga_breadcrumb_options');
        $formOrg  = isset($options['site-orga']) ? sanitize_text_field((string) $options['site-orga']) : '';

        // Fallback via theme
        if ($formOrg === '') {
            $formOrg = \class_exists(OrgaService::class)
                ? OrgaService::orgByTheme()
                : (string) \call_user_func(function () {
                    return function_exists(__NAMESPACE__ . '\\get_fau_orga_by_theme')
                        ? (string) get_fau_orga_by_theme()
                        : '';
                });
        }

        // No breadcrumb when at FAU root
        $rootId = \class_exists(OrgaService::class) ? OrgaService::ROOT_ID : '0000000000';
        if ($formOrg === $rootId) {
            return '';
        }

        // Generate breadcrumb HTML via OrgaService/legacy function
        if (\class_exists(OrgaService::class)) {
            return OrgaService::breadcrumb($formOrg) ?? '';
        }

        if (function_exists(__NAMESPACE__ . '\\get_fau_orga_breadcrumb')) {
            return (string) get_fau_orga_breadcrumb($formOrg);
        }

        return '';
    }

    /**
     * Whether the top-level FAU item should be shown in the modal menu.
     * Faculty/chair → show; "other" with faculty set → show; otherwise not.
     */
    public function shouldShowFauRoot(): bool
    {
        // Prefer OrgaService when available
        if (\class_exists(OrgaService::class)) {
            $siteType = OrgaService::elementalSiteType();
            $faculty  = OrgaService::elementalFaculty();

            if (\in_array($siteType, ['faculty', 'chair'], true)) {
                return true;
            }
            if ($siteType === 'other' && $faculty !== '') {
                return true;
            }
            return false;
        }

        // Legacy fallback via theme_mods
        $siteType = (string) get_theme_mod('faue_website_type', '');
        $faculty  = (string) get_theme_mod('faue_faculty', '');

        if (\in_array($siteType, ['faculty', 'chair'], true)) {
            return true;
        }
        if ($siteType === 'other' && $faculty !== '') {
            return true;
        }
        return false;
    }
}
