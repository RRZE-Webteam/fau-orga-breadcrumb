<?php

/* 
 * Constants
 */
$fau_orga_breadcrumb_config = array(
    'devider'   => '<span>/</span>'
);


/* 
 * Orgas - Later hopefully via API.... 
 * ... An we really hope that this "later" means in a lifetime.
 * ... Of a human!
 * .. already born!!!
 */

$fau_orga_breadcrumb_data = array(
   'home' => array(
	    'title'		=> __('Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)', 'fau-orga-breadcrumb'),
	    'shorttitle'	=> __('FAU', 'fau-orga-breadcrumb'),
	    'url'		=> 'https://www.fau.de',
	    'url_en'	=> 'https://www.fau.eu',
    ),
  
    '_faculty'	=> array(
	'med' => array(
		'title'	    => __('Medizinische Fakultät', 'fau-orga-breadcrumb'),
		'shorttitle'    => __('Med', 'fau-orga-breadcrumb'),
		'url'	    => 'https://med.fau.de',
		'url_en'	    => 'https://med.fau.eu',

	),
	'nat' => array(
		'title'	    => __('Naturwissenschaftliche Fakultät', 'fau-orga-breadcrumb'),
		'shorttitle'    => __('Nat', 'fau-orga-breadcrumb'),
		'url'	    => 'https://nat.fau.de',
		'url_en'	    => 'https://nat.fau.eu',

	),
	'phil' => array(
		'title'	    => __('Philosophische Fakultät', 'fau-orga-breadcrumb'),
		'shorttitle'    => __('Phil', 'fau-orga-breadcrumb'),
		'url'	    => 'https://phil.fau.de',
		'url_en'	    => 'https://phil.fau.eu',
	),
	'rw' => array(
		'title'	    => __('Rechts- und Wirtschaftswissenschaftliche Fakultät', 'fau-orga-breadcrumb'),
		'shorttitle'    => __('RW', 'fau-orga-breadcrumb'),
		'url'	    => 'https://rw.fau.de',
		'url_en'	    => 'https://rw.fau.eu', 
                'areas' => array(
                        'wiso' => array(
                               'title'	    => __('Fachbereich Wirtschaftswissenschaften', 'fau-orga-breadcrumb'),
                               'shorttitle'    => __('WiSo', 'fau-orga-breadcrumb'),
                               'url'	    => 'https://wiso.rw.fau.de',
                               'url_en'    => 'https://wiso.rw.fau.eu',
                        ),
                        'jura' => array(
                               'title'	    => __('Fachbereich Rechtswissenschaften', 'fau-orga-breadcrumb'),
                               'shorttitle'    => __('Jura', 'fau-orga-breadcrumb'),
                               'url'	    => 'https://jura.rw.fau.de',
                        ),
                    )
	),
	'tf' => array(
		'title'         => __('Technische Fakultät', 'fau-orga-breadcrumb'),
		'shorttitle'    => __('TF', 'fau-orga-breadcrumb'),
		'url'           => 'https://tf.fau.de',
		'url_en'        => 'http://tf.fau.eu',

                'department'    => array(
                    'cbi'   => array(
                               'title'          => __('Department Chemie- und Bioingenieurwesen', 'fau-orga-breadcrumb'),
                               'shorttitle'     => __('CBI', 'fau-orga-breadcrumb'),
                               'url'            => 'https://www.cbi.tf.fau.de/',
                    ),
                    'eei'   => array(
                               'title'          => __('Department Elektrotechnik-Elektronik-Informationstechnik', 'fau-orga-breadcrumb'),
                               'shorttitle'     => __('EEI', 'fau-orga-breadcrumb'),
                               'url'            => 'https://www.eei.tf.fau.de/',
                    ),
                    'informatik'   => array(
                               'title'          => __('Department Informatik', 'fau-orga-breadcrumb'),
                               'title_en'          => __('Department Computer Science', 'fau-orga-breadcrumb'),
                               'shorttitle'     => __('CS', 'fau-orga-breadcrumb'),
                               'url'            => 'https://www.informatik.uni-erlangen.de/',
                    ),
                    'maschinenbau'   => array(
                               'title'          => __('Department Maschinenbau', 'fau-orga-breadcrumb'),
                               'title_en'          => __('Department Informatik', 'fau-orga-breadcrumb'),
                               'shorttitle'     => __('MB', 'fau-orga-breadcrumb'),
                               'url'            => 'https://www.department.mb.tf.fau.de/',
                               'url_en'         => 'https://www.department.mb.tf.fau.eu/'
                    ),
                    'werkstoffwissenschaften'   => array(
                               'title'          => __('Department Werkstoffwissenschaften', 'fau-orga-breadcrumb'),
                               'title_en'      => __('Department of Materials Science and Engineering', 'fau-orga-breadcrumb'),
                               'shorttitle'     => __('WW', 'fau-orga-breadcrumb'),
                               'url'            => 'https://www.ww.tf.fau.de',
                               'url_en'         => 'https://www.ww.tf.fau.eu',
                    ), 
                    
                    
                )
            
	)
    ),
    '_center'	=> array(
	'rrze' => array(
		'title'	    => __('Regionales Rechenzentrum Erlangen (RRZE)', 'fau-orga-breadcrumb'),
		'shorttitle'    => __('RRZE', 'fau-orga-breadcrumb'),
		'url'	    => 'https://rrze.fau.de',
	),

    ),
   
    
);
