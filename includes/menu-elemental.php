<?php

namespace FAU\ORGA\Breadcrumb;

/**
 * Baut das Menü aus dem $elemental_menu-Array rekursiv auf.
 *
 * @param array       $menu      Das Menü-Array aus constants.php
 * @param string|null $parent_id Startpunkt für die Menüausgabe
 * @param int         $depth     Menüebene für CSS-Klassen
 *
 * @return string HTML-Code des Menüs
 */
function render_elemental_menu(array $menu, ?string $parent_id = null, int $depth = 0): string
{
    // 🔍 Alle Items filtern, die keinen Parent haben (Top-Level) oder den angegebenen Parent nutzen
    $items = array_filter($menu, function ($item) use ($parent_id) {
        if ($parent_id === null) {
            return !isset($item['parent']);
        }
        return isset($item['parent']) && (string) $item['parent'] === (string) $parent_id;
    });

    if (empty($items)) {
        return '';
    }

    //  UL-Klasse nur für Hauptmenü und Submenu trennen
    $ul_class = $depth === 0
        ? 'menu-meta-nav__menu menu-meta-nav__menu--hierarchy menu-meta-nav__menu--hierarchy--top-header-nav-structure'
        : 'sub-menu sub-menu--level-' . $depth;

    $html = '<ul class="' . $ul_class . '">';

    foreach ($items as $id => $item) {
        $title = $item['title'] ?? '❌ NO TITLE for ID ' . $id;

        // Prüfen, ob das Item Kinder hat
       $has_children = !empty(array_filter($menu, fn($child) => isset($child['parent']) && (string)$child['parent'] === (string)$id));
        // CSS-Klassen vorbereiten
        $classes = ['menu-item', 'menu-item-depth-' . $depth];
        if ($has_children) {
            $classes[] = 'menu-item-has-children';
            $classes[] = 'has-children';
        }

        // LI öffnen
        $html .= '<li id="menu-item-' . esc_attr($id) . '" class="' . implode(' ', $classes) . '" data-menu-item-id="' . esc_attr($id) . '">';

        // Menüpunkt mit Children = Button + Submenu
        if ($has_children) {
            $html .= '<button 
                class="menu-modal__submenu-toggle menu-modal__submenu-row" 
                aria-expanded="false" 
                aria-label="Open ' . esc_attr($title) . ' submenu"
                data-parent-title="' . esc_attr($title) . '">
                    <span class="menu-modal__item-title">' . esc_html($title) . '</span>
                    <span class="menu-modal__submenu-arrow"></span>
            </button>';

            // Kinder einfügen
            $html .= render_elemental_menu($menu, $id, $depth + 1);

        } else {
            $url = $item['url'] ?? '#';
            $html .= '<a href="' . esc_url($url) . '">' . esc_html($title) . '</a>';
        }

        $html .= '</li>';
    }

    $html .= '</ul>';
    return $html;
}


/**
 * Generiert NUR den Content-Bereich des Menüs (ohne Modal-Header).
 *
 * @return string
 */
function get_fau_elemental_menu_html(): string
{
    global $elemental_menu;

    // Breadcrumb generieren
    $breadcrumb_html = generate_breadcrumb_for_menu();

    $html  = '';

    // Breadcrumb nur einfügen, wenn vorhanden
    if (!empty($breadcrumb_html)) {
        $html .= '<div class="fau-elemental-breadcrumb">';
        $html .= $breadcrumb_html;
        $html .= '</div>';
    }


    // Menücontainer mit Menü bleibt sauber getrennt
    $html .= '<div class="menu-meta-nav__modal__content">';
    $html .= render_elemental_menu($elemental_menu);
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
    // Organisation aus Customizer/Settings ermitteln
    $options = get_option('fau_orga_breadcrumb_options');
    $form_org = '';

    if (isset($options['site-orga'])) {
        $form_org = esc_attr($options['site-orga']);
    }

    if (empty($form_org)) {
        $form_org = get_fau_orga_by_theme();
    }

    // KEINE Breadcrumb auf FAU-Hauptebene (0000000000)
    if ($form_org === '0000000000') {
        return '';
    }

    // Normale Breadcrumb HTML generieren wie bei [fauorga]
    $breadcrumb_html = get_fau_orga_breadcrumb($form_org);

    if (empty($breadcrumb_html)) {
        return '';
    }

    // Website-Titel als zusätzliches Element hinzufügen
    $site_title = get_bloginfo('name');
    if (!empty($site_title)) {
                $breadcrumb_html = add_site_title_to_breadcrumb($breadcrumb_html, $site_title);
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
function add_site_title_to_breadcrumb(string $breadcrumb_html, string $site_title): string
{
    $site_title_li = '<li><span>' . esc_html($site_title) . '</span></li>';
    return str_replace('</ol>', $site_title_li . '</ol>', $breadcrumb_html);
}

/**
 * Prüft ob der FAU-Menüpunkt angezeigt werden soll
 * FAU-Link wird angezeigt außer auf FAU-Hauptebene (0000000000)
 *
 * @return bool True wenn FAU-Link angezeigt werden soll
 */
function should_show_fau_menu_item(): bool
{
    // Organisation aus Customizer/Settings ermitteln
    $options = get_option('fau_orga_breadcrumb_options');
    $form_org = '';

    if (isset($options['site-orga'])) {
        $form_org = esc_attr($options['site-orga']);
    }

    if (empty($form_org)) {
        $form_org = get_fau_orga_by_theme();
    }

    // NICHT anzeigen auf FAU-Hauptebene (0000000000)
    if ($form_org === '0000000000') {
        return false;
    }

    // Auf allen anderen Ebenen anzeigen
    return true;
}