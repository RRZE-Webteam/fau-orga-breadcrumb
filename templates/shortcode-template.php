<?php 
global $fau_orga_breadcrumb_config;
global $fau_orga_breadcrumb_data;
if ((isset($form_org)) && (isset($fau_orga_breadcrumb_data[$form_org]))) {
?>

<div class="fau-orga-breadcrumb fau-orga-breadcrumb-shortcode">
    <?php 
    $root = $fau_orga_breadcrumb_config['root']; 
    $parent = '';
    if (isset($fau_orga_breadcrumb_data[$form_org]['parent'])) {
        $parent = $fau_orga_breadcrumb_data[$form_org]['parent'];
    }
    $entry = '<li>';
    if (isset($fau_orga_breadcrumb_data[$form_org]['url'])) {
	$entry .= '<a href="'.esc_url($fau_orga_breadcrumb_data[$form_org]['url']).'">';
    }
    $entry .= $fau_orga_breadcrumb_data[$form_org]['title'];
    if (isset($fau_orga_breadcrumb_data[$form_org]['url'])) {
	$entry .= '</a>';
    }
    $entry .= '</li>';
    $line = $entry;
    
    while(!empty($parent)) {
	if (isset($fau_orga_breadcrumb_data[$parent])) {
	    
	    
	    if ((isset($fau_orga_breadcrumb_data[$parent]['hide'])) && ($fau_orga_breadcrumb_data[$parent]['hide']==true)) {
	       $thisentry = '';
	    } else {
		$thisentry = '<li>';
		if (isset($fau_orga_breadcrumb_data[$parent]['url'])) {
		    $thisentry .= '<a href="'.esc_url($fau_orga_breadcrumb_data[$parent]['url']).'">';
		}
		$thisentry .= $fau_orga_breadcrumb_data[$parent]['title'];
		if (isset($fau_orga_breadcrumb_data[$parent]['url'])) {
		    $thisentry .= '</a>';
		}

		$thisentry .= $fau_orga_breadcrumb_config['devider'];
		$thisentry .= '</li>';
	    }
	    
	    if (isset($fau_orga_breadcrumb_data[$parent]['parent'])) {
		$parent = $fau_orga_breadcrumb_data[$parent]['parent'];
	    } else {
		$parent = "";
	    }
	    $line = $thisentry . $line;
	} else {
	     $parent = "";
	}
    }
    
    if (!empty($line)) {
	$line = '<ul>'.$line.'</ul>';
    }
    
    
    ?>
    
<nav aria-labelledby="bc-title">
    <h2 class="screen-reader-text" id="bc-title"><?php _e('Organisatorische Navigation','fau-orga-breadcrumb');?></h2>
    <?php echo $line; ?>
</nav>
</div>

<?php } ?>

