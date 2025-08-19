<?php


namespace FAU\ORGA\Breadcrumb;

// Admin-Einstellungen & Customizer-Hook
add_action('admin_menu', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_plugin_admin_settings');
add_action('customize_register', 'FAU\ORGA\Breadcrumb\fau_orga_customizer_settings', 20);

/*-----------------------------------------------------------------------------------*/
/* Option Page im Backend
/*-----------------------------------------------------------------------------------*/
/**
 * Registriert die Optionen-Seite im WP-Admin (unter Einstellungen).
 *
 * @return void
 */
function fau_orga_breadcrumb_plugin_admin_settings(): void
{
    add_options_page(
        'FAU ORGA Breadcrumb',
        'FAU.ORG Breadcrumb',
        'manage_options',
        'fau_orga_breadcrumb_settings',
        __NAMESPACE__ . '\fau_orga_breadcrumb_option_page'
    );
    add_action('admin_init', __NAMESPACE__ . '\fau_orga_breadcrumb_settings');
}


/**
 * Ausgabe der HTML-Optionenseite.
 *
 * @return void
 */
function fau_orga_breadcrumb_option_page(): void
{
    ?>
    <div class="fau_orga_breadcrumb_optionpage">
        <form action="options.php" method="post">

            <?php settings_fields('fau_orga_breadcrumb_options'); ?>
            <?php do_settings_sections('fau_orga_textfield'); ?>
            <p>
                <input type="submit" name="submit" id="submit" class="button button-primary"
                       value="<?php esc_html_e('Speichern', 'fau-orga-breadcrumb') ?>"/>
            </p>
        </form>
    </div>

<?php }


/*-----------------------------------------------------------------------------------*/
/* Settings Registrierung
/*-----------------------------------------------------------------------------------*/
/**
 * Registriert Setting, Section und Field für die Breadcrumb-Optionen.
 *
 * @return void
 */
function fau_orga_breadcrumb_settings(): void
{
    register_setting('fau_orga_breadcrumb_options', 'fau_orga_breadcrumb_options');

    add_settings_section(
        'plugin_main',
        'FAU.ORG Breadcrumb Einstellungen',
        __NAMESPACE__ . '\fau_orga_breadcrumb_section_text',
        'fau_orga_textfield'
    );

    add_settings_field(
        'Checkbox Element',
        'Einrichtung',
        __NAMESPACE__ . '\fau_orga_breadcrumb_field_callback',
        'fau_orga_textfield',
        'plugin_main'
    );
}

/*-----------------------------------------------------------------------------------*/
/* Input Feld Admin
/*-----------------------------------------------------------------------------------*/
/**
 * Callback für das Select-Feld der organisatorischen Zuordnung im Admin.
 *
 * @return void
 */
function fau_orga_breadcrumb_field_callback()
{

    global $fau_orga_breadcrumb_data;

    $options = get_option('fau_orga_breadcrumb_options');
    $orga = isset($options['site-orga']) ? esc_attr($options['site-orga']) : '0000000000';

    // Legacy- und Elemental-Typ einlesen
    $legacy_type = get_theme_mod('website_type', null);           // int | null
    $faue_type = get_theme_mod('faue_website_type', '');        // string | ''
    $faue_fac = (string)get_theme_mod('faue_faculty', '');    // für 'other'

    // Original-Logik "Keine"-Option:
    // Legacy: nur wenn website_type != 1
    // Elemental: 'chair' oder ('other' + faculty gesetzt) => KEINE "Keine"
    //            'faculty'/'central' oder 'other' ohne faculty => "Keine" anzeigen
    $show_none = true;
    if ($faue_type !== '') {
        $t = strtolower($faue_type);
        if ($t === 'chair' || ($t === 'other' && $faue_fac !== '')) {
            $show_none = false;
        } else {
            $show_none = true; // faculty/central/other(no faculty)
        }
    } else {
        // Legacy-Fall (numerisch)
        $show_none = (isset($legacy_type) && (int)$legacy_type !== 1);
    }

    // Root angleichen (dein Code mischt 9×0 und 10×0)
    $root = '0000000000';

    // Optionsliste bauen
    $optionlist = '';
    if ($show_none) {
        $optionlist .= '<option value="">' .
            esc_html__('Keine (Keine Fakultätszuordnung oder Zentralbereich)', 'fau-orga-breadcrumb') .
            '</option>';
    }
    $optionlist .= get_fau_orga_form_optionlist($root, $orga ?: $root, 0);

    $fau_orga_fautheme = get_fau_orga_fautheme();
    ?>
    <select size="10" id="fau_orga_breadcrumb_options[site-orga]"
            name="fau_orga_breadcrumb_options[site-orga]">
        <?php echo $optionlist; ?>
    </select><!-- legacy type: <?php echo $legacy_type; ?> / faue type: <?php echo $faue_type; ?> faculty: <?php echo $fau_orga_fautheme; ?> -->
    <?php
}


/*-----------------------------------------------------------------------------------*/
/* Infotext
/*-----------------------------------------------------------------------------------*/
/**
 * Infotext und Hinweise unterhalb des Select-Feldes im Admin.
 *
 * @return void
 */
function fau_orga_breadcrumb_section_text(): void
{
    global $fau_orga_breadcrumb_data;

    echo '<p>' . __('Organisatorische Zuordnung: Bitte wählen Sie hier die <strong>nächsthöhere</strong> Organisationseinheit aus, zu der die Website zugeordnet werden kann.', 'fau-orga-breadcrumb') . '</p>';
    $website_type = get_theme_mod("website_type");
    /*
     *     0 => __('Fakultätsportal','fau'),
        1 => __('Department, Lehrstuhl, Einrichtung','fau'),
        2 => __('Zentrale Einrichtung','fau') ,
        3 => __('Website für uniübergreifende Kooperationen mit Externen','fau') ,
        -1 => __('Zentrales FAU-Portal www.fau.de','fau')
     */
    if ($website_type) {
        if ($website_type == 0) {
            echo '<p class="notice notice-warning is-dismissible">' . __('Achtung: Die Website wurde im Customizer als Fakultätsportal definiert. Daher stehen der Fakultät untergeordnete Einrichtungen nicht zur Auswahl zur Verfügung. <strong>Die Orga Breadcrumb wird nicht angezeigt.</strong>', 'fau-orga-breadcrumb') . '</p>';
        } elseif ($website_type == 1) {
            echo '<p class="notice notice-info is-dismissible">' . __('Die Website wurde im Customizer als Einrichtung einer Fakultät definiert. Daher stehen nur zentrale Einrichtungen und der Fakultät untergeordnete Einrichtungen  zur Auswahl zur Verfügung.', 'fau-orga-breadcrumb') . '</p>';
        } elseif ($website_type == 2) {
            echo '<p class="notice notice-info is-dismissible">' . __('Die Website wurde im Customizer als zentrale Einrichtung definiert. Daher stehen nur zentrale Einrichtungen zur Auswahl zur Verfügung.', 'fau-orga-breadcrumb') . '</p>';
        } elseif ($website_type == 3) {
            echo '<p class="notice notice-warning is-dismissible">' . __('Achtung: Die Website wurde im Customizer als Kooperation definiert. D<strong>Die Orga Breadcrumb wird nicht angezeigt.</strong>', 'fau-orga-breadcrumb') . '</p>';
        } elseif ($website_type == -1) {
            echo '<p class="notice notice-warning is-dismissible">' . __('Achtung: Die Website wurde als zentrales FAU Portal definiert. <strong>Die Orga Breadcrumb wird nicht angezeigt.</strong>', 'fau-orga-breadcrumb') . '</p>';
        }
    }

// Anzeige: aktuell gewählte Orga
    $options = get_option('fau_orga_breadcrumb_options');
    if ((isset($options['site-orga'])) && (!empty($options['site-orga']))) {
        $orga = esc_attr($options['site-orga']);
        echo '<p><strong>' . __('Aktuell gewählt', 'fau-orga-breadcrumb') . ': </strong><em>' . $fau_orga_breadcrumb_data[$orga]['title'] . '</em></p>';

        echo '<div class="fau_org_breadcrumb_preview">';
        echo '<strong>' . __('Breadcrumb', 'fau-orga-breadcrumb') . ': &nbsp; &nbsp; &nbsp; </strong>';
        echo get_fau_orga_breadcrumb($orga);
        echo '</div>';
    }

}

/*-----------------------------------------------------------------------------------*/
/* Customizer Einstellungen
/*-----------------------------------------------------------------------------------*/
/**
 * Registriert Setting + Control für den Customizer.
 *
 * @param \WP_Customize_Manager $wp_customize Instanz des Customizers.
 * @return void
 */
function fau_orga_customizer_settings($wp_customize): void
{
    // Nur ausführen, wenn das FAU.ORG-Plugin/Theme-Kontext aktiv ist
    global $fau_orga_fautheme;
    if ($fau_orga_fautheme === false) {
        return;
    }

    // Aktuelle Orga-Option ermitteln
    $options = get_option('fau_orga_breadcrumb_options');
    $orga = isset($options['site-orga']) ? esc_attr($options['site-orga']) : '';

    // Aktives Theme prüfen (für Section UND Key des Website-Types)
    $section = 'title_tagline'; // Standard
    $theme = wp_get_theme();
    $is_elemental = false;

    if ($theme) {
        $name = (string)$theme->get('Name');
        $template = strtolower((string)$theme->get_template());
        $stylesheet = strtolower((string)$theme->get_stylesheet());

        $is_elemental =
            (stripos($name, 'elemental') !== false)
            || in_array($template, ['fau-elemental', 'fauelemental'], true)
            || in_array($stylesheet, ['fau-elemental', 'fauelemental'], true);

        if ($is_elemental) {
            // In FAU Elemental unter „Design-Einstellungen“ anzeigen
            $section = 'faue_theme_settings';
        }
    }

    // Website-Type lesen (Key unterscheidet sich je nach Theme)
    $website_type_key = $is_elemental ? 'faue_website_type' : 'website_type';
    $website_type = get_theme_mod($website_type_key);

    if (isset($website_type) && ($website_type == -1 || $website_type == 3)) {
        return; // kein Breadcrumb für zentrale Portale / Kooperationen
    }


    $optionlist = '';
    if (isset($website_type) && ($website_type != 1)) {
        $optionlist .= '<option value="">' .
            __('Keine (Keine Fakultätszuordnung oder Zentralbereich)', 'fau-orga-breadcrumb') .
            '</option>';
    }
    $optionlist .= get_fau_orga_form_optionlist('0000000000', $orga, 0);


    $wp_customize->add_setting('fau_orga_breadcrumb_options[site-orga]', [
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
    ]);

    // Control registrieren
    $wp_customize->add_control(new FAU_ORGA_Customize_Control_Select(
        $wp_customize,
        'fau_orga_site-orga',
        array(
            'settings' => 'fau_orga_breadcrumb_options[site-orga]',
            'label' => esc_html__('Organisatorische Zuordnung', 'fau'),
            'description' => esc_html__('Wählen Sie hier die organisatorische Einheit aus, zu der Ihre Einrichtung oder Ihr Webauftritt gehört.', 'fau'),
            'section' => $section,
            'type' => 'select',
            'choices' => $optionlist,
            'priority' => 11,
        )
    ));
}


/**
 * Eigene Select-Control für den Customizer.
 */

if (class_exists('WP_Customize_Control')) {
    class FAU_ORGA_Customize_Control_Select extends \WP_Customize_Control
    {
        // The type of customize control being rendered.
        public $type = 'select';

        //Displays the multiple select on the customize screen.
        public function render_content()
        {
            $input_id = '_customize-input-' . $this->id;
            $description_id = '_customize-description-' . $this->id;
            $describedby_attr = (!empty($this->description)) ? ' aria-describedby="' . esc_attr($description_id) . '" ' : '';

            if (empty($this->choices))
                return;
            ?>
            <label class="fau_orga_breadcrumb_optionpage">
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif;
                if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>
                <select size="5" id="<?php echo esc_attr($input_id); ?>"
                        class="" <?php echo $describedby_attr; ?> <?php $this->link(); ?>><?php

                    echo $this->choices;
                    ?>
                </select>
            </label>
        <?php }
    }
}
