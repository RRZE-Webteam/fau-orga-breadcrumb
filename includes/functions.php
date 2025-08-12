<?php

namespace FAU\ORGA\Breadcrumb;


add_action(
    'customize_save_after',
    __NAMESPACE__ . '\\fau_orga_sync_on_customize_save_elemental',
    10,
    1
);

/*-----------------------------------------------------------------------------------*/
/* Globale Pluginfunktionen
/*-----------------------------------------------------------------------------------*/
$known_themes = array(
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
        'FAU-Elemental'
    ],
    'rrzethemes' => [
        'RRZE 2019',
    ],
);
$fau_orga_fautheme = get_fau_orga_fautheme();

/**
 * Synchronisiert die Plugin-Option "site-orga" nach dem Speichern im Customizer,
 * ausschließlich für das Theme FAU-Elemental.
 *
 */
function fau_orga_sync_on_customize_save_elemental(\WP_Customize_Manager $manager): void
{
    // Prüfen, ob das aktive Theme FAU-Elemental ist
    $theme = wp_get_theme();
    if (!$theme) {
        return;
    }

    $name       = (string) $theme->get('Name');
    $template   = strtolower((string) $theme->get_template());
    $stylesheet = strtolower((string) $theme->get_stylesheet());

    $isElemental = (strcasecmp($name, 'FAU-Elemental') === 0)
        || in_array($template, ['fau-elemental', 'fauelemental'], true)
        || in_array($stylesheet, ['fau-elemental', 'fauelemental'], true);

    if (!$isElemental) {
        return;
    }

    // Die frisch gespeicherten Werte aus dem Customizer laden.
    // post_value() wird bevorzugt, um Werte auch während des Speichervorgangs korrekt zu erhalten.
    $type    = (string) ($manager->post_value('faue_website_type') ?? get_theme_mod('faue_website_type', ''));
    $faculty = (string) ($manager->post_value('faue_faculty') ?? get_theme_mod('faue_faculty', ''));

    // Plugin-Optionen laden
    $options     = get_option('fau_orga_breadcrumb_options', []);
    $options     = is_array($options) ? $options : [];
    $currentOrg  = isset($options['site-orga']) ? (string) $options['site-orga'] : '';

    // Fall 1: Root-Seite der FAU oder Kooperation → Zuordnung löschen
    if ($type === 'fau' || $type === 'cooperation') {
        if ($currentOrg !== '') {
            $options['site-orga'] = '';
            update_option('fau_orga_breadcrumb_options', $options);
        }
        return;
    }

    // Fall 2: Fakultätskontext → neue Orga ermitteln und ggf. speichern
    $isFacultyContext = in_array($type, ['faculty', 'chair'], true) || ($type === 'other' && $faculty !== '');
    if ($isFacultyContext) {
        // Fakultäts-ID in FAU.ORG-Organisationseinheit umwandeln
        $newOrg = $faculty !== '' ? (string) get_fau_orga_fauorg_by_faculty($faculty) : '';

        // Nur aktualisieren, wenn sich der Wert geändert hat und nicht leer ist
        if ($newOrg !== '' && $newOrg !== $currentOrg) {
            $options['site-orga'] = $newOrg;
            update_option('fau_orga_breadcrumb_options', $options);
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* Admin Notice auf Dashboard, damit man die ORGA Breadcrumb setzt
/*-----------------------------------------------------------------------------------*/
function fau_orga_admin_notice(): void
{
    global $pagenow;
    global $fau_orga_fautheme;

    $website_type = get_theme_mod("website_type");

    if (isset($website_type)) {
        if (($website_type == -1) || ($website_type == 3) || ($website_type == 0)) {
            return;
        }
    }
    $form_org = '';
    $options = get_option('fau_orga_breadcrumb_options');
    if (isset($options['site-orga'])) {
        $form_org = esc_attr($options['site-orga']);
    }
    // Wenn wir in einem FAU Theme sind
    // UND der Website-Type = 1 (Einrichtung einer Fakultät) ist
    // UND noch keine Zuordnung erfolgte,
    // dann zeige den Hinweis, dass man doch bitte eine Zuordnung machen soll


    if (empty($form_org)) {
        if ($pagenow == 'index.php') {
            $user = wp_get_current_user();
            if (in_array('administrator', (array)$user->roles)) {
                echo '<div class="notice notice-warning">';
                echo __('Der Webauftritt ist noch nicht organisatorisch eingeordnet. <br>Bitte rufen Sie die <a href="options-general.php?page=fau_orga_breadcrumb_settings">Einstellung FAU.ORG Breadcrumb</a> auf und geben Sie an, welcher organisatorischen Einheit der Webauftritt angehört.', 'fau-orga-breadcrumb');
                echo '</div>';

            }
        }
    }


}

add_action('admin_notices', __NAMESPACE__ . '\\fau_orga_admin_notice');


/**
 * Prüft, ob das aktuell aktive Theme das FAU-Elemental Theme ist.
 *
 * Erkennt sowohl das Parent Theme "FAU-Elemental" als auch Child Themes,
 * die auf dem Template-Verzeichnis "fau-elemental" basieren.
 *
 * @return bool true, wenn FAU-Elemental (oder Child-Theme davon) aktiv ist
 */
function fau_is_elemental_theme(): bool
{
    // Aktuelles Theme-Objekt ermitteln
    $theme = wp_get_theme();
    if (!$theme) {
        return false;
    }

    // Theme-Name aus style.css (z. B. "FAU-Elemental")
    $name = (string)$theme->get('Name');

    // Template-Ordner (Parent Theme Slug, z. B. "fau-elemental")
    $template = (string)$theme->get_template();

    // Stylesheet-Ordner (aktives Theme-Verzeichnis, kann Child oder Parent sein)
    $stylesheet = (string)$theme->get_stylesheet();

    // Vergleich: Entweder Name exakt "FAU-Elemental" (Groß-/Kleinschreibung egal)
    $nameMatch = (strcasecmp($name, 'FAU-Elemental') === 0);

    // Oder Template-/Stylesheet-Ordner ist "fau-elemental" (Slug)
    $dirMatch = in_array(strtolower($template), ['fau-elemental', 'fauelemental'], true)
        || in_array(strtolower($stylesheet), ['fau-elemental', 'fauelemental'], true);

    return $nameMatch || $dirMatch;
}

/**
 * Liefert den in den Theme-Einstellungen gesetzten Website-Typ.
 * Mögliche Werte: 'fau', 'faculty', 'chair', 'other', 'cooperation'
 *
 * @return string Website-Typ aus Customizer
 */
function fau_elemental_site_type(): string
{
    return (string)get_theme_mod('faue_website_type', '');
}

/**
 * Liefert die in den Theme-Einstellungen gesetzte Fakultät.
 * Mögliche Werte: 'phil', 'nat', 'med', 'rw', 'tf' oder leer
 *
 * @return string Fakultäts-Slug aus Customizer
 */
function fau_elemental_faculty_slug(): string
{
    return (string)get_theme_mod('faue_faculty', '');
}

/*-----------------------------------------------------------------------------------*/
/* Get FAU.ORG by faculty
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_fauorg_by_faculty($faculty = '')
{
    global $fau_orga_breadcrumb_data;
    $res = '';
    // $fauorg = san_fauorg_number($fauorg);
    if (isset($faculty)) {
        foreach ($fau_orga_breadcrumb_data as $key => $listdata) {
            if (isset($listdata['faculty']) && ($listdata['faculty'] == $faculty)) {
                $res = $key;
                break;
            }
        }
    }
    return $res;
}

/*-----------------------------------------------------------------------------------*/
/* Get child elements
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_childs($fauorg = '000000000')
{
    global $fau_orga_breadcrumb_data;
    $res = array();
    // $fauorg = san_fauorg_number($fauorg);
    if (isset($fauorg)) {
        foreach ($fau_orga_breadcrumb_data as $key => $listdata) {
            if (isset($listdata['parent']) && ($listdata['parent'] == $fauorg)) {
                $res[] = $key;
            }
        }
    }
    return $res;
}

/*-----------------------------------------------------------------------------------*/
/* get next upper class
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_upperclass($fauorg = '')
{
    global $fau_orga_breadcrumb_data;
    $res = '';
    $fauorg = san_fauorg_number($fauorg);

    if (isset($fauorg)) {

        if (isset($fau_orga_breadcrumb_data[$fauorg])) {

            if (isset($fau_orga_breadcrumb_data[$fauorg]['class'])) {
                $res = $fau_orga_breadcrumb_data[$fauorg]['class'];
            } else {
                $parent = '';
                if (isset($fau_orga_breadcrumb_data[$fauorg]['parent'])) {
                    $parent = $fau_orga_breadcrumb_data[$fauorg]['parent'];
                }

                while ($parent) {

                    if (isset($fau_orga_breadcrumb_data[$parent]['class'])) {
                        $res = $fau_orga_breadcrumb_data[$parent]['class'];
                        $parent = '';
                        break;
                    }
                    if (isset($fau_orga_breadcrumb_data[$parent]['parent'])) {
                        $parent = $fau_orga_breadcrumb_data[$parent]['parent'];
                    } else {
                        $parent = '';
                        break;
                    }
                }
            }

        }

    }
    return $res;
}

/*-----------------------------------------------------------------------------------*/
/* create option list for forms
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_form_optionlist($fauorg = '000000000', $preorg = '000000000', $level = 0, $maxdepth = 4)
{
    global $fau_orga_breadcrumb_data;
    global $fau_orga_breadcrumb_config;


    $fauorg = san_fauorg_number($fauorg);

    if (isset($preorg)) {
        $org = san_fauorg_number($preorg);
    }

    $res = '';
    $faculty = get_fau_faculty_by_theme();
    $website_type = get_theme_mod("website_type");

    $firstlevel = get_fau_orga_childs($fauorg);

    if (!empty($firstlevel)) {
        foreach ($firstlevel as $key) {
            if (!empty($faculty)) {
                if (($faculty !== 'zentral') && isset($fau_orga_breadcrumb_data[$key]['faculty']) && ($fau_orga_breadcrumb_data[$key]['faculty'] !== $faculty)) {
                    // wenn wir in einem Fakultatstheme sind, dann lasse alle Einrichtungen die zu anderen Fakultaeten gehören, weg
                    continue;
                }
                if (($faculty == 'zentral') && isset($fau_orga_breadcrumb_data[$key]['faculty'])) {
                    // wenn wir im Zentralbereich sind, dann lasse alle Einträge, die Fakultäten ungeordnet sind, weg
                    continue;
                }
            }


            $orgclass = get_fau_orga_upperclass($key);

            if ($orgclass) {
                $class = 'depth-' . $level . ' ' . $orgclass;
            } else {
                $class = 'depth-' . $level;
            }

            $res .= '<option class="' . $class . '" value="' . $key . '" ' . selected($org, $key, false);
            if (isset($fau_orga_breadcrumb_data[$key]['hide']) && ($fau_orga_breadcrumb_data[$key]['hide'] === true)) {
                $res .= ' disabled';
            }

            $res .= '>' . $fau_orga_breadcrumb_data[$key]['title'] . '</option>';


            if ($level < $maxdepth) {

                $nextlevel = $level + 1;
                $sublist = get_fau_orga_childs($key);
                if (!empty($sublist)) {
                    $res .= get_fau_orga_form_optionlist($key, $preorg, $nextlevel, $maxdepth);
                }
            }

        }
    }
    return $res;
}

/*-----------------------------------------------------------------------------------*/
/* create list for customizer
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_breadcrumb_customizer_choices()
{
    global $fau_orga_breadcrumb_data;

    $res = array();
    foreach ($fau_orga_breadcrumb_data as $key => $listdata) {
        if (isset($listdata['title'])) {
            $res[$key] = $listdata['title'];
        }
    }
    return $res;
}

/*-----------------------------------------------------------------------------------*/
/* sanitize FAU.ORG Number
/*-----------------------------------------------------------------------------------*/
if (!function_exists('san_fauorg_number')) :
    function san_fauorg_number($s)
    {
        return filter_var(trim($s), FILTER_SANITIZE_NUMBER_INT);
    }
endif;
/*-----------------------------------------------------------------------------------*/
/* create breadcrumb
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_breadcrumb($form_org)
{
    global $fau_orga_breadcrumb_data;

    if (empty($form_org)) {
        $form_org = get_fau_orga_by_theme();
    }

    $schema_listattr = ' itemprop="itemListElement" itemscope  itemtype="https://schema.org/ListItem"';


    if ((isset($form_org)) && (isset($fau_orga_breadcrumb_data[$form_org]))) {
        $path = array();
        $path[] = $fau_orga_breadcrumb_data[$form_org];
        if (isset($fau_orga_breadcrumb_data[$form_org]['parent'])) {
            $parent = $fau_orga_breadcrumb_data[$form_org]['parent'];


            while (!empty($parent)) {
                if ((isset($fau_orga_breadcrumb_data[$parent]['hide'])) && ($fau_orga_breadcrumb_data[$parent]['hide'] == true)) {
                    // dont add this to the path
                } else {
                    $path[] = $fau_orga_breadcrumb_data[$parent];
                }
                if (isset($fau_orga_breadcrumb_data[$parent]['parent'])) {
                    $parent = $fau_orga_breadcrumb_data[$parent]['parent'];
                } else {
                    $parent = '';
                }
            }
        }

        $breadcrumb = array_reverse($path);
        $position = 1;
        $entry = '';
        $line = '';

        foreach ($breadcrumb as $value) {
            $entry = '<li' . $schema_listattr . '>';
            if (isset($value['url'])) {
                $entry .= '<a itemprop="item"  href="' . esc_url($value['url']) . '" data-wpel-link="internal">';
            } else {
                $entry .= '<span itemprop="item">';
            }
            $entry .= '<span itemprop="name">' . $value['title'] . '</span>';
            if (isset($value['url'])) {
                $entry .= '</a>';
            } else {
                $entry .= '</span>';
            }
            $entry .= '<meta itemprop="position" content="' . $position . '" />';
            $position++;
            $entry .= '</li>';

            $line .= $entry;
        }

        $res = '<nav class="orga-breadcrumb" aria-label="' . __('Organisatorische Navigation', 'fau-orga-breadcrumb') . '">';
        $res .= '<ol class="breadcrumblist" itemscope itemtype="https://schema.org/BreadcrumbList">';
        $res .= $line;
        $res .= '</ol>';
        $res .= '</nav>';

        return $res;
    }
    return;
}

/*-----------------------------------------------------------------------------------*/
/* get FAU Theme to find out if the website belongs to a faculty
 * returns
 *     false   if no FAU theme
 *        the string with the faculty nat,phil,tf,rw,med   if one of the faculty theme
 *        the string zentral  if other FAU Theme
 */
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_fautheme()
{
    global $known_themes;

    $active_theme = wp_get_theme();
    if ($active_theme->exists()) {
        $themename = $active_theme->get('Name');


        if (isset($known_themes) && isset($known_themes['fauthemes'])) {
            if (in_array($themename, $known_themes['fauthemes'])) {

                switch ($active_theme) {
                    case 'FAU-Philfak':
                        $res = 'phil';
                        break;
                    case 'FAU-RWFak':
                        $res = 'rw';
                        break;
                    case 'FAU-Natfak':
                        $res = 'nat';
                        break;
                    case 'FAU-Medfak':
                        $res = 'med';
                        break;
                    case 'FAU-Techfak':
                        $res = 'tf';
                        break;
                    default:
                        $res = 'zentral';
                }
                return $res;
            }
        }
    }
    return false;

}


/**
 * Ermittelt das Fakultäts-Kürzel anhand des aktiven Themes.
 *
 * Funktioniert sowohl für alte FAU-Themes (Erkennung über Theme-Namen und website_type)
 * als auch für das neue FAU Elemental Theme (Erkennung über Customizer-Einstellungen).
 *
 * Rückgabewerte:
 *  - 'phil','nat','med','rw','tf' → eine der Fakultäten
 *  - 'zentral' → zentrale Einrichtung / FAU.de
 *  - '' → keine Zuordnung möglich oder keine Anzeige gewünscht
 *
 * @return string Fakultäts-Kürzel oder leer.
 */
function get_fau_faculty_by_theme(): string
{
    // ------------------------------------------------------------
    // 1) Prüfen, ob FAU-Elemental aktiv ist (Name oder Template/Stylesheet)
    // ------------------------------------------------------------
    $theme = wp_get_theme();
    $isElemental = false;

    if ($theme) {
        $name = (string)$theme->get('Name');        // z. B. "FAU-Elemental"
        $template = (string)$theme->get_template();     // z. B. "fau-elemental"
        $stylesheet = (string)$theme->get_stylesheet();   // z. B. "fau-elemental" oder Child

        // Erkennung per Name (Groß-/Kleinschreibung ignorieren) ODER per Verzeichnis-Slug
        if (strcasecmp($name, 'FAU-Elemental') === 0) {
            $isElemental = true;
        } elseif (in_array(strtolower($template), ['fau-elemental', 'fauelemental'], true)) {
            $isElemental = true;
        } elseif (in_array(strtolower($stylesheet), ['fau-elemental', 'fauelemental'], true)) {
            $isElemental = true;
        }
    }

    // ------------------------------------------------------------
    // 2) FAU-Elemental: Werte aus dem Customizer lesen und interpretieren
    //    - faue_website_type: 'fau','faculty','chair','other','cooperation'
    //    - faue_faculty:      'phil','nat','med','rw','tf' oder leer
    // ------------------------------------------------------------
    if ($isElemental) {
        $siteType = (string)get_theme_mod('faue_website_type', '');
        $faculty = (string)get_theme_mod('faue_faculty', '');

        // FAU.de (Root) → Zentralbereich
        if ($siteType === 'fau') {
            return 'zentral';
        }

        // Fakultäts- oder Lehrstuhl-Auftritt → Fakultät muss gesetzt sein
        if (in_array($siteType, ['faculty', 'chair'], true) && $faculty !== '') {
            return $faculty;
        }

        // Department-Ebene im Elemental (kein eigener Typ):
        // "other" + gesetzte Fakultät wird als Department-Kontext interpretiert
        if ($siteType === 'other' && $faculty !== '') {
            return $faculty;
        }

        // Kooperationen → keine Orga-Breadcrumb
        if ($siteType === 'cooperation') {
            return '';
        }

        // Unbekannt/leer → keine Einschränkung
        return '';
    }

    // ------------------------------------------------------------
    // 3) Alte FAU-Themes (Legacy): numerischer website_type + ggf. Child-Theme-Erkennung
    //    - 0 = Fakultätsportal (nur Root)  → 'zentral'
    //    - 2 = Zentrale Einrichtung        → 'zentral'
    //    - sonst: per get_fau_orga_fautheme() Fakultät ableiten
    // ------------------------------------------------------------
    $websiteType = get_theme_mod('website_type');

    if (isset($websiteType)) {
        if ($websiteType === 0 || $websiteType === 2) {
            // Fakultätsportal oder Zentrale Einrichtung → Zentralbereich
            return 'zentral';
        }

        // Versuche Fakultät über FAU-Child-Theme zu ermitteln
        $fautheme = get_fau_orga_fautheme(); // liefert z. B. 'phil','nat','med','rw','tf' oder 'zentral' / false
        if ($fautheme) {
            // Optionales Debug-Override (wie bisher)
            $debug = get_theme_mod('debug_website_fakultaet');
            if (isset($debug) && $debug !== false) {
                return (string)$debug;
            }
            return $fautheme;
        }
    } else {
        // Kein website_type gesetzt → reine Child-Theme-Erkennung
        $fautheme = get_fau_orga_fautheme();
        if ($fautheme) {
            return $fautheme;
        }
    }

    // ------------------------------------------------------------
    // 4) Keine Zuordnung möglich
    // ------------------------------------------------------------
    return '';
}

/*-----------------------------------------------------------------------------------*/
/* get fau orga by theme
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_by_theme()
{
    $faculty = get_fau_faculty_by_theme();
    return get_fau_orga_fauorg_by_faculty($faculty);
}

/*-----------------------------------------------------------------------------------*/
/* enqueue with filter by theme
/*-----------------------------------------------------------------------------------*/
function fau_orga_enqueue_style($style = 'fau-orga-breadcrumb')
{

    $active_theme = wp_get_theme();
    $theme_name = $active_theme->get('Name');

    global $known_themes;

    // 1️⃣ Wenn FAU Elemental aktiv ist → spezielles CSS laden
    if ($theme_name === 'FAU-Elemental') {
        wp_enqueue_style(
            'fau-orga-breadcrumb-elemental',
            plugin_dir_url(__DIR__) . 'css/fau-orga-breadcrumb.css',
            [],
            '1.0'
        );

        // 2️⃣ Wenn andere FAU-Themes aktiv sind → KEIN CSS (wie bisher)
    } elseif (in_array($theme_name, $known_themes['fauthemes'])) {
        return;

        // 3️⃣ Alle anderen Themes → Standard-Breadcrumb-CSS laden
    } else {
        wp_enqueue_style($style);
    }
}

// Enqueue Breadcrumb Styles im Frontend laden
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\fau_orga_enqueue_style', 99);


