<?php

namespace FAU\ORGA\Breadcrumb;
/*-----------------------------------------------------------------------------*/
/* Global functions for plugin
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
//        'FAU-Elemental'
    ],
    'rrzethemes' => [
        'RRZE 2019',
    ],
);

/**
 * /* Prüft, ob das aktuelle Theme FAU-Elemental ist
 * /*
 * /* @return bool
 */
function is_fau_elemental_theme(): bool
{
    $active_theme = wp_get_theme();
    return $active_theme->exists() && $active_theme->get('Name') === 'FAU-Elemental';
}


/**
 * Erweiterung der Funktion get_fau_orga_fautheme()
 */
function get_fau_orga_fautheme()
{
    global $known_themes;

    $active_theme = wp_get_theme();
    if (!$active_theme->exists()) {
        return false;
    }

    $themename = $active_theme->get('Name');

    if (isset($known_themes) && isset($known_themes['fauthemes'])) {
        if (in_array($themename, $known_themes['fauthemes'])) {
            switch ($themename) {
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
    }
    return false;
}

/**
 * /* Vereinfachte Asset-Verwaltung (bestehende Funktion erweitern)
 * /*/
function fau_orga_enqueue_style($style = 'fau-orga-breadcrumb')
{
    $active_theme = wp_get_theme();
    $active_theme_name = $active_theme->get('Name');

    global $known_themes;

    if (in_array($active_theme_name, $known_themes['fauthemes'])) {
        // Für FAU-Elemental: Keine CSS/JS Assets laden (Theme macht das)
        if ($active_theme_name === 'FAU-Elemental') {
            // Nichts laden - Theme übernimmt Styling und Interaktivität
            return;
        } else {
            // Für andere FAU-Themes: Normalverhalten (meist kein CSS)
            // No CSS for frontend bei FAU-Themes
        }
    } else {
        // Für Non-FAU-Themes: CSS laden
        wp_enqueue_style($style);
    }
}


/*-----------------------------------------------------------------------------------*/
/* Admin Notice auf der Dashboard, damit man die ORGA Breadcrumb setzt
/*-----------------------------------------------------------------------------------*/
function fau_orga_admin_notice()
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

add_action('admin_notices', 'FAU\ORGA\Breadcrumb\fau_orga_admin_notice');

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
/* get faculty by theme
/*-----------------------------------------------------------------------------------*/
function get_fau_faculty_by_theme()
{

    global $fau_orga_breadcrumb_config;
    $website_type = get_theme_mod("website_type");
    $faculty = '';
    if (isset($website_type)) {
        if ($website_type === 0) {
            // Fakultaetsportal. Kann nur oberste Ebene auswählen.
            $key = $fau_orga_breadcrumb_config['root'];
            if (isset($fau_orga_breadcrumb_data[$key])) {
                $res = '<option value="' . $key . '" ' . selected($org, $key, false) . '>' . $fau_orga_breadcrumb_data[$key]['title'] . '</option>';
                return $res;
            }
        } elseif ($website_type == 2) {
            $faculty = 'zentral';
        } else {
            $fau_orga_fautheme = get_fau_orga_fautheme();
            if ($fau_orga_fautheme) {
                $faculty = $fau_orga_fautheme;
                $debug_website_fakultaet = get_theme_mod('debug_website_fakultaet');
                if (isset($debug_website_fakultaet) && ($debug_website_fakultaet !== false)) {
                    $faculty = $debug_website_fakultaet;
                }
            }

        }
    } else {
        $fau_orga_fautheme = get_fau_orga_fautheme();
        if ($fau_orga_fautheme) {
            $faculty = $fau_orga_fautheme;
        }
    }
    return $faculty;
}

/*-----------------------------------------------------------------------------------*/
/* get fau orga by theme
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_by_theme()
{
    $faculty = get_fau_faculty_by_theme();
    return get_fau_orga_fauorg_by_faculty($faculty);
}

