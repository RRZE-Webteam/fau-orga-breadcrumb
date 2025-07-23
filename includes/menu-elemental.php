<?php

namespace FAU\ORGA\Breadcrumb;


/**
 * Generiert ein HTML Menü auf der Grundlage der FAU Elemental Menüstruktur.
 *
 * @param array $item
 * @param int $id
 * @param int $depth
 * @return string
 */
function get_fau_elemental_menu_html(): string
{
    
    global $fau_elemental_menu_structure;

    $html = '<div id="structure-modal" class="menu-meta-nav__modal is-open" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="false" aria-label="Structure">';
    $html .= '<div class="menu-meta-nav__modal__overlay"></div>';

    $html .= '<div class="menu-meta-nav__modal__container">';
    $html .= '<div class="menu-meta-nav__modal__header">';
    $html .= '<button class="menu-meta-nav__modal__back-btn" aria-label="Back to main menu">';
    $html .= '<span class="menu-meta-nav__modal__back-icon"></span>';
    $html .= '<span class="menu-meta-nav__modal__back-text">Zurück</span>';
    $html .= '</button>';

    $html .= '<button class="menu-meta-nav__modal__close-btn" aria-label="Close menu">';
    $html .= 'Schließen';
    $html .= '<span class="menu-meta-nav__modal__close-icon"></span>';
    $html .= '</button>';
    $html .= '</div>';

    $html .= '<div class="menu-meta-nav__modal__content">';
    $html .= '<ul class="menu-meta-nav__menu menu-meta-nav__menu--hierarchy menu-meta-nav__menu--hierarchy--top-header-nav-structure">';

    $id = 382;
    foreach ($fau_elemental_menu_structure as $category) {
        $html .= generate_category_item_html($category, $id, 0);
        $id++;
    }

    $html .= '</ul>';
    $html .= '</div></div></div>';

    return $html;
}


/**
 * Vereinfachter HTML-Generator für die 6 Hauptkategorien
 *  */
function generate_category_item_html(array $item, int $id, int $depth): string
{
    $hasChildren = !empty($item['children']);
    $classes = [
        'menu-item',
        'menu-item-depth-' . $depth,
    ];

    if ($hasChildren) {
        $classes[] = 'menu-item-has-children';
        $classes[] = 'has-children';
        $classes[] = 'menu-item-expanded';
    }

    if ($depth === 0) {
        $classes[] = 'current-menu-item';
    }

    $html = '<li id="menu-item-' . esc_attr($id) . '" class="' . implode(' ', $classes) . '"';
    $html .= ' data-menu-url="' . esc_attr($item['url'] ?? '') . '"';
    $html .= ' data-menu-item-id="' . esc_attr($id) . '">';

    if ($hasChildren) {
        $html .= '<button class="menu-modal__submenu-toggle menu-modal__submenu-row"';
        $html .= ' aria-expanded="false"';
        $html .= ' aria-label="Open ' . esc_attr($item['title']) . ' submenu"';
        $html .= ' data-parent-url="' . esc_attr($item['url'] ?? '#') . '"';
        $html .= ' data-parent-title="' . esc_attr($item['title']) . '">';
        $html .= '<span class="menu-modal__item-title">' . esc_html($item['title']) . '</span>';
        $html .= '<span class="menu-modal__submenu-arrow"></span>';
        $html .= '</button>';

        $html .= '<ul class="sub-menu sub-menu--level-' . esc_attr($depth) . '">';
        $childId = $id * 10 + 1;
        foreach ($item['children'] as $child) {
            $html .= generate_category_item_html($child, $childId, $depth + 1);
            $childId++;
        }
        $html .= '</ul>';
    } else {
        $html .= '<a href="' . esc_url($item['url'] ?? '#') . '">' . esc_html($item['title']) . '</a>';
    }

    $html .= '</li>';

    return $html;
}
