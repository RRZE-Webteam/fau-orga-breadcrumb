<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * OrgaService
 *
 * Centralizes FAU ORGA helpers: theme detection, faculty/orga mapping,
 * recursive option building, breadcrumb rendering, and style enqueuing.
 *
 * @package FAU\ORGA\Breadcrumb
 */
final class OrgaService
{
    /** Root FAU.ORG ID (10 digits) */
    public const ROOT_ID = '0000000000';

    /** Known theme names for compatibility checks (immutable) */
    private const KNOWN_THEMES = [
        'fauthemes' => [
            'FAU-Einrichtungen',
            'FAU-Einrichtungen-BETA',
            'FAU-Medfak',
            'FAU-RWFak',
            'FAU-Philfak',
            'FAU-Techfak',
            'FAU-Natfak',
            'FAU-Blog',
            'FAU Jobportal',
            'FAU-Elemental',
        ],
        'rrzethemes' => [
            'RRZE 2019',
        ],
    ];

    /** Injected org dataset */
    private static array $data = [];

    // ---------------------- Bootstrapping ----------------------

    /**
     * Inject org data (keyed by FAU.ORG ID).
     *
     * @param array<string,array<string,mixed>> $data
     */
    public static function setData(array $data): void
    {
        self::$data = $data;
    }

    // ---------------------- Theme / Elemental helpers ----------------------

    /**
     * True if FAU-Elemental or a child is active.
     */
    public static function isElementalTheme(): bool
    {
        $theme = wp_get_theme();
        if (!$theme) {
            return false;
        }
        $name       = (string) $theme->get('Name');
        $template   = strtolower((string) $theme->get_template());
        $stylesheet = strtolower((string) $theme->get_stylesheet());

        return (strcasecmp($name, 'FAU-Elemental') === 0)
            || in_array($template, ['fau-elemental', 'fauelemental'], true)
            || in_array($stylesheet, ['fau-elemental', 'fauelemental'], true);
    }

    /**
     * Elemental site type: 'fau', 'faculty', 'chair', 'other', 'cooperation' ('' if unset).
     */
    public static function elementalSiteType(): string
    {
        return (string) get_theme_mod('faue_website_type', '');
    }

    /**
     * Elemental faculty slug: 'phil','nat','med','rw','tf' or ''.
     */
    public static function elementalFaculty(): string
    {
        return (string) get_theme_mod('faue_faculty', '');
    }

    /**
     * Legacy FAU theme → returns faculty code ('phil','nat','med','rw','tf','zentral') or false if not an FAU theme.
     *
     * @return string|false
     */
    public static function getLegacyFauThemeFaculty()
    {
        $theme = wp_get_theme();
        if (!$theme || !$theme->exists()) {
            return false;
        }
        $name = (string) $theme->get('Name');

        if (!in_array($name, self::KNOWN_THEMES['fauthemes'], true)) {
            return false;
        }

        switch ($name) {
            case 'FAU-Philfak':
                return 'phil';
            case 'FAU-RWFak':
                return 'rw';
            case 'FAU-Natfak':
                return 'nat';
            case 'FAU-Medfak':
                return 'med';
            case 'FAU-Techfak':
                return 'tf';
            default:
                return 'zentral';
        }
    }

    // ---------------------- Mapping / lookups ----------------------

    /**
     * Strict sanitizer for FAU.ORG numbers: digits only.
     */
    public static function sanitizeFauOrgNumber($s): string
    {
        $digits = preg_replace('/\D+/', '', (string) $s);
        return $digits !== null ? $digits : '';
    }

    /**
     * Get FAU.ORG ID for a given faculty slug (e.g., 'phil' → '1100000000') from injected data.
     */
    public static function getOrgaByFaculty(string $faculty): string
    {
        if ($faculty === '' || self::$data === []) {
            return '';
        }
        foreach (self::$data as $id => $row) {
            if (!empty($row['faculty']) && $row['faculty'] === $faculty) {
                return (string) $id;
            }
        }
        return '';
    }

