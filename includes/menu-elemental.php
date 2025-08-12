<?php

namespace FAU\ORGA\Breadcrumb;


/**
 * Baut das Menü-HTML aus dem $elemental_menu-Array auf.
 *
 * Erwartet optionale Keys pro Item:
 * - 'class'   => zusätzliche CSS-Klasse aus constants.php (z. B. 'phil')
 * - 'faculty' => Fakultäts-Slug, wird als 'faculty-<slug>' ausgegeben (z. B. 'phil' -> 'faculty-phil')
 *
 * @param array $menu Menü-Array aus constants.php
 * @param string|null $parentId Startpunkt (ID) für den Menü-Teilbaum
 * @param int $depth Menüebene für CSS-Klassen
 *
 * @return string HTML-Code des Menüs
 */
function render_elemental_menu(array $menu, ?string $parentId = null, int $depth = 0): string
{
    // 🔍 Menü-Items nach Parent filtern
    $items = array_filter($menu, static function ($item) use ($parentId) {
        if ($parentId === null) {
            return !isset($item['parent']);
        }

        return isset($item['parent']) && (string)$item['parent'] === (string)$parentId;
    });

    if (empty($items)) {
        return '';
    }

    // 📦 UL-Klasse für Root vs. Submenu auswählen
    $ulClass = $depth === 0
        ? 'menu-meta-nav__menu menu-meta-nav__menu--hierarchy menu-meta-nav__menu--hierarchy--top-header-nav-structure'
        : 'sub-menu sub-menu--level-' . $depth;

    $html = '<ul class="' . esc_attr($ulClass) . '">';

    foreach ($items as $id => $item) {
        $title = $item['title'] ?? '❌ NO TITLE for ID ' . $id;

        // Prüfen, ob dieses Item Kinder hat
        $hasChildren = !empty(array_filter(
            $menu,
            static fn($child) => isset($child['parent']) && (string)$child['parent'] === (string)$id
        ));

        // Basis-<li>-Klassen
        $classes = [
            'menu-item',
            'menu-item-depth-' . $depth,
        ];

        // Falls in constants.php 'class' gesetzt ist → übernehmen (z. B. 'phil')
        if (!empty($item['class']) && is_string($item['class'])) {
            $classes[] = sanitize_html_class($item['class']);
        }

        // Falls 'faculty' gesetzt ist → als 'faculty-<slug>' hinzufügen (für Theme-CSS)
        if (!empty($item['faculty']) && is_string($item['faculty'])) {
            $classes[] = 'faculty-' . sanitize_html_class($item['faculty']);
        }

        // Falls Kinder vorhanden → zusätzliche Menü-Klassen
        if ($hasChildren) {
            $classes[] = 'menu-item-has-children';
            $classes[] = 'has-children';
        }

        // <li> öffnen
        $html .= sprintf(
            '<li id="menu-item-%s" class="%s" data-menu-item-id="%s">',
            esc_attr((string)$id),
            esc_attr(implode(' ', $classes)),
            esc_attr((string)$id)
        );

        if ($hasChildren) {
            // 🔽 Eltern-Item: Button + verschachtelte UL
            $html .= sprintf(
                '<button class="menu-modal__submenu-toggle menu-modal__submenu-row" aria-expanded="false" aria-label="%s" data-parent-title="%s">' .
                '<span class="menu-modal__item-title">%s</span>' .
                '<span class="menu-modal__submenu-arrow"></span>' .
                '</button>',
                esc_attr('Open ' . $title . ' submenu'),
                esc_attr($title),
                esc_html($title)
            );

            // Rekursiv die Kinder rendern
            $html .= render_elemental_menu($menu, (string)$id, $depth + 1);
        } else {
            // 🔗 Einfacher Menüpunkt ohne Kinder
            $url = $item['url'] ?? '#';
            $html .= '<a href="' . esc_url($url) . '">' . esc_html($title) . '</a>';
        }

        $html .= '</li>';
    }

    $html .= '</ul>';

    return $html;
}


/**
 * Generiert nur den Content-Bereich des Menüs (ohne Modal-Header).
 *
 * @return string
 */
