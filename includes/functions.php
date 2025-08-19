<?php

namespace FAU\ORGA\Breadcrumb;


/*-----------------------------------------------------------------------------------*/
/* Globale Plugin-Variablen
/*-----------------------------------------------------------------------------------*/
/** @var array Namen bekannter FAU-/RRZE-Themes (für Erkennung/Kompatibilität) */
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

//*-----------------------------------------------------------------------------------*/
/* Customizer-Sync für FAU-Elemental
/*-----------------------------------------------------------------------------------*/

/**
 * Synchronisiert die Plugin-Option "site-orga" nach dem Speichern im Customizer (nur FAU-Elemental).
 *
 * @param \WP_Customize_Manager $manager
 * @return void
 */
function fau_orga_sync_on_customize_save_elemental(\WP_Customize_Manager $manager): void
{
    // Aktives Theme prüfen
    $theme = wp_get_theme();
    if (!$theme) {
        return;
    }

    $name = (string)$theme->get('Name');
    $template = strtolower((string)$theme->get_template());
    $stylesheet = strtolower((string)$theme->get_stylesheet());

    $isElemental = (strcasecmp($name, 'FAU-Elemental') === 0)
        || in_array($template, ['fau-elemental', 'fauelemental'], true)
        || in_array($stylesheet, ['fau-elemental', 'fauelemental'], true);

    if (!$isElemental) {
        return;
    }

    // Frisch gespeicherte Werte direkt aus dem Customizer lesen
    $type = (string)($manager->post_value('faue_website_type') ?? get_theme_mod('faue_website_type', ''));
    $faculty = (string)($manager->post_value('faue_faculty') ?? get_theme_mod('faue_faculty', ''));

    // Plugin-Optionen laden
    $options = get_option('fau_orga_breadcrumb_options', []);
    $options = is_array($options) ? $options : [];
    $currentOrg = isset($options['site-orga']) ? (string)$options['site-orga'] : '';

    // FAU-Root oder Kooperation → Zuordnung löschen
    if ($type === 'fau' || $type === 'cooperation') {
        if ($currentOrg !== '') {
            $options['site-orga'] = '';
            update_option('fau_orga_breadcrumb_options', $options);
        }
        return;
    }

    // Fakultäts-Kontext → Orga ermitteln und aktualisieren
    $isFacultyContext = in_array($type, ['faculty', 'chair'], true) || ($type === 'other' && $faculty !== '');
    if ($isFacultyContext) {
        // Fakultäts-ID in FAU.ORG-Organisationseinheit umwandeln
        $newOrg = $faculty !== '' ? (string)get_fau_orga_fauorg_by_faculty($faculty) : '';
        if ($newOrg !== '' && $newOrg !== $currentOrg) {
            $options['site-orga'] = $newOrg;
            update_option('fau_orga_breadcrumb_options', $options);
        }
    }
}

/*-----------------------------------------------------------------------------------*/
/* Admin Notice – Hinweis, wenn Zuordnung fehlt
/*-----------------------------------------------------------------------------------*/
/**
 * Zeigt Admin-Hinweis auf dem Dashboard, wenn noch keine Orga-Zuordnung gesetzt ist.
 *
 * @return void
 */
