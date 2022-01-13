<?php

/* 
 * Constants
 */
$fau_orga_breadcrumb_config = array(
    'root'  => '0000000000',
);

$known_themes = array(
	'fauthemes' => [
		'FAU-Einrichtungen',
		'FAU-Einrichtungen-BETA',
		'FAU-Medfak',
		'FAU-RWFak',
		'FAU-Philfak',
		'FAU-Techfak',
		'FAU-Natfak',
		'FAU-Blog',
	    	'FAU-Jobs'
	],
	'rrzethemes' => [
		'RRZE 2019',
	],
    );
/* 
 * Orgas - Later hopefully via API.... 
 * ... An we really hope that this "later" means in a lifetime.
 * ... Of a human!
 * .. already born!!!
 */

$fau_orga_breadcrumb_data = array(
    '0000000000' => array(
	'title'		=> 'Friedrich-Alexander-Universität',
	'shorttitle'	=> 'FAU', 
	'url'		=> __('https://www.fau.de', 'fau-orga-breadcrumb'),
    ),

    '1005000000' => array(
	'title'	    => __('Zentrale Universitätsverwaltung', 'fau-orga-breadcrumb'),
	'shorttitle'    => 'ZUV',
	'url'	    => __('https://www.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000'
    ),
     '1011000000'	=> array(
	'title'	=> __('Zentrale Einrichtungen', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
	'hide'	    => true,
    ),
    '1011110000' => array(
	'title'	    => __('Universitätsbibliothek', 'fau-orga-breadcrumb'),
	'shorttitle'    => 'UB',
	'url'	    => __('https://ub.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '1011000000'
    ),
     '1011120000' => array(
	'title'	    => __('Regionales Rechenzentrum Erlangen', 'fau-orga-breadcrumb'),
	'shorttitle'    => 'RRZE',
	'url'	    => __('https://rrze.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '1011000000'
    ),
     '1011130000' => array(
	'title'	    => __('Zentralinstitut für Regionenforschung', 'fau-orga-breadcrumb'),
	'parent'    => '1011000000'
    ),
    '1011200000' => array(
	'title'	    => __('Graduiertenzentrum der FAU', 'fau-orga-breadcrumb'),
	'parent'    => '1011000000'
    ),
     '1011290000' => array(
	'title'	    => __('Zentrum für Lehr-/Lernforschung, -innovation und Transfer', 'fau-orga-breadcrumb'),
	'shorttitle'    => 'ZeLLIT',
	'parent'    => '1011000000'
    ),
     '1011320000' => array(
	'title'	    => __('FAU Forschungszentren', 'fau-orga-breadcrumb'),
	'parent'    => '1011000000'
    ),
    '1011330000' => array(
	'title'	    => __('FAU Kompetenzzentren', 'fau-orga-breadcrumb'),
	'parent'    => '1011000000'
    ),
    '1013000000'	=> array(
	'title'	=> __('Interdisziplinäre Zentren', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
    ),
     '1014000000'	=> array(
	'title'	=> __('Museen und Sammlungen', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
    ),
    '1015000000'	=> array(
	'title'	=> __('DFG-Sonderforschungsbereiche/ Transregios/Transferbereiche', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
    ),
    '1016000000'	=> array(
	'title'	=> __('DFG-Graduiertenkollegs', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
    ),
    '1040000000'	=> array(
	'title'	=> __('Zentrale Serviceeinrichtungen', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
    ),
    '1100000000' => array(
	'title'	    => __('Philosophische Fakultät und Fachbereich Theologie', 'fau-orga-breadcrumb'),
	'shorttitle'    => 'Phil',
	'url'	    => __('https://phil.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
	'class'	    => 'phil',
	'faculty'   => 'phil'
    ),
    '1111000000' => array(
	'title'	    => __('Department Alte Welt und Asiatische Kulturen', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1112000000' => array(
	'title'	    => __('Department Anglistik/Amerikanistik und Romanistik', 'fau-orga-breadcrumb'),
	'parent'    => '110000000'
    ),
    '1113000000' => array(
	'title'	    => __('Department Fachdidaktiken', 'fau-orga-breadcrumb'),
	'url'	    => __('http://www.fachdidaktiken.uni-erlangen.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1114000000' => array(
	'title'	    => __('Department Germanistik und Komparatistik', 'fau-orga-breadcrumb'),
	'url'	    => __('https://www.germanistik.phil.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1115000000' => array(
	'title'	    => __('Department Geschichte', 'fau-orga-breadcrumb'),
	'url'	    => __('https://www.geschichte.phil.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1116000000' => array(
	'title'	    => __('Department Medienwissenschaften und Kunstgeschichte', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1117000000' => array(
	'title'	    => __('Department Pädagogik', 'fau-orga-breadcrumb'),
	'url'	    => __('https://www.department-paedagogik.phil.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1118000000' => array(
	'title'	    => __('Department Psychologie', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1119000000' => array(
	'title'	    => __('Department Sozialwissenschaften und Philosophie', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1120000000' => array(
	'title'	    => __('Fachbereich Theologie', 'fau-orga-breadcrumb'),
	'url'	    => __('https://www.theologie.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
     '1121000000' => array(
	'title'	    => __('Department Islamisch-Religiöse Studien', 'fau-orga-breadcrumb'),
	'url'	    => __('https://www.dirs.phil.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1122000000' => array(
	'title'	    => __('Department Sportwissenschaft und Sport', 'fau-orga-breadcrumb'),
	'url'	    => __('https://www.sport.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1123000000' => array(
	'title'	    => __('Department Digital Humanities and Social Studies', 'fau-orga-breadcrumb'),
	'url'	    => __('https://www.dhss.phil.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    
    
    '1200000000' => array(
	'title'	    => __('Rechts- und Wirtschaftswissenschaftliche Fakultät', 'fau-orga-breadcrumb'),
	'shorttitle'    => 'RW',
	'url'	    => __('https://rw.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
	'class'	    => 'rw',
	'faculty'   => 'rw'
    ),
    '1211000000' => array(
	'title'	    => __('Fachbereich Rechtswissenschaften', 'fau-orga-breadcrumb'),
	'shorttitle'    => __('Jura', 'fau-orga-breadcrumb'),
	'url'	    => __('https://jura.rw.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
	'class'	    => 'rw',
	'faculty'   => 'rw'
    ),
    '1212000000' => array(
	'title'	    => __('Fachbereich Wirtschaftswissenschaften', 'fau-orga-breadcrumb'),
	'shorttitle'    => 'WiSo',
	'url'	    => __('https://wiso.rw.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
	'class'	    => 'rw',
	'faculty'   => 'rw'
    ),
    
    
    '1300000000' => array(
	    'title'	    => __('Medizinische Fakultät', 'fau-orga-breadcrumb'),
	    'shorttitle'    => 'Med', 
	    'url'	    => __('https://med.fau.de', 'fau-orga-breadcrumb'),
	    'parent'    => '0000000000',
	'class'	    => 'med',
	'faculty'   => 'med'
    ),
    '1311000000' => array(
	    'title'	    => __('Einrichtungen, die nicht zum Universitätsklinikum Erlangen gehören', 'fau-orga-breadcrumb'),
	    'parent'    => '1300000000',
	    'hide'	    => true,
    ),
    '1311110000' => array(
	    'title'	    => __('Institut für Anatomie', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.anatomie.med.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311120000' => array(
	    'title'	    => __('Institut für Physiologie und Pathophysiologie', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.physiologie1.uni-erlangen.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311130000' => array(
	    'title'	    => __('Institut für Zelluläre und Molekulare Physiologie', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.physiologie2.med.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311140000' => array(
	    'title'	    => __('Institut für Biochemie', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.biochemie.med.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311310000' => array(
	    'title'	    => __('Institut für Medizininformatik, Biometrie und Epidemiologie', 'fau-orga-breadcrumb'),
	    'url'	    => __('http://www.imbe.med.uni-erlangen.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311320000' => array(
	    'title'	    => __('Institut für Geschichte und Ethik der Medizin', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.igem.med.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311330000' => array(
	    'title'	    => __('Institut für Rechtsmedizin', 'fau-orga-breadcrumb'),
	    'url'	    => __('http://www.recht.med.uni-erlangen.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311340000' => array(
	    'title'	    => __('Institut für Experimentelle und Klinische Pharmakologie und Toxikologie', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.pharmakologie.med.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311350000' => array(
	    'title'	    => __('Institut und Poliklinik für Arbeits-, Sozial- und Umweltmedizin', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.ipasum.med.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311360000' => array(
	    'title'	    => __('Institut für Biomedizin des Alterns', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.iba.med.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
    '1311370000' => array(
	    'title'	    => __('Klinisch-Molekularbiologisches Forschungszentrum', 'fau-orga-breadcrumb'),
	    'url'	    => __('http://www.molmed.uni-erlangen.de/', 'fau-orga-breadcrumb'),
	    'parent'	    => '1311000000'
    ),
   
    
    
    '1400000000' => array(
	    'title'	    => __('Naturwissenschaftliche Fakultät', 'fau-orga-breadcrumb'),
	    'shorttitle'    => 'Nat', 
	    'url'	    => __('https://nat.fau.de', 'fau-orga-breadcrumb'),
	    'parent'    => '0000000000',
	    'class'	    => 'nat',
	    'faculty'   => 'nat'
    ),
    '1411000000' => array(
	    'title'	    => __('Department Biologie', 'fau-orga-breadcrumb'),
	    'shorttitle'    => 'Bio',
	    'url'	    => __('https://www.biologie.nat.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'    => '1400000000'
    ),
    '1412000000' => array(
	    'title'	    => __('Department Chemie und Pharmazie', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.chemie.nat.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'    => '1400000000'
    ),
    '1413000000' => array(
	    'title'	    => __('Department Geographie und Geowissenschaften', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.geographie.nat.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'    => '1400000000'
    ),
    '1414000000' => array(
	    'title'	    => __('Department Mathematik', 'fau-orga-breadcrumb'),
	    'url'	    => __('http://www.math.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'    => '1400000000'
    ),
    '1415000000' => array(
	    'title'	    => __('Department Physik', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.physik.nat.fau.de/', 'fau-orga-breadcrumb'),
	    'parent'    => '1400000000'
    ),
     '1416000000' => array(
	    'title'	    => __('Department of Data Science', 'fau-orga-breadcrumb'),
	    'url'	    => __('https://www.datascience.nat.fau.eu/', 'fau-orga-breadcrumb'),
	    'parent'    => '1400000000'
    ),
	
	
    '1500000000' => array(
	'title'         => __('Technische Fakultät', 'fau-orga-breadcrumb'),
	'shorttitle'    =>  'TF', 
	'url'           => __('https://tf.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '0000000000',
	'class'	    => 'tf',
	'faculty'   => 'tf'
    ),    
    '1511000000'   => array(
	'title'          => __('Department Chemie- und Bioingenieurwesen', 'fau-orga-breadcrumb'),
	'shorttitle'     => 'CBI', 
	'url'            => __('https://www.cbi.tf.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1500000000'
    ),
    '1512000000'   => array(
	'title'          => __('Department Elektrotechnik-Elektronik-Informationstechnik', 'fau-orga-breadcrumb'),
	'shorttitle'     => 'EEI', 
	'url'            => __('https://www.eei.tf.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1500000000'
    ),
    '1513000000'   => array(
	'title'          => __('Department Informatik', 'fau-orga-breadcrumb'),
	'shorttitle'     => 'CS',
	'url'            => __('http://www.cs.fau.de/DE', 'fau-orga-breadcrumb'),
	'parent'    => '1500000000'
    ),
    '1514000000'   => array(
	'title'          => __('Department Maschinenbau', 'fau-orga-breadcrumb'),
	'shorttitle'     => 'MB', 
	'url'            => __('https://www.department.mb.tf.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1500000000'
    ),
    '1515000000'   => array(
	'title'          => __('Department Werkstoffwissenschaften', 'fau-orga-breadcrumb'),
	'url'            => __('https://www.ww.tf.fau.de', 'fau-orga-breadcrumb'),
	'parent'    => '1500000000'
    ), 
       '1518000000'   => array(
	'title'          => __('Department Artificial Intelligence in Biomedical Engineering', 'fau-orga-breadcrumb'),
	'url'            => __('https://www.aibe.tf.fau.de/', 'fau-orga-breadcrumb'),
	'parent'    => '1500000000'
    ), 
	
    '9900000000' => array(
	'title'		=> 'Externe Einrichtungen',
    ),
);

