<?php 
global $fau_orga_breadcrumb_config;
global $fau_orga_breadcrumb_data;

$schema_listattr = ' itemprop="itemListElement" itemscope  itemtype="https://schema.org/ListItem"';
$position = 1;

if (isset($form_org)) {
?>

<div class="fau-orga-breadcrumb fau-orga-breadcrumb-widget">
    <?php 
    $root = $fau_orga_breadcrumb_config['root']; 
    $parent = '';
    if (isset($fau_orga_breadcrumb_data[$form_org]['parent'])) {
        $parent = $fau_orga_breadcrumb_data[$form_org]['parent'];
    }
    $entry = '<li'.$schema_listattr.'>';
    if (isset($fau_orga_breadcrumb_data[$form_org]['url'])) {
	$entry .= '<a itemprop="item"  href="'.esc_url($fau_orga_breadcrumb_data[$form_org]['url']).'">';
    } else {
	$entry .= '<span itemprop="item">';
    }
    $entry .= '<span itemprop="name">'.$fau_orga_breadcrumb_data[$form_org]['title'].'</span>';
    if (isset($fau_orga_breadcrumb_data[$form_org]['url'])) {
	$entry .= '</a>';
    } else {
        $thisentry .= '</span>';
    }
    
    $entry .= '<meta itemprop="position" content="'.$position.'" />';
    $position++;
    $entry .= '</li>';
    $line = $entry;
    
    while(!empty($parent)) {
	if (isset($fau_orga_breadcrumb_data[$parent])) {
	    
	    
	    if ((isset($fau_orga_breadcrumb_data[$parent]['hide'])) && ($fau_orga_breadcrumb_data[$parent]['hide']==true)) {
	       $thisentry = '';
	    } else {
		$thisentry = '<li'.$schema_listattr.'>';
		if (isset($fau_orga_breadcrumb_data[$parent]['url'])) {
		    $thisentry .= '<a itemprop="item"  href="'.esc_url($fau_orga_breadcrumb_data[$parent]['url']).'">';
		} else {
		     $thisentry .= '<span itemprop="item">';
		}
		$thisentry .= '<span itemprop="name">'.$fau_orga_breadcrumb_data[$parent]['title'].'</span>';
		
		if (isset($fau_orga_breadcrumb_data[$parent]['url'])) {
		    $thisentry .= '</a>';
		} else {
		      $thisentry .= '</span>';
		}
		$thisentry .= '<meta itemprop="position" content="'.$position.'" />';
		$position++;

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
    
    
    ?>
    
<nav aria-label="<?php _e('Organisatorische Navigation','fau-orga-breadcrumb');?>">
    <ol class="breadcrumblist" itemscope itemtype="https://schema.org/BreadcrumbList">
    <?php echo $line; ?>
    </ol>	
</nav>
</div>

<?php } ?>