function get_fau_elemental_menu_html(): string
{
    global $elemental_menu;

    // Breadcrumb generieren
    $breadcrumb_html = generate_breadcrumb_for_menu();

    $html = '';

    // Breadcrumb nur einfügen, wenn vorhanden
    if (!empty($breadcrumb_html)) {
        $html .= '<div class="fau-elemental-breadcrumb">';
        $html .= $breadcrumb_html;
        $html .= '</div>';
    }

    // Menü vorbereiten
    $menu = $elemental_menu;
    if (!should_show_fau_menu_item()) {
        unset($menu['0000000000']); // FAU Top-Level entfernen
    }

    // Menücontainer mit Menü
    $html .= '<div class="menu-meta-nav__modal__content">';
    $html .= render_elemental_menu($menu);
    $html .= '</div>';

    return $html;
}


/**
 * Generiert Breadcrumb für das Menü
 * Verwendet die normale Breadcrumb + Website-Titel
 *
 * @return string HTML für Breadcrumb
 */
function generate_breadcrumb_for_menu(): string
{
    // Organisationseinheit aus den Plugin-Optionen lesen
    $options = get_option('fau_orga_breadcrumb_options');
    $form_org = isset($options['site-orga']) ? esc_attr($options['site-orga']) : '';

    // Falls leer, Fallback über Theme-Logik
    if (empty($form_org)) {
        $form_org = get_fau_orga_by_theme();
    }

    // Keine Breadcrumb, wenn auf FAU-Hauptebene (0000000000)
    if ($form_org === '0000000000') {
        return '';
    }

    // Breadcrumb HTML aus Plugin-Funktion erzeugen
    $breadcrumb_html = get_fau_orga_breadcrumb($form_org);

    if (empty($breadcrumb_html)) {
        return '';
    }

    // Website-Titel nur ergänzen, wenn organisatorische Zuordnung gesetzt
    // UND die Zuordnung eine Fakultät ist (phil, rw, med, nat, tf)
    $site_title = get_bloginfo('name');
    if (!empty($site_title) && !empty($form_org) && $form_org !== '0000000000') {

        global $fau_orga_breadcrumb_data;

        // Prüfen, ob der Eintrag im Orga-Array existiert und eine Fakultät ist
        if (isset($fau_orga_breadcrumb_data[$form_org]['faculty'])) {
            $faculty_slug = $fau_orga_breadcrumb_data[$form_org]['faculty'];

            // Fakultätsliste definieren
            $valid_faculties = ['phil', 'rw', 'med', 'nat', 'tf'];

            if (in_array($faculty_slug, $valid_faculties, true)) {
                $breadcrumb_html = add_site_title_to_breadcrumb($breadcrumb_html, $site_title, false);
            }
        }
    }

    return $breadcrumb_html;
}


/**
 * Fügt den Website-Titel zur bestehenden Breadcrumb hinzu
 *
 * @param string $breadcrumb_html Die bestehende Breadcrumb
 * @param string $site_title Der Website-Titel
 * @return string Die erweiterte Breadcrumb
 */
function add_site_title_to_breadcrumb(string $breadcrumb_html, string $site_title, bool $hide = false): string
{
    if ($hide) {
        return $breadcrumb_html;
    }

    $site_title_li = '<li><span>' . esc_html($site_title) . '</span></li>';
    return str_replace('</ol>', $site_title_li . '</ol>', $breadcrumb_html);
}

/**
 * Zeigt den obersten Menüpunkt "FAU" nur auf Fakultäts-, Department- und Lehrstuhlebenen an.
 */
function should_show_fau_menu_item(): bool
{
    $siteType = (string)get_theme_mod('faue_website_type', '');
    $faculty = (string)get_theme_mod('faue_faculty', '');

    // Fakultät oder Lehrstuhl -> anzeigen
    if (in_array($siteType, ['faculty', 'chair'], true)) {
        return true;
    }

    // Department: im Elemental (noch) kein eigener Typ -> "other" + Fakultät gesetzt
    if ($siteType === 'other' && $faculty !== '') {
        return true;
    }

    // Sonst nicht anzeigen (inkl. fau / cooperation / leer)
    return false;
}