    /**
     * Returns direct children IDs of a given org ID.
     *
     * @return array<string>
     */
    public static function childrenOf(string $fauorg): array
    {
        $fauorg = self::sanitizeFauOrgNumber($fauorg);
        if ($fauorg === '' || self::$data === []) {
            return [];
        }
        $res = [];
        foreach (self::$data as $id => $row) {
            if (!empty($row['parent']) && $row['parent'] === $fauorg) {
                $res[] = (string) $id;
            }
        }
        return $res;
    }

    /**
     * Returns the nearest upper CSS class (e.g., 'phil','nat',...) by walking up the tree.
     */
    public static function upperClass(string $fauorg): string
    {
        $id = self::sanitizeFauOrgNumber($fauorg);
        if ($id === '' || empty(self::$data[$id])) {
            return '';
        }
        if (!empty(self::$data[$id]['class'])) {
            return (string) self::$data[$id]['class'];
        }
        $parent = self::$data[$id]['parent'] ?? '';
        while ($parent !== '') {
            if (!empty(self::$data[$parent]['class'])) {
                return (string) self::$data[$parent]['class'];
            }
            $parent = self::$data[$parent]['parent'] ?? '';
        }
        return '';
    }

    // ---------------------- Select option builder ----------------------

    /**
     * Recursively builds <option> HTML for a <select>.
     *
     * @param string $root     start node
     * @param string $preselect pre-selected org
     * @param int    $level     current depth
     * @param int    $maxDepth  maximum depth
     */
    public static function buildOptionList(
        string $root = self::ROOT_ID,
        string $preselect = self::ROOT_ID,
        int $level = 0,
        int $maxDepth = 4
    ): string {
        if (self::$data === []) {
            return '';
        }

        $root      = self::sanitizeFauOrgNumber($root);
        $selected  = self::sanitizeFauOrgNumber($preselect);
        $faculty   = self::facultyByTheme(); // context filter
        $children  = self::childrenOf($root);

        if ($children === []) {
            return '';
        }

        $html = '';

        foreach ($children as $id) {
            $row = self::$data[$id] ?? null;
            if (!$row) {
                continue;
            }

            // --- Context-aware filtering ---
            $skipRender = false;

            if ($faculty !== '') {
                // Faculty context: show only nodes matching faculty
                if ($faculty !== 'zentral' && (!isset($row['faculty']) || $row['faculty'] !== $faculty)) {
                    continue;
                }
                // Central: do not render faculty nodes themselves, but traverse into children
                if ($faculty === 'zentral' && isset($row['faculty'])) {
                    $skipRender = true;
                }
            }

            // --- Render option if not skipped ---
            if (!$skipRender) {
                $orgClass = self::upperClass($id);
                $class    = 'depth-' . $level . ($orgClass ? (' ' . $orgClass) : '');
                $title    = isset($row['title']) ? (string) $row['title'] : $id;

                $html .= '<option class="' . esc_attr($class) . '" value="' . esc_attr($id) . '" ' .
                    selected($selected, $id, false);

                if (!empty($row['hide'])) {
                    $html .= ' disabled';
                }

                $html .= '>' . esc_html($title) . '</option>';
            }

            // Always traverse deeper (even if this node wasn't rendered)
            if ($level < $maxDepth) {
                $html .= self::buildOptionList($id, $preselect, $level + 1, $maxDepth);
            }
        }

        return $html;
    }

    /**
     * Flat key => label list for legacy Customizer controls.
     *
     * @return array<string,string>
     */
    public static function customizerChoices(): array
    {
        if (self::$data === []) {
            return [];
        }
        $res = [];
        foreach (self::$data as $id => $row) {
            if (isset($row['title'])) {
                $res[(string) $id] = (string) $row['title'];
            }
        }
        return $res;
    }

    // ---------------------- Breadcrumb ----------------------