function fau_orga_admin_notice(): void
{
    global $pagenow;
//    global $fau_orga_fautheme;

    $website_type = get_theme_mod("website_type");

    // Für zentrale Portale, Kooperationen und Fakultätsportale nicht anzeigen
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


/*-----------------------------------------------------------------------------------*/
/* Theme-Erkennung FAU-Elemental
/*-----------------------------------------------------------------------------------*/

/**
 * Prüft, ob FAU-Elemental (oder Child) aktiv ist.
 *
 * @return bool
 */
function fau_is_elemental_theme(): bool
{
    // Aktuelles Theme-Objekt ermitteln
    $theme = wp_get_theme();
    if (!$theme) {
        return false;
    }

    $name = (string)$theme->get('Name');
    $template = strtolower((string)$theme->get_template());
    $stylesheet = strtolower((string)$theme->get_stylesheet());

    $nameMatch = (strcasecmp($name, 'FAU-Elemental') === 0);
    $dirMatch = in_array($template, ['fau-elemental', 'fauelemental'], true)
        || in_array($stylesheet, ['fau-elemental', 'fauelemental'], true);

    return $nameMatch || $dirMatch;
}

/*-----------------------------------------------------------------------------------*/
/* Elemental-Helfer: Website-Typ & Fakultät
/*-----------------------------------------------------------------------------------*/

/**
 * Liefert den Elemental-Website-Typ: 'fau', 'faculty', 'chair', 'other', 'cooperation'.
 *
 * @return string
 */
function fau_elemental_site_type(): string
{
    return (string)get_theme_mod('faue_website_type', '');
}

/**
 * Liefert die Elemental-Fakultät: 'phil','nat','med','rw','tf' oder ''.
 *
 * @return string
 */
function fau_elemental_faculty_slug(): string
{
    return (string)get_theme_mod('faue_faculty', '');
}

/*-----------------------------------------------------------------------------------*/
/* Mapping: Fakultät → FAU.ORG-ID
/*-----------------------------------------------------------------------------------*/
/**
 * Ermittelt die FAU.ORG-ID für eine gegebene Fakultät (z. B. 'phil' → '1100000000').
 *
 * @param string $faculty Fakultäts-Slug.
 * @return string FAU.ORG-ID oder ''.
 */
function get_fau_orga_fauorg_by_faculty($faculty = ''): string
{
    global $fau_orga_breadcrumb_data;

    if (!isset($faculty) || $faculty === '') {
        return '';
    }

    foreach ($fau_orga_breadcrumb_data as $key => $listdata) {
        if (isset($listdata['faculty']) && ($listdata['faculty'] === $faculty)) {
            return (string)$key;
        }
    }
    return '';
}

/*-----------------------------------------------------------------------------------*/
/* Kinder einer Orga ermitteln
/*-----------------------------------------------------------------------------------*/
/**
 * Liefert alle direkten Kind-IDs einer Orga.
 *
 * @param string $fauorg FAU.ORG-ID.
 * @return array<string> Liste der Kind-IDs.
 */
function get_fau_orga_childs($fauorg = '000000000'): array
{
    global $fau_orga_breadcrumb_data;

    $res = [];
    if (!isset($fauorg) || $fauorg === '') {
        return $res;
    }

    foreach ($fau_orga_breadcrumb_data as $key => $listdata) {
        if (isset($listdata['parent']) && ($listdata['parent'] === $fauorg)) {
            $res[] = $key;
        }
    }
    return $res;
}


/*-----------------------------------------------------------------------------------*/
/* Oberklasse (Farbklasse) ermitteln
/*-----------------------------------------------------------------------------------*/
/**
 * Ermittelt die nächsthöhere CSS-Klasse (z. B. 'phil','nat',...).
 *
 * @param string $fauorg FAU.ORG-ID.
 * @return string Klasse oder ''.
 */
function get_fau_orga_upperclass($fauorg = ''): string
{
    global $fau_orga_breadcrumb_data;

    $res = '';
    $fauorg = san_fauorg_number($fauorg);

    if (!isset($fauorg) || $fauorg === '') {
        return '';
    }

    if (!isset($fau_orga_breadcrumb_data[$fauorg])) {
        return '';
    }

    if (isset($fau_orga_breadcrumb_data[$fauorg]['class'])) {
        return (string)$fau_orga_breadcrumb_data[$fauorg]['class'];
    }

    $parent = $fau_orga_breadcrumb_data[$fauorg]['parent'] ?? '';

    while ($parent !== '') {
        if (isset($fau_orga_breadcrumb_data[$parent]['class'])) {
            $res = (string)$fau_orga_breadcrumb_data[$parent]['class'];
            $parent = '';
            break;
        }
        $parent = $fau_orga_breadcrumb_data[$parent]['parent'] ?? '';
    }

    return $res;
}


/*-----------------------------------------------------------------------------------*/
/* Optionsliste (Select) aufbauen
/*-----------------------------------------------------------------------------------*/
/**
 * Erzeugt die HTML-Options (<option>) rekursiv für das Select.
 *
 * @param string $fauorg Startknoten (Root).
 * @param string $preorg Vorausgewählte Orga.
 * @param int $level Rekursionstiefe.
 * @param int $maxdepth Maximale Tiefe.
 * @return string HTML mit <option>-Einträgen.
 */
function get_fau_orga_form_optionlist($fauorg = '0000000000', $preorg = '0000000000', $level = 0, $maxdepth = 4): string
{
    global $fau_orga_breadcrumb_data;

    $fauorg = san_fauorg_number($fauorg);
    $org = isset($preorg) ? san_fauorg_number($preorg) : '';

    $res = '';
    $faculty = get_fau_faculty_by_theme();
    $children = get_fau_orga_childs($fauorg);
    if (empty($children)) {
        return '';
    }

    foreach ($children as $key) {
        // --- Filter / Verhalten je nach Kontext ---
        $skip_render = false;

        if (!empty($faculty)) {
            // Fakultätskontext: nur eigene Fakultät anzeigen
            if ($faculty !== 'zentral'
                && isset($fau_orga_breadcrumb_data[$key]['faculty'])
                && $fau_orga_breadcrumb_data[$key]['faculty'] !== $faculty) {
                continue;
            }

            // Zentral: Fakultätsknoten NICHT rendern, aber in die Kinder absteigen
            if ($faculty === 'zentral'
                && isset($fau_orga_breadcrumb_data[$key]['faculty'])) {
                $skip_render = true;
            }
        }

        // --- Option rendern (falls nicht übersprungen) ---
        if (!$skip_render) {
            $orgclass = get_fau_orga_upperclass($key);
            $class = 'depth-' . $level . ($orgclass ? (' ' . $orgclass) : '');

            $res .= '<option class="' . esc_attr($class) . '" value="' . esc_attr($key) . '" ' . selected($org, $key, false);
            if (!empty($fau_orga_breadcrumb_data[$key]['hide'])) {
                $res .= ' disabled';
            }
            $title = isset($fau_orga_breadcrumb_data[$key]['title']) ? $fau_orga_breadcrumb_data[$key]['title'] : $key;
            $res .= '>' . esc_html($title) . '</option>';
        }

        // --- IMMER weiter in die Tiefe gehen, auch wenn dieser Knoten nicht gerendert wurde ---
        if ($level < $maxdepth) {
            $nextlevel = $level + 1;
            // direkt rekursiv in die Kinder dieses Knotens
            $res .= get_fau_orga_form_optionlist($key, $preorg, $nextlevel, $maxdepth);
        }
    }

    return $res;
}

/*-----------------------------------------------------------------------------------*/
/* Choices für den (Legacy-)Customizer
/*-----------------------------------------------------------------------------------*/
/**
 * Liefert eine flache Key=>Label-Liste aller Orgas (für alte Customizer-Controls).
 *
 * @return array<string,string>
 */
function get_fau_orga_breadcrumb_customizer_choices(): array
{
    global $fau_orga_breadcrumb_data;

    $res = [];
    foreach ($fau_orga_breadcrumb_data as $key => $listdata) {
        if (isset($listdata['title'])) {
            $res[$key] = $listdata['title'];
        }
    }
    return $res;
}

/*-----------------------------------------------------------------------------------*/
/* Sanitizer
/*-----------------------------------------------------------------------------------*/
/**
 * Sanitize einer FAU.ORG-Nummer (nur Ziffern zulassen).
 *
 * @param string $s
 * @return string
 */
if (!function_exists('san_fauorg_number')) :
    function san_fauorg_number($s): string
    {
        return (string)filter_var(trim((string)$s), FILTER_SANITIZE_NUMBER_INT);
    }
endif;

/*-----------------------------------------------------------------------------------*/
/* Breadcrumb erzeugen
/*-----------------------------------------------------------------------------------*/
/**
 * Erzeugt die Breadcrumb-HTML für eine Orga (oder die aus dem Theme ermittelte).
 *
 * @param string $form_org FAU.ORG-ID, optional.
 * @return string|null HTML der Breadcrumb oder null.
 */
function get_fau_orga_breadcrumb($form_org)
{
    global $fau_orga_breadcrumb_data;

    if (empty($form_org)) {
        $form_org = get_fau_orga_by_theme();
    }

    if (!isset($form_org) || !isset($fau_orga_breadcrumb_data[$form_org])) {
        return null;
    }

    $schema_listattr = ' itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"';

    // Pfad nach oben sammeln
    $path = [];
    $path[] = $fau_orga_breadcrumb_data[$form_org];

    $parent = $fau_orga_breadcrumb_data[$form_org]['parent'] ?? '';
    while ($parent !== '') {
        if (empty($fau_orga_breadcrumb_data[$parent]['hide'])) {
            $path[] = $fau_orga_breadcrumb_data[$parent];
        }
        $parent = $fau_orga_breadcrumb_data[$parent]['parent'] ?? '';
    }

    $breadcrumb = array_reverse($path);
    $position = 1;
    $line = '';

    foreach ($breadcrumb as $value) {
        $entry = '<li' . $schema_listattr . '>';
        if (!empty($value['url'])) {
            $entry .= '<a itemprop="item" href="' . esc_url($value['url']) . '">';
        } else {
            $entry .= '<span itemprop="item">';
        }
        $title = isset($value['title']) ? $value['title'] : '';
        $entry .= '<span itemprop="name">' . esc_html($title) . '</span>'; // ✅ esc_html ergänzt
        $entry .= !empty($value['url']) ? '</a>' : '</span>';
        $entry .= '<meta itemprop="position" content="' . (int)$position . '" />';
        $entry .= '</li>';
        $position++;

        $line .= $entry;
    }

    $res = '<nav class="orga-breadcrumb" aria-label="' . esc_attr__('Organisatorische Navigation', 'fau-orga-breadcrumb') . '">'; // ✅ esc_attr__
    $res .= '<ol class="breadcrumblist" itemscope itemtype="https://schema.org/BreadcrumbList">';
    $res .= $line;
    $res .= '</ol>';
    $res .= '</nav>';

    return $res;
}


/*-----------------------------------------------------------------------------------*/
/* FAU-Theme → Fakultät ableiten
/*-----------------------------------------------------------------------------------*/

/**
 * Liefert Fakultätskürzel basierend auf aktivem Theme / Customizer-Werten.
 *
 * Rückgabewerte:
 *  - 'phil','nat','med','rw','tf' → eine der Fakultäten
 *  - 'zentral' → zentrale Einrichtung / FAU.de
 *  - '' → keine Zuordnung möglich oder keine Anzeige gewünscht
 *
 * @return string
 */
function get_fau_faculty_by_theme(): string
{
    // 1) Elemental?
    $theme = wp_get_theme();
    $isElemental = false;

    if ($theme) {
        $name = (string)$theme->get('Name');
        $template = strtolower((string)$theme->get_template());
        $stylesheet = strtolower((string)$theme->get_stylesheet());

        $isElemental = (strcasecmp($name, 'FAU-Elemental') === 0)
            || in_array($template, ['fau-elemental', 'fauelemental'], true)
            || in_array($stylesheet, ['fau-elemental', 'fauelemental'], true);
    }

    if ($isElemental) {
        $siteType = (string)get_theme_mod('faue_website_type', '');
        $faculty = (string)get_theme_mod('faue_faculty', '');

        if ($siteType === 'fau') {
            return 'zentral';
        }
        if (in_array($siteType, ['faculty', 'chair'], true) && $faculty !== '') {
            return $faculty;
        }
        if ($siteType === 'other' && $faculty !== '') {
            return $faculty;
        }
        if ($siteType === 'cooperation') {
            return '';
        }
        return '';
    }

    // 2) Legacy
    $websiteType = get_theme_mod('website_type');

    if (isset($websiteType)) {
        if ($websiteType === 0 || $websiteType === 2) {
            return 'zentral';
        }
        $fautheme = get_fau_orga_fautheme();
        if ($fautheme) {
            $debug = get_theme_mod('debug_website_fakultaet');
            if (isset($debug) && $debug !== false) {
                return (string)$debug;
            }
            return $fautheme;
        }
    } else {
        $fautheme = get_fau_orga_fautheme();
        if ($fautheme) {
            return $fautheme;
        }
    }

    return '';
}


/*-----------------------------------------------------------------------------------*/
/* Orga aus Theme ableiten
/*-----------------------------------------------------------------------------------*/
/**
 * Liefert FAU.ORG-ID basierend auf der ermittelten Fakultät.
 *
 * @return string
 */
function get_fau_orga_by_theme(): string
{
    $faculty = get_fau_faculty_by_theme();
    return (string)get_fau_orga_fauorg_by_faculty($faculty);
}

/*-----------------------------------------------------------------------------------*/
/* Styles laden (theme-sensitiv)
/*-----------------------------------------------------------------------------------*/
/**
 * Enqueue der Breadcrumb-Styles – abhängig vom aktiven Theme.
 *
 * @param string $style Handle für Fallback.
 * @return void
 */
function fau_orga_enqueue_style($style = 'fau-orga-breadcrumb'): void
{

    $active_theme = wp_get_theme();
    $theme_name = $active_theme ? $active_theme->get('Name') : '';

    global $known_themes;

    // 1) FAU-Elemental → Plugin-CSS laden
    if ($theme_name === 'FAU-Elemental') {
        // ✅ Korrektur der Pfadauflösung: plugin_dir_url() braucht eine Datei, nicht ein Verzeichnis
        $plugin_url = plugin_dir_url(dirname(__DIR__) . '/fau-orga-breadcrumb.php'); // ✅
        wp_enqueue_style(
            'fau-orga-breadcrumb-elemental',
            $plugin_url . 'css/fau-orga-breadcrumb.css',
            [],
            FAU_ORGA_BREADCRUMB_VERSION // ✅ Version aus Konstante
        );
        return;
    }

    // 2) Andere FAU-Themes → kein eigenes CSS (wie bisher)
    if (in_array($theme_name, $known_themes['fauthemes'], true)) {
        return;
    }

    // 3) Alle anderen Themes → Fallback-Handle enqueuen (falls registriert)
    wp_enqueue_style($style);
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\fau_orga_enqueue_style', 99);

/*-----------------------------------------------------------------------------------*/
/* FAU-Theme → Fakultätskennung (alt)
/*-----------------------------------------------------------------------------------*/

/**
 * Liefert die Fakultätskennung anhand alter FAU-Themes oder 'zentral'; false, wenn kein FAU-Theme.
 *
 * @return string|false
 */
function get_fau_orga_fautheme()
{
    global $known_themes;

    $active_theme = wp_get_theme();
    if (!$active_theme || !$active_theme->exists()) {
        return false;
    }

    $themename = (string)$active_theme->get('Name');

    if (!isset($known_themes['fauthemes'])) {
        return false;
    }

    if (in_array($themename, $known_themes['fauthemes'], true)) {
        // ✅ Bugfix: switch über Theme-NAMEN statt WP_Theme-Objekt
        switch ($themename) { // ✅
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

    return false;
}

