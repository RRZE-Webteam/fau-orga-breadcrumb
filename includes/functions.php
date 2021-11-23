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
/* create option list for forms
/*-----------------------------------------------------------------------------------*/
function get_fau_orga_form_optionlist ( $fauorg = '000000000', $preorg = '000000000', $level = 0, $depth = 4, $lang = '') {
    global $fau_orga_breadcrumb_data;
    
    $fauorg = san_fauorg_number($fauorg);
    
    if (isset($preorg)) {
	$org  = san_fauorg_number($preorg);
    }
    $firstlevel = get_fau_orga_childs($fauorg);
    $res = '';
    
    
    if (!empty($firstlevel)) {
	foreach($firstlevel as $key) {
	    
	    $res .= '<option value="'.$key.'" '.selected( $org, $key ).'>'.$fau_orga_breadcrumb_data[$key]['title'].'</option>';
	    if ($level < $depth) {
		
		$nextlevel = $level + 1;
		$sublist = get_fau_orga_childs($key);
		if (!empty($sublist)) {
		    $res .= '<optgroup label="'.__('Untergeordnete Einrichtungen:','fau-orga-breadcrumb').'">';
		    $res .= get_fau_orga_form_optionlist($key, $preorg, $nextlevel, $depth, $lang);
		    $res .=  '</optgroup>';
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
