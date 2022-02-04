<?php
namespace FAU\ORGA\Breadcrumb;

add_action('admin_menu', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_plugin_admin_settings');
/*-----------------------------------------------------------------------------------*/
/* Add option page
/*-----------------------------------------------------------------------------------*/
function fau_orga_breadcrumb_plugin_admin_settings() {
    add_options_page('FAU ORGA Breadcrumb', 'FAU.ORG Breadcrumb', 'manage_options', 'fau_orga_breadcrumb_settings', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_option_page');
    add_action('admin_init', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_settings');
   
}

/*-----------------------------------------------------------------------------------*/
/* generate option page
/*-----------------------------------------------------------------------------------*/
function fau_orga_breadcrumb_option_page(){
    ?>
<div class="fau_orga_breadcrumb_optionpage">
    <form action="options.php" method="post">

        <?php settings_fields('fau_orga_breadcrumb_options');?>
        <?php do_settings_sections('fau_orga_textfield');?>
        <p>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e('Speichern', 'fau-orga-breadcrumb') ?>"  />
        </p>
    </form>
</div>

<?php }  

// ADMIN SETTINGS

/*-----------------------------------------------------------------------------------*/
/* Setting
/*-----------------------------------------------------------------------------------*/
function fau_orga_breadcrumb_settings() {
    register_setting( 'fau_orga_breadcrumb_options', 'fau_orga_breadcrumb_options' );
    add_settings_section('plugin_main', 'FAU.ORG Breadcrumb Einstellungen', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_section_text', 'fau_orga_textfield');
    add_settings_field('Checkbox Element', 'Einrichtung', 'FAU\ORGA\Breadcrumb\fau_orga_breadcrumb_field_callback', 'fau_orga_textfield', 'plugin_main' );

}
/*-----------------------------------------------------------------------------------*/
/* Input field
/*-----------------------------------------------------------------------------------*/
function fau_orga_breadcrumb_field_callback() {
    
    global $fau_orga_breadcrumb_data;
    $options = get_option( 'fau_orga_breadcrumb_options' );
    if (isset($options['site-orga'])) {
	 $orga = esc_attr($options['site-orga']);
    } else {
	$orga = '0000000000';
    }
    $website_type = get_theme_mod("website_type");
      $optionlist = '';
	  if (isset($website_type) && ($website_type <> 1)) { 
	    $optionlist .= '<option value="">'.__('Keine (Keine Fakulätszuordnung oder Zentralbereich)', 'fau-orga-breadcrumb' ).'</option>'; 
	  }
	  $optionlist .= get_fau_orga_form_optionlist('000000000',$orga,0);
	  $fau_orga_fautheme = get_fau_orga_fautheme();
    ?>
     <select size="10" id="fau_orga_breadcrumb_options[site-orga]"
        name="fau_orga_breadcrumb_options[site-orga]" type="text">
        <?php        
	echo $optionlist
        ?>
        </select><!-- website type: <?php echo $website_type; ?> faculty: <?php echo $fau_orga_fautheme; ?> -->
	<?php 
 
}

/*-----------------------------------------------------------------------------------*/
/* Infotext
/*-----------------------------------------------------------------------------------*/
function fau_orga_breadcrumb_section_text() {
    global $fau_orga_breadcrumb_data;

    echo '<p>' . __('Organisatorische Zuordnung: Bitte wählen Sie hier die <strong>nächsthöhere</strong> Organisationseinheit aus, zu der die Website zugeordnet werden kann.','fau-orga-breadcrumb') . '</p>';
        $website_type = get_theme_mod("website_type");
/*
 *     0 => __('Fakultätsportal','fau'), 
	1 => __('Department, Lehrstuhl, Einrichtung','fau'),  
	2 => __('Zentrale Einrichtung','fau') ,
	3 => __('Website für uniübergreifende Kooperationen mit Externen','fau') ,
	-1 => __('Zentrales FAU-Portal www.fau.de','fau') 
 */
	    if ($website_type) {
		if ($website_type==0) {
		    echo '<p class="notice notice-warning is-dismissible">'.__('Achtung: Die Website wurde im Customizer als Fakultätsportal definiert. Daher stehen der Fakultät untergeordnete Einrichtungen nicht zur Auswahl zur Verfügung. <strong>Die Orga Breadcrumb wird nicht angezeigt.</strong>','fau-orga-breadcrumb').'</p>';
		} elseif ($website_type==1) {
		    echo '<p class="notice notice-info is-dismissible">'.__('Die Website wurde im Customizer als Einrichtung einer Fakultät definiert. Daher stehen nur zentrale Einrichtungen und der Fakultät untergeordnete Einrichtungen  zur Auswahl zur Verfügung.','fau-orga-breadcrumb').'</p>';
		} elseif ($website_type==2) {
		    echo '<p class="notice notice-info is-dismissible">'.__('Die Website wurde im Customizer als zentrale Einrichtung definiert. Daher stehen nur zentrale Einrichtungen zur Auswahl zur Verfügung.','fau-orga-breadcrumb').'</p>';
		} elseif ($website_type==3) {
		    echo '<p class="notice notice-warning is-dismissible">'.__('Achtung: Die Website wurde im Customizer als Kooperation definiert. D<strong>Die Orga Breadcrumb wird nicht angezeigt.</strong>','fau-orga-breadcrumb').'</p>';
		} elseif ($website_type==-1) {
		    echo '<p class="notice notice-warning is-dismissible">'.__('Achtung: Die Website wurde als zentrales FAU Portal definiert. <strong>Die Orga Breadcrumb wird nicht angezeigt.</strong>','fau-orga-breadcrumb').'</p>';
		}
	    }
	
	    
	   
	    
    $options = get_option( 'fau_orga_breadcrumb_options' );
    if ((isset($options['site-orga'])) && (!empty($options['site-orga']))) {
	 $orga = esc_attr($options['site-orga']);
	 echo '<p><strong>'.__('Aktuell gewählt','fau-orga-breadcrumb').': </strong><em>'.$fau_orga_breadcrumb_data[$orga]['title'].'</em></p>';
	
	 echo '<div class="fau_org_breadcrumb_preview">';
	 echo '<strong>'.__('Breadcrumb','fau-orga-breadcrumb').': &nbsp; &nbsp; &nbsp; </strong>';
	 echo get_fau_orga_breadcrumb($orga);
	  echo '</div>';
    }
   
}

/*-----------------------------------------------------------------------------------*/
/* Add settings also to customizer
/*-----------------------------------------------------------------------------------*/

function fau_orga_customizer_settings( $wp_customize ) {

	// Wenn das FAU.ORG Plugin vorhanden und aktiv ist, erlaube es hier, die Option
	// dazu zu verwalten
    
	global $fau_orga_fautheme;
	if ($fau_orga_fautheme === false) {
	    return;
	}
    
	$options = get_option( 'fau_orga_breadcrumb_options' );
	   if (isset($options['site-orga'])) {
		$orga = esc_attr($options['site-orga']);
	   } else {
	       $orga = '0000000000';
	   }
	   
	   $website_type = get_theme_mod("website_type");
	   if (isset($website_type)) {
	       if (($website_type==-1) || ($website_type==3)) {
		   return;
		   // No orga breadcrumb for these website types
	       }
		   
	   }
	   $optionlist = '';
	  if (isset($website_type) && ($website_type <> 1)) { 

	    $optionlist .= '<option value="">'.__('Keine (Keine Fakulätszuordnung oder Zentralbereich)', 'fau-orga-breadcrumb' ).'</option>'; 
	  }
	  $optionlist .= get_fau_orga_form_optionlist('000000000',$orga,0);
	   
       $wp_customize->add_setting( 'fau_orga_breadcrumb_options[site-orga]', array(
	    'default'		    => '',
	    'capability'	    => 'edit_theme_options',
	   'type'		    => 'option'
	) );
	$wp_customize->add_control( new FAU_ORGA_Customize_Control_Select( $wp_customize, 'fau_orga_site-orga', array(
	      'settings' => 'fau_orga_breadcrumb_options[site-orga]',
		'label'		    => esc_html__( 'Organisatorische Zuordnung', 'fau'),
		'description'	    => esc_html__( 'Wählen Sie hier die organisatorische Einheit aus, zu der Ihre Einrichtung oder Ihr Webauftritt gehört.', 'fau'),
		'section'	    => 'title_tagline',
		'type'		    => 'select',
		'choices'	    => $optionlist,
		'priority'	    => 11,
	) ) );
	
	
	
  
}
/*--------------------------------------------------------------------*/
/* Special selection for customizer
/*--------------------------------------------------------------------*/
if (class_exists('WP_Customize_Control')) {
    class FAU_ORGA_Customize_Control_Select extends \WP_Customize_Control {
	// The type of customize control being rendered.
	public $type = 'select';

	//Displays the multiple select on the customize screen.
	public function render_content() {
	    $input_id         = '_customize-input-' . $this->id;
	    $description_id   = '_customize-description-' . $this->id;
	    $describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';

	    if ( empty( $this->choices ) )
		return;
	    ?>
		<label class="fau_orga_breadcrumb_optionpage">
		    <?php if ( ! empty( $this->label ) ) : ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		    <?php endif;
		    if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		    <?php endif; ?>
		    <select size="5" id="<?php echo esc_attr( $input_id); ?>" class="" <?php echo $describedby_attr; ?> <?php $this->link(); ?>><?php 
			
			    echo  $this->choices;
			?>
		    </select>
		</label>
	<?php }
    }
}