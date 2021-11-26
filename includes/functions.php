<?php

/*-----------------------------------------------------------------------------------*/
/* Global functions for plugin
/*-----------------------------------------------------------------------------------*/
$fau_orga_fautheme = get_fau_orga_fautheme();

/*-----------------------------------------------------------------------------------*/
/* Admin Notice auf der Dashboard, damit man die ORGA Breadcrumb setzt
/*-----------------------------------------------------------------------------------*/
function fau_orga_admin_notice(){
    global $pagenow;
    global $fau_orga_fautheme;
    
    $website_type = get_theme_mod("website_type");
    $form_org = '';
    $options = get_option( 'fau_orga_breadcrumb_options' );
    if (isset($options['site-orga'])) {
	$form_org = esc_attr($options['site-orga']);  
    }
    // Wenn wir in einem FAU Theme sind
    // UND der Website-Type = 1 (Einrichtung einer Fakultät) ist
    // UND noch keine Zuordnung erfolgte,
    // dann zeige den Hinweis, dass man doch bitte eine Zuordnung machen soll
    
    
    if (isset($website_type) && ($website_type == 1) && (empty($form_org))) {
	if ( $pagenow == 'index.php' ) {
	    $user = wp_get_current_user();
	    if ( in_array( 'administrator', (array) $user->roles ) ) {
		echo '<div class="notice notice-warning">';
		echo __('Der Webauftritt ist noch nicht organisatorisch eingeordnet. <br>Bitte rufen Sie die <a href="options-general.php?page=fau_orga_breadcrumb_settings">Einstellung FAU.ORG Breadcrumb</a> auf und geben Sie an, welcher organisatorischen Einheit der Webauftritt angehört.','fau-orga-breadcrumb');
		echo '</div>';

	    }
	}
    } 
    
   
   
}
 add_action('admin_notices', 'fau_orga_admin_notice');