    /**
     * Builds breadcrumb HTML for the given org (or inferred from theme if empty).
     *
     * @return string|null
     */
    public static function breadcrumb(?string $org): ?string
    {
        $id = $org ?: self::orgByTheme();
        $id = self::sanitizeFauOrgNumber((string) $id);

        if ($id === '' || self::$data === [] || empty(self::$data[$id])) {
            return null;
        }

        // Collect path upwards (skipping hidden nodes), then reverse
        $path   = [];
        $node   = self::$data[$id];

        if (empty($node['hide'])) {
            $path[] = $node;
        }

        $parent = $node['parent'] ?? '';
        while ($parent !== '') {
            $row = self::$data[$parent] ?? null;
            if ($row) {
                if (empty($row['hide'])) {
                    $path[] = $row;
                }
                $parent = $row['parent'] ?? '';
            } else {
                break;
            }
        }

        $crumbs   = array_reverse($path);
        $position = 1;
        $line     = '';

        foreach ($crumbs as $row) {
            $entry = '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            if (!empty($row['url'])) {
                $entry .= '<a itemprop="item" href="' . esc_url((string) $row['url']) . '">';
            } else {
                $entry .= '<span itemprop="item">';
            }
            $title  = isset($row['title']) ? (string) $row['title'] : '';
            $entry .= '<span itemprop="name">' . esc_html($title) . '</span>';
            $entry .= !empty($row['url']) ? '</a>' : '</span>';
            $entry .= '<meta itemprop="position" content="' . (int) $position . '" />';
            $entry .= '</li>';

            $position++;
            $line .= $entry;
        }

        $res  = '<nav class="orga-breadcrumb" aria-label="' . esc_attr__('Organizational Navigation', 'fau-orga-breadcrumb') . '">';
        $res .= '<ol class="breadcrumblist" itemscope itemtype="https://schema.org/BreadcrumbList">';
        $res .= $line;
        $res .= '</ol></nav>';

        return $res;
    }

    // ---------------------- Faculty & Orga resolution ----------------------

    /**
     * Resolve faculty slug from active theme / Customizer values.
     *
     * Returns:
     *  - 'phil','nat','med','rw','tf' → a faculty
     *  - 'zentral' → central unit / FAU.de
     *  - '' → no assignment / not to be shown
     */
    public static function facultyByTheme(): string
    {
        if (self::isElementalTheme()) {
            $type    = self::elementalSiteType();
            $faculty = self::elementalFaculty();

            if ($type === 'fau') {
                return 'zentral';
            }
            if (in_array($type, ['faculty', 'chair'], true) && $faculty !== '') {
                return $faculty;
            }
            if ($type === 'other' && $faculty !== '') {
                return $faculty;
            }
            if ($type === 'cooperation') {
                return '';
            }
            return '';
        }

        // Legacy: website_type may be string; cast to int for reliable comparisons
        $websiteType = (int) get_theme_mod('website_type', -999);
        if ($websiteType === 0 || $websiteType === 2) {
            return 'zentral';
        }

        $legacy = self::getLegacyFauThemeFaculty();
        if ($legacy !== false) {
            $debug = get_theme_mod('debug_website_fakultaet');
            if ($debug !== false && $debug !== null && $debug !== '') {
                return (string) $debug;
            }
            return $legacy;
        }

        return '';
    }

    /**
     * Resolve FAU.ORG ID from the resolved faculty.
     */
    public static function orgByTheme(): string
    {
        $faculty = self::facultyByTheme();
        return self::getOrgaByFaculty($faculty);
    }

    // ---------------------- Enqueue CSS ----------------------

    /**
     * Enqueue breadcrumb CSS depending on active theme.
     *
     * @param string $fallbackHandle Fallback handle to enqueue if not Elemental/FAU theme.
     */
    public static function enqueueStyle(string $fallbackHandle = 'fau-orga-breadcrumb'): void
    {
        $theme = wp_get_theme();
        $name  = $theme ? (string) $theme->get('Name') : '';

        // 1) FAU-Elemental → load plugin CSS
        if ($name === 'FAU-Elemental') {
            wp_enqueue_style(
                'fau-orga-breadcrumb-elemental',
                plugins_url('build/frontend.css', plugin()->getBasename()),
                [],
                plugin()->getVersion()
            );
            return;
        }

        // 2) Other FAU themes → no CSS (legacy behavior)
        if (in_array($name, self::KNOWN_THEMES['fauthemes'], true)) {
            return;
        }

        // 3) Everything else → enqueue fallback if registered
        if (wp_style_is($fallbackHandle, 'registered')) {
            wp_enqueue_style($fallbackHandle);
        }
    }
}
