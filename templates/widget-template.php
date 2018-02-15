<?php 
global $fau_orga_breadcrumb_config;
?>

<div class="fau-orga-breadcrumb fau-orga-breadcrumb-widget">
<nav aria-labelledby="bc-title" class="breadcrumbs">
    <h4 class="screen-reader-text" id="bc-title"><?php _e('Organisatorische Navigation','fau-orga-breadcrumb');?></h4>
    <ul>
     <li><a href="https://www.fau.de/">Friedrich-Alexander-Universität Erlangen-Nürnberg</a><?php echo $fau_orga_breadcrumb_config['devider']; ?></li> 
     <li><a href="https://www.tf.fau.de/">Technische Fakultät</a><?php echo $fau_orga_breadcrumb_config['devider']; ?></li> 
     <li><a href="https://www.informatik.uni-erlangen.de">Department Informatik</a></li> 
    </ul> 
</nav>
</div>

