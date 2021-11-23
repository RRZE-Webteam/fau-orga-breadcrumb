<?php

/* 
 * Constants
 */
$fau_orga_breadcrumb_config = array(
    'root'  => '000000000',
    'devider'   => '<span>/</span>'
);



/* 
 * Orgas - Later hopefully via API.... 
 * ... An we really hope that this "later" means in a lifetime.
 * ... Of a human!
 * .. already born!!!
 */

$fau_orga_breadcrumb_data = array(
    '0000000000' => array(
	'title'		=> __('Friedrich-Alexander-Universität Erlangen-Nürnberg', 'fau-orga-breadcrumb'),
	'shorttitle'	=> __('FAU', 'fau-orga-breadcrumb'),
	'url'		=> 'https://www.fau.de',
	'url_en'	=> 'https://www.fau.eu',
    ),
    '1000000000'	=> array(
	'title'	=> 'Friedrich-Alexander-Universität Erlangen-Nürnberg Zentralbereich',
	'parent'    => '0000000000',
	'hide'	    => true,
    ),
    '1011000000'	=> array(
	'title'	=> 'Zentrale Einrichtungen',
	'parent'    => '1000000000',
    ),
    '1011120000' => array(
	'title'	    => __('Regionales Rechenzentrum Erlangen (RRZE)', 'fau-orga-breadcrumb'),
	'shorttitle'    => __('RRZE', 'fau-orga-breadcrumb'),
	'url'	    => 'https://rrze.fau.de',
	'parent'    => '0000000000'
    ),
    
    '1100000000' => array(
	'title'	    => __('Philosophische Fakultät', 'fau-orga-breadcrumb'),
	'shorttitle'    => __('Phil', 'fau-orga-breadcrumb'),
	'url'	    => 'https://phil.fau.de',
	'url_en'	    => 'https://phil.fau.eu',
	'parent'    => '0000000000'
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
	'url'	    => 'http://www.fachdidaktiken.uni-erlangen.de/',
	'parent'    => '1100000000'
    ),
    '1114000000' => array(
	'title'	    => __('Department Germanistik und Komparatistik', 'fau-orga-breadcrumb'),
	'url'	    => 'https://www.germanistik.phil.fau.de/',
	'parent'    => '1100000000'
    ),
    '1115000000' => array(
	'title'	    => __('Department Geschichte', 'fau-orga-breadcrumb'),
	'url'	    => 'https://www.geschichte.phil.fau.de/',
	'parent'    => '1100000000'
    ),
    '1116000000' => array(
	'title'	    => __('Department Medienwissenschaften und Kunstgeschichte', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1117000000' => array(
	'title'	    => __('Department Pädagogik', 'fau-orga-breadcrumb'),
	'url'	    => 'https://www.department-paedagogik.phil.fau.de/',
	'parent'    => '1100000000'
    ),
    '1118000000' => array(
	'title'	    => __('Department Psychologie', 'fau-orga-breadcrumb'),
	'parent'    => '1100000000'
    ),
    '1119000000' => array(
	'title'	    => __('Department Sozialwissenschaften und Philosophie', 'fau-orga-breadcrumb'),
	'url'	    => 'http://www.department-sozialwissenschaften-und-philosophie.phil.uni-erlangen.de/',
	'parent'    => '1100000000'
    ),
    '1120000000' => array(
	'title'	    => __('Fachbereich Theologie', 'fau-orga-breadcrumb'),
	'url'	    => 'https://www.theologie.fau.de',
	'parent'    => '1100000000'
    ),
     '1121000000' => array(
	'title'	    => __('Department Islamisch-Religiöse Studien', 'fau-orga-breadcrumb'),
	'url'	    => 'http://www.dirs.phil.uni-erlangen.de/',
	'parent'    => '1100000000'
    ),
    '1122000000' => array(
	'title'	    => __('Department Sportwissenschaft und Sport', 'fau-orga-breadcrumb'),
	'url'	    => 'https://www.sport.fau.de',
	'parent'    => '1100000000'
    ),
    
    '1200000000' => array(
	'title'	    => __('Rechts- und Wirtschaftswissenschaftliche Fakultät', 'fau-orga-breadcrumb'),
	'shorttitle'    => __('RW', 'fau-orga-breadcrumb'),
	'url'	    => 'https://rw.fau.de',
	'url_en'	    => 'https://rw.fau.eu', 
	'parent'    => '0000000000'                                            
    ),
    '1211000000' => array(
	'title'	    => __('Fachbereich Rechtswissenschaften', 'fau-orga-breadcrumb'),
	'shorttitle'    => __('Jura', 'fau-orga-breadcrumb'),
	'url'	    => 'https://jura.rw.fau.de',
	'parent'    => '0000000000'           
    ),
    '1212000000' => array(
	'title'	    => __('Fachbereich Wirtschaftswissenschaften', 'fau-orga-breadcrumb'),
	'shorttitle'    => __('WiSo', 'fau-orga-breadcrumb'),
	'url'	    => 'https://wiso.rw.fau.de',
	'url_en'    => 'https://wiso.rw.fau.eu',
	'parent'    => '0000000000'      
    ),
    
    
    '1300000000' => array(
	    'title'	    => __('Medizinische Fakultät', 'fau-orga-breadcrumb'),
	    'shorttitle'    => __('Med', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://med.fau.de',
	    'url_en'	    => 'https://med.fau.eu',
	    'parent'    => '0000000000'
    ),
    '1311000000' => array(
	    'title'	    => __('Einrichtungen, die nicht zum Universitätsklinikum Erlangen gehören', 'fau-orga-breadcrumb'),
	    'parent'    => '1300000000',
	    'hide'	    => true,
    ),
    '1311110000' => array(
	    'title'	    => __('Institut für Anatomie', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.anatomie1.med.fau.de/',
	    'parent'	    => '1311000000'
    ),
    '1311120000' => array(
	    'title'	    => __('Institut für Physiologie und Pathophysiologie', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.physiologie1.uni-erlangen.de/',
	    'parent'	    => '1311000000'
    ),
    '1311130000' => array(
	    'title'	    => __('Institut für Zelluläre und Molekulare Physiologie', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.physiologie2.med.fau.de/',
	    'parent'	    => '1311000000'
    ),
    '1311140000' => array(
	    'title'	    => __('Institut für Biochemie', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.biochemie.med.fau.de/',
	    'parent'	    => '1311000000'
    ),
    '1311310000' => array(
	    'title'	    => __('Institut für Medizininformatik, Biometrie und Epidemiologie', 'fau-orga-breadcrumb'),
	    'url'	    => 'http://www.imbe.med.uni-erlangen.de/',
	    'parent'	    => '1311000000'
    ),
    '1311320000' => array(
	    'title'	    => __('Institut für Geschichte und Ethik der Medizin', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.igem.med.fau.de/',
	    'parent'	    => '1311000000'
    ),
    '1311330000' => array(
	    'title'	    => __('Institut für Rechtsmedizin', 'fau-orga-breadcrumb'),
	    'url'	    => 'http://www.recht.med.uni-erlangen.de/',
	    'parent'	    => '1311000000'
    ),
    '1311340000' => array(
	    'title'	    => __('Institut für Experimentelle und Klinische Pharmakologie und Toxikologie', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.pharmakologie.uni-erlangen.de/',
	    'parent'	    => '1311000000'
    ),
    '1311350000' => array(
	    'title'	    => __('Institut und Poliklinik für Arbeits-, Sozial- und Umweltmedizin', 'fau-orga-breadcrumb'),
	    'url'	    => 'http://www.arbeitsmedizin.uni-erlangen.de/',
	    'parent'	    => '1311000000'
    ),
    '1311360000' => array(
	    'title'	    => __('Institut für Biomedizin des Alterns', 'fau-orga-breadcrumb'),
	    'url'	    => 'http://www.iba.med.uni-erlangen.de/',
	    'parent'	    => '1311000000'
    ),
    '1311370000' => array(
	    'title'	    => __('Klinisch-Molekularbiologisches Forschungszentrum', 'fau-orga-breadcrumb'),
	    'url'	    => 'http://www.molmed.uni-erlangen.de/',
	    'parent'	    => '1311000000'
    ),
    '1311380000' => array(
	    'title'	    => __('Orthopädische Abteilung des Waldkrankenhauses St. Marien, Erlangen, Orthopädische Klinik mit Poliklinik der Friedrich-Alexander-Universität Erlangen-Nürnberg', 'fau-orga-breadcrumb'),
	    'url'	    => 'http://www.waldkrankenhaus.de/',
	    'parent'	    => '1311000000'
    ),
    
    
    
    '1400000000' => array(
	    'title'	    => __('Naturwissenschaftliche Fakultät', 'fau-orga-breadcrumb'),
	    'shorttitle'    => __('Nat', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://nat.fau.de',
	    'url_en'	    => 'https://nat.fau.eu',
	    'parent'    => '0000000000'
    ),
    '1411000000' => array(
	    'title'	    => __('Department Biologie', 'fau-orga-breadcrumb'),
	    'shorttitle'    => __('Bio', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.biologie.nat.fau.de/',
	    'parent'    => '1400000000'
    ),
    '1412000000' => array(
	    'title'	    => __('Department Chemie und Pharmazie', 'fau-orga-breadcrumb'),
	    'shorttitle'    => __('NN', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.nat.fau.de/',
	    'parent'    => '1400000000'
    ),
    '1413000000' => array(
	    'title'	    => __('Department Geographie und Geowissenschaften', 'fau-orga-breadcrumb'),
	    'shorttitle'    => __('Geo', 'fau-orga-breadcrumb'),
	    'url'	    => 'http://www.geo.nat.fau.de/',
	    'parent'    => '1400000000'
    ),
    '1414000000' => array(
	    'title'	    => __('Department Mathematik', 'fau-orga-breadcrumb'),
	    'shorttitle'    => __('Mathe', 'fau-orga-breadcrumb'),
	    'url'	    => 'http://www.math.fau.de/',
	    'parent'    => '1400000000'
    ),
    '1415000000' => array(
	    'title'	    => __('Department Physik', 'fau-orga-breadcrumb'),
	    'shorttitle'    => __('Physik', 'fau-orga-breadcrumb'),
	    'url'	    => 'https://www.physik.nat.fau.de/',
	    'parent'    => '1400000000'
    ),
	
	
    '1500000000' => array(
	'title'         => __('Technische Fakultät', 'fau-orga-breadcrumb'),
	'shorttitle'    => __('TF', 'fau-orga-breadcrumb'),
	'url'           => 'https://tf.fau.de',
	'url_en'        => 'http://tf.fau.eu',
	'parent'    => '0000000000'
    ),    
    '1511000000'   => array(
	'title'          => __('Department Chemie- und Bioingenieurwesen', 'fau-orga-breadcrumb'),
	'shorttitle'     => __('CBI', 'fau-orga-breadcrumb'),
	'url'            => 'https://www.cbi.tf.fau.de/',
	'parent'    => '1500000000'
    ),
    '1512000000'   => array(
	'title'          => __('Department Elektrotechnik-Elektronik-Informationstechnik', 'fau-orga-breadcrumb'),
	'shorttitle'     => __('EEI', 'fau-orga-breadcrumb'),
	'url'            => 'https://www.eei.tf.fau.de/',
	'parent'    => '1500000000'
    ),
    '1513000000'   => array(
	'title'          => __('Department Informatik', 'fau-orga-breadcrumb'),
	'title_en'          => __('Department Computer Science', 'fau-orga-breadcrumb'),
	'shorttitle'     => __('CS', 'fau-orga-breadcrumb'),
	'url'            => 'https://www.informatik.uni-erlangen.de/',
	'parent'    => '1500000000'
    ),
    '1514000000'   => array(
	'title'          => __('Department Maschinenbau', 'fau-orga-breadcrumb'),
	'title_en'          => __('Department Informatik', 'fau-orga-breadcrumb'),
	'shorttitle'     => __('MB', 'fau-orga-breadcrumb'),
	'url'            => 'https://www.department.mb.tf.fau.de/',
	'url_en'         => 'https://www.department.mb.tf.fau.eu/',
	'parent'    => '1500000000'
    ),
    '1515000000'   => array(
	'title'          => __('Department Werkstoffwissenschaften', 'fau-orga-breadcrumb'),
	'title_en'      => __('Department of Materials Science and Engineering', 'fau-orga-breadcrumb'),
	'shorttitle'     => __('WW', 'fau-orga-breadcrumb'),
	'url'            => 'https://www.ww.tf.fau.de',
	'url_en'         => 'https://www.ww.tf.fau.eu',
	'parent'    => '1500000000'
    ), 
                    

);