/*-----------------------------------------------------------------------------------*/
/* Get FAU.ORG by faculty
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_fauorg_by_faculty( $faculty = '') {
    global $fau_orga_breadcrumb_data;
    $res = '';
   // $fauorg = san_fauorg_number($fauorg);
    if (isset($faculty)) {
	foreach($fau_orga_breadcrumb_data as $key => $listdata) {
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
function get_fau_orga_childs( $fauorg = '000000000') {
    global $fau_orga_breadcrumb_data;
    $res = array();
   // $fauorg = san_fauorg_number($fauorg);
    if (isset($fauorg)) {
	foreach($fau_orga_breadcrumb_data as $key => $listdata) {
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
function get_fau_orga_upperclass( $fauorg = '') {
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
function get_fau_orga_form_optionlist( $fauorg = '000000000', $preorg = '000000000', $level = 0, $maxdepth = 4) {
    global $fau_orga_breadcrumb_data;
    global $fau_orga_breadcrumb_config;
    

    $fauorg = san_fauorg_number($fauorg);
    
    if (isset($preorg)) {
	$org  = san_fauorg_number($preorg);
    }
    
    $res = '';
    $faculty = '';
    $website_type = get_theme_mod("website_type");
  
    if (isset($website_type) ) {
	if ($website_type==0 ) {
	    // Fakultaetsportal. Kann nur oberste Ebene auswählen.
	      $key = $fau_orga_breadcrumb_config['root'];
	      if (isset($fau_orga_breadcrumb_data[$key])) {
		$res = '<option value="'.$key.'" '.selected( $org, $key , false).'>'.$fau_orga_breadcrumb_data[$key]['title'].'</option>';
		  return $res;
	      }
	} elseif ($website_type==1) {
	    global $fau_orga_fautheme;
	    if ($fau_orga_fautheme) {
		$faculty = $fau_orga_fautheme;
		$debug_website_fakultaet = get_theme_mod('debug_website_fakultaet');
		if (isset($debug_website_fakultaet)) {
		    $faculty = $debug_website_fakultaet;
		}

	    }
	} elseif ($website_type==2) {
	    $faculty = 'zentral';
	}
    }
    $firstlevel = get_fau_orga_childs($fauorg);
    
    if (!empty($firstlevel)) {
	foreach($firstlevel as $key) {
	    if (!empty($faculty)) {
		if (($faculty !== 'zentral')  && isset($fau_orga_breadcrumb_data[$key]['faculty']) && ($fau_orga_breadcrumb_data[$key]['faculty'] !== $faculty)) {
		    // wenn wir in einem Fakultatstheme sind, dann lasse alle Einrichtungen die zu anderen Fakultaeten gehören, weg
		    continue;
		}
		if (($faculty== 'zentral') && isset($fau_orga_breadcrumb_data[$key]['faculty'])) {
		    // wenn wir im Zentralbereich sind, dann lasse alle Einträge, die Fakultäten ungeordnet sind, weg
		    continue;
		}
	    }
	    
	
	    
	    
	    $orgclass = get_fau_orga_upperclass($key);
	    
	    if ($orgclass) {
		$class = 'depth-'.$level.' '.$orgclass;
	    } else {
		$class = 'depth-'.$level;
	    }
	    
	    $res .= '<option class="'.$class.'" value="'.$key.'" '.selected( $org, $key , false);
	    if (isset($fau_orga_breadcrumb_data[$key]['hide']) && ($fau_orga_breadcrumb_data[$key]['hide']==true)) {
		 $res .= ' disabled';
	    }
	    
	    $res .= '>'.$fau_orga_breadcrumb_data[$key]['title'].'</option>';
	    
	    
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
function get_fau_orga_breadcrumb_customizer_choices() {
    global $fau_orga_breadcrumb_data;
    
    $res = array();
    foreach($fau_orga_breadcrumb_data as $key => $listdata) {
	if (isset($listdata['title'])) {
	    $res[$key] =  $listdata['title'];
	}
    }
    return $res;
}
/*-----------------------------------------------------------------------------------*/
/* sanitize FAU.ORG Number
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'san_fauorg_number' ) ) :  
    function san_fauorg_number($s){
	return filter_var(trim($s), FILTER_SANITIZE_NUMBER_INT);
    }
endif;    
/*-----------------------------------------------------------------------------------*/
/* create breadcrumb
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_breadcrumb($form_org) {
    global $fau_orga_breadcrumb_data;

    $schema_listattr = ' itemprop="itemListElement" itemscope  itemtype="https://schema.org/ListItem"';
    

    if ((isset($form_org)) && (isset($fau_orga_breadcrumb_data[$form_org]))) {
	$path = array();
	$path[] = $fau_orga_breadcrumb_data[$form_org];
	if (isset($fau_orga_breadcrumb_data[$form_org]['parent'])) {
	    $parent = $fau_orga_breadcrumb_data[$form_org]['parent'];
	    
	    
	    while(!empty($parent)) {
		if ((isset($fau_orga_breadcrumb_data[$parent]['hide'])) && ($fau_orga_breadcrumb_data[$parent]['hide']==true)) {
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
	
	foreach ($breadcrumb as  $value) {
	    $entry = '<li'.$schema_listattr.'>';
	    if (isset($value['url'])) {
		$entry .= '<a itemprop="item"  href="'.esc_url($value['url']).'">';
	    } else {
		$entry .= '<span itemprop="item">';
	    }
	    $entry .= '<span itemprop="name">'.$value['title'].'</span>';
	    if (isset($value['url'])) {
		$entry .= '</a>';
	    } else {
		$entry .= '</span>';
	    }
	    $entry .= '<meta itemprop="position" content="'.$position.'" />';
	    $position++;
	    $entry .= '</li>';
	    
	    $line .= $entry;
	}
	
	$res = '<nav aria-label="'.__('Organisatorische Navigation','fau-orga-breadcrumb').'">';
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
function get_fau_orga_fautheme() {
    
    $active_theme = wp_get_theme();
    $active_theme = $active_theme->get( 'Name' );
    
    
    global $known_themes;
    
    if (in_array($active_theme, $known_themes['fauthemes'])) {

	switch($active_theme) {
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
    return false;
  
}

/*-----------------------------------------------------------------------------------*/
/* enqueue with filter by theme
/*-----------------------------------------------------------------------------------*/
function fau_orga_enqueue_style($style = 'fau-orga-breadcrumb') {
    
    $active_theme = wp_get_theme();
    $active_theme = $active_theme->get( 'Name' );
    
    
    global $known_themes;
    
    if (in_array($active_theme, $known_themes['fauthemes'])) {
	// No CSS for frontend
   // } elseif (in_array($active_theme, $known_themes['rrzethemes'])) {
       // No CSS for frontend
    } else{
	wp_enqueue_style($style);
    }
    
}