<?php
namespace FAU\ORGA\Breadcrumb;

add_action('admin_menu', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_plugin_admin_settings');

function fau_orga_breadcrumb_plugin_admin_settings() {
    add_options_page('FAU ORGA Breadcrumb', 'FAU.ORG Breadcrumb', 'manage_options', 'fau_orga_breadcrumb_settings', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_option_page');
    add_action('admin_init', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_settings');

}

function fau_orga_breadcrumb_option_page(){?>
<div>
    <form action="options.php" method="post">

        <?php settings_fields('fau_orga_breadcrumb_options');?>
        <?php do_settings_sections('fau_orga_textfield');?>
        <p>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e('Änderungen speichern') ?>"  />
        </p>
    </form>
</div>

<?php }  

// ADMIN SETTINGS


function fau_orga_breadcrumb_settings() {
    register_setting( 'fau_orga_breadcrumb_options', 'fau_orga_breadcrumb_options' );
    add_settings_section('plugin_main', 'FAU.ORG Breadcrumb Einstellungen', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_section_text', 'fau_orga_textfield');
    add_settings_field('Checkbox Element', 'FAU.ORG Id', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_field_callback', 'fau_orga_textfield', 'plugin_main' );

}

function fau_orga_breadcrumb_field_callback() {
    $options = get_option( 'fau_orga_breadcrumb_options' );
    if (isset($options['site-orga'])) {
	 $orga = esc_attr($options['site-orga']);
    } else {
	$orga = '0000000000';
    }
   
    echo '<input type="text" name="fau_orga_breadcrumb_options[site-orga]" value="'.$orga.'">';
}
?>
<?php 

function fau_orga_breadcrumb_section_text() {
    echo '<p>' . esc_html_e('Organisatorische Zuordnung. Bitte geben Sie hier die FAU.ORG Id der zur Website nächsthöheren Organisationseinheit an.','fau-orga-breadcrumb') . '</p>';
}



function plugin_rvce_options_validate($input) {  
    $options = get_option('fau_orga_breadcrumb_options');
    return $options;
}