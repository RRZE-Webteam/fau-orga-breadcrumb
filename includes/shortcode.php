<?php

namespace FAU\ORGA\Breadcrumb;

add_shortcode('fauorga', 'FAU\ORGA\Breadcrumb\show_breadcrumb');


/**
 * Shortcodes zur Darstellung der Breadcrumb sowie zur Darstellung des hardcodierten Strukturmenüs
 * in FAU-Elemental
 */

function show_breadcrumb($atts)
{
    global $post;
    global $fau_orga_breadcrumb_config;


    $shortcode_attr = shortcode_atts(array(
        'org' => '',
        'show' => 'breadcrumb',
    ), $atts);


    $form_org = $shortcode_attr['org'];
    $show_type = $shortcode_attr['show'];


    // Wenn show="menu" dann das hardcodierte Menü ausgeben
    if ($show_type === 'menu') {
        return get_fau_elemental_menu_html();
    }

    if (empty($form_org)) {

        $website_type = get_theme_mod("website_type");
        if (isset($website_type)) {
            if (($website_type == -1) || ($website_type == 3) || ($website_type == 0)) {
                return;
                // No orga breadcrumb for these website types

                /*
             *     0 => __('Fakultätsportal','fau'),
                    1 => __('Department, Lehrstuhl, Einrichtung','fau'),
                    2 => __('Zentrale Einrichtung','fau') ,
                    3 => __('Website für uniübergreifende Kooperationen mit Externen','fau') ,
                    -1 => __('Zentrales FAU-Portal www.fau.de','fau')
             */

            }
        }

        $options = get_option('fau_orga_breadcrumb_options');
        if (isset($options['site-orga'])) {
            $form_org = esc_attr($options['site-orga']);
        }
        if (empty($form_org)) {
            // Es handelt sich um eine Website, die ein Lehrstuhl ist und einer Fakultät zugeordnet ist

            $form_org = get_fau_orga_by_theme();
        }
    }

    if (isset($form_org)) {
        fau_orga_enqueue_style('fau-orga-breadcrumb');
        return get_fau_orga_breadcrumb($form_org);
    }
}



