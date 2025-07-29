<?php

namespace FAU\ORGA\Breadcrumb;

/**
 * Generiert ein hardcodiertes HTML Menü für FAU Elemental Theme
 *  * @return string Hardcodiertes HTML nach Vorgabe
 */
function get_fau_elemental_menu_html(): string
{
// Breadcrumb für Menü generieren (aus normaler Breadcrumb + Website-Titel)
    $breadcrumb_html = generate_breadcrumb_for_menu();

    // Prüfen ob wir auf FAU-Hauptebene sind
    $show_fau_link = should_show_fau_menu_item();


    $html = '<div id="structure-modal" class="menu-meta-nav__modal is-open" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="false" aria-label="Structure">
    <div class="menu-meta-nav__modal__overlay"></div>

    <div class="menu-meta-nav__modal__container">
        <div class="menu-meta-nav__modal__header">
            <button class="menu-meta-nav__modal__back-btn" aria-label="Back to main menu">
                <span class="menu-meta-nav__modal__back-icon"></span>
                <span class="menu-meta-nav__modal__back-text">Zurück</span>
            </button>

            <button class="menu-meta-nav__modal__close-btn" aria-label="Close menu">
                Schließen
                <span class="menu-meta-nav__modal__close-icon"></span>
            </button>
        </div>

        <div class="menu-meta-nav__modal__content">
                    <!-- Breadcrumb ÜBER der Menü-Liste-->
            <div class="menu-modal-breadcrumbs">';

    if (!empty($breadcrumb_html)) {
        $html .= $breadcrumb_html;
    }

    $html .= '
            
            <ul class="menu-meta-nav__menu menu-meta-nav__menu--hierarchy menu-meta-nav__menu--hierarchy--top-header-nav-structure">';

    // FAU-Link nur anzeigen, wenn nicht auf FAU-Hauptebene
    if ($show_fau_link) {
        $html .= '
                <li id="menu-item-381" class="menu-item menu-item-depth-0" data-menu-url="/fau" data-menu-item-id="381">
                    <a href="https://www.fau.de">FAU</a>
                </li>';
    }

            $html.='
                
                <li id="menu-item-382" class="menu-item-has-children menu-item menu-item-depth-0 has-children menu-item-expanded current-menu-item" data-menu-url="" data-menu-item-id="382">
                    <button class="menu-modal__submenu-toggle menu-modal__submenu-row" aria-expanded="false" aria-label="Open Fakultäten submenu" data-parent-url="#" data-parent-title="Fakultäten">
                        <span class="menu-modal__item-title">Fakultäten</span>
                        <span class="menu-modal__submenu-arrow"></span>
                    </button>
                    <ul class="sub-menu sub-menu--level-0">
                        <li id="menu-item-386" class="menu-item menu-item-depth-1" data-menu-url="/fakultaeten/phil" data-menu-item-id="386">
                            <a href="https://www.phil.fau.de">Philosophische Fakultät und Fachbereich Theologie</a>
                        </li>
                        <li id="menu-item-386" class="menu-item menu-item-depth-1" data-menu-url="/fakultaeten/rw" data-menu-item-id="386">
                            <a href="https://www.rw.fau.de">Rechts- und Wirtschaftswissenschaftliche Fakultät</a>
                        </li>
                        <li id="menu-item-387" class="menu-item menu-item-depth-1" data-menu-url="/fakultaeten/med" data-menu-item-id="387">
                            <a href="https://www.med.fau.de">Medizinische Fakultät</a>
                        </li>
                        <li id="menu-item-388" class="menu-item menu-item-depth-1" data-menu-url="/fakultaeten/nat" data-menu-item-id="388">
                            <a href="https://www.nat.fau.de">Naturwissenschaftliche Fakultät</a>
                        </li>
                        <li id="menu-item-389" class="menu-item menu-item-depth-1" data-menu-url="/fakultaeten/tf" data-menu-item-id="389">
                            <a href="https://www.tf.fau.de">Technische Fakultät</a>
                        </li>
                    </ul>
                </li>

                <li id="menu-item-383" class="menu-item-has-children menu-item menu-item-depth-0 has-children menu-item-expanded current-menu-item" data-menu-url="" data-menu-item-id="383">
                    <button class="menu-modal__submenu-toggle menu-modal__submenu-row" aria-expanded="false" aria-label="Open Zentrale Einrichtungen submenu" data-parent-url="#" data-parent-title="Zentrale Einrichtungen">
                        <span class="menu-modal__item-title">Zentrale Einrichtungen</span>
                        <span class="menu-modal__submenu-arrow"></span>
                    </button>
                    <ul class="sub-menu sub-menu--level-0">
                        <li id="menu-item-390" class="menu-item menu-item-depth-1" data-menu-url="/zentrale-einrichtungen/ub" data-menu-item-id="390">
                            <a href="https://ub.fau.de">Universitätsbibliothek</a>
                        </li>
                        <li id="menu-item-391" class="menu-item menu-item-depth-1" data-menu-url="/zentrale-einrichtungen/rrze" data-menu-item-id="391">
                            <a href="https://www.rrze.fau.de">Regionales Rechenzentrum Erlangen</a>
                        </li>
                        <li id="menu-item-392" class="menu-item menu-item-depth-1" data-menu-url="/zentrale-einrichtungen/graduiertenzentrum" data-menu-item-id="392">
                            <a href="#">Graduiertenzentrum der FAU</a>
                        </li>
                        <li id="menu-item-393" class="menu-item menu-item-depth-1" data-menu-url="/zentrale-einrichtungen/sprachenzentrum" data-menu-item-id="393">
                            <a href="#">Sprachenzentrum</a>
                        </li>
                        <li id="menu-item-394" class="menu-item menu-item-depth-1" data-menu-url="/zentrale-einrichtungen/uk" data-menu-item-id="394">
                            <a href="#">Universitätsklinikum</a>
                        </li>
                    </ul>
                </li>

                
<li id="menu-item-384" class="menu-item menu-item-depth-0" data-menu-url="/profilzentren" data-menu-item-id="384">
                    <a href="https://www.fau.de/outreach/innovationen-und-gruendungen/innovationsplattformen-und-netzwerke/">Profilzentren</a>
                </li>
<li id="menu-item-385" class="menu-item menu-item-depth-0" data-menu-url="/forschungszentren" data-menu-item-id="385">
                    <a href="https://www.fau.de/outreach/innovationen-und-gruendungen/innovationsplattformen-und-netzwerke/">Forschungszentren</a>
                </li>
                <li id="menu-item-386" class="menu-item menu-item-depth-0" data-menu-url="/kompetenzzentren" data-menu-item-id="386">
                    <a href="https://www.fau.de/outreach/innovationen-und-gruendungen/innovationsplattformen-und-netzwerke/">Kompetenzzentren</a>
                </li>
                <li id="menu-item-387" class="menu-item menu-item-depth-0" data-menu-url="/innovationsorte" data-menu-item-id="387">
                    <a href="https://www.fau.de/outreach/innovationen-und-gruendungen/innovationsplattformen-und-netzwerke/">Innovationsorte</a>
                </li>

            </ul>
        </div>
    </div>
</div>';

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