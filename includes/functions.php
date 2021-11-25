<?php

/*-----------------------------------------------------------------------------------*/
/* Global functions for plugin
/*-----------------------------------------------------------------------------------*/

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
function get_fau_orga_form_optionlist ( $fauorg = '000000000', $preorg = '000000000', $level = 0, $maxdepth = 4) {
    global $fau_orga_breadcrumb_data;
    global $fau_orga_breadcrumb_config;
    
    $fauorg = san_fauorg_number($fauorg);
    
    if (isset($preorg)) {
	$org  = san_fauorg_number($preorg);
    }
    $firstlevel = get_fau_orga_childs($fauorg);
    $res = '';
    $website_type = get_theme_mod("website_type");
     
    if (isset($website_type) && ($website_type==0) ) {
	// Fakultaetsportal. Kann nur oberste Ebene auswählen.
	  $key = $fau_orga_breadcrumb_config['root'];
	  if (isset($fau_orga_breadcrumb_data[$key])) {
	    $res = '<option value="'.$key.'" '.selected( $org, $key , false).'>'.$fau_orga_breadcrumb_data[$key]['title'].'</option>';
	      return $res;
	  }
	
    }
    
    
    if (!empty($firstlevel)) {
	foreach($firstlevel as $key) {
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