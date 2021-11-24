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
function get_fau_orga_form_optionlist ( $fauorg = '000000000', $preorg = '000000000', $level = 0, $maxdepth = 4, $lang = '') {
    global $fau_orga_breadcrumb_data;
    
    $fauorg = san_fauorg_number($fauorg);
    
    if (isset($preorg)) {
	$org  = san_fauorg_number($preorg);
    }
    $firstlevel = get_fau_orga_childs($fauorg);
    $res = '';
    
    
    if (!empty($firstlevel)) {
	foreach($firstlevel as $key) {
	    $orgclass = get_fau_orga_upperclass($key);
	    if ($orgclass) {
		$class = 'depth-'.$level.' '.$orgclass;
	    } else {
		$class = 'depth-'.$level;
	    }
	    
	    $res .= '<option class="'.$class.'" value="'.$key.'" '.selected( $org, $key );
	    if (isset($fau_orga_breadcrumb_data[$key]['hide']) && ($fau_orga_breadcrumb_data[$key]['hide']==true)) {
		 $res .= ' disabled';
	    }
	    
	    $res .= '>'.$fau_orga_breadcrumb_data[$key]['title'].'</option>';
	    
	    
	    if ($level < $maxdepth) {
		
		$nextlevel = $level + 1;
		$sublist = get_fau_orga_childs($key);
		if (!empty($sublist)) {
		    $res .= get_fau_orga_form_optionlist($key, $preorg, $nextlevel, $maxdepth, $lang);
		}
	    }

	}
    }
    return $res;
}
/*-----------------------------------------------------------------------------------*/
/* create list fpor customizer
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
