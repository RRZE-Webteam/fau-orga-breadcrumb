<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * Organizational data of FAU
 */
return [
    '0000000000' => [
        'title' => 'Friedrich-Alexander University',
        'shorttitle' => 'FAU',
        'url' => 'https://www.fau.eu',
    ],

    '1005000000' => [
        'title' => 'Central University Administration',
        'shorttitle' => 'ZUV',
        'parent' => '0000000000'
    ],
    '1011000000' => [
        'title' => 'Central Institutions',
        'parent' => '0000000000',
        'hide' => true,
    ],
    '1011110000' => [
        'title' => 'University Library',
        'shorttitle' => 'UB',
        'url' => 'https://ub.fau.de/en/',
        'parent' => '1011000000'
    ],
    '1011120000' => [
        'title' => 'Regional Computer Center Erlangen',
        'shorttitle' => 'RRZE',
        'url' => 'https://www.rrze.fau.de',
        'parent' => '1011000000'
    ],
    '1011140000' => [
        'title' => 'Bavarian–California University Center',
        'url' => 'https://www.bacatec.de/en/',
        'parent' => '1011000000'
    ],
    '1011180000' => [
        'title' => 'Language Center',
        'url' => 'https://sz.fau.eu',
        'parent' => '1011000000'
    ],
    '1011190000' => [
        'title' => 'Center for Teacher Education',
        'url' => 'https://www.zfl.fau.de',
        'parent' => '1011000000'
    ],
    '1011200000' => [
        'title' => 'FAU Graduate Center',
        'url' => 'https://www.fau.eu/graduate-centre/',
        'parent' => '1011000000'
    ],
    '1011430000' => [
        'title' => 'Bavarian University Center for Latin America',
        'url' => 'https://www.baylat.org',
        'parent' => '1011000000'
    ],
    '1011300000' => [
        'title' => 'Erlangen National High-Performance Computing Center',
        'url' => 'https://hpc.fau.de',
        'parent' => '1011000000'
    ],

    '1011320000' => [
        'title' => 'FAU Research Centers',
        'parent' => '1011000000'
    ],

    'profilzentren' => [
        'title' => 'FAU Profile Centers',
        'parent' => '1011000000'
    ],
    '1011330000' => [
        'title' => 'FAU Competence Centers',
        'parent' => '1011000000'
    ],
    '1015000000' => [
        'title' => 'DFG Collaborative Research Centres/Transregios/Transfer Units',
        'parent' => '0000000000',
    ],
    '1016000000' => [
        'title' => 'DFG Research Training Groups',
        'parent' => '0000000000',
    ],
    '1019000000' => [
        'title' => 'DFG Centres for Advanced Studies',
        'parent' => '0000000000',
    ],
    '1017000000' => [
        'title' => 'Institutional Cooperation and Funding Projects',
        'parent' => '0000000000',
    ],
    '1040000000' => [
        'title' => 'Central Service Facilities',
        'parent' => '0000000000',
    ],
    '1014000000' => [
        'title' => 'Museums and Collections',
        'parent' => '0000000000',
    ],
    '1100000000' => [
        'title' => 'Faculty of Humanities, Social Sciences, and Theology',
        'shorttitle' => 'Phil',
        'url' => 'https://www.phil.fau.eu',
        'parent' => '0000000000',
        'class' => 'phil',
        'faculty' => 'phil'
    ],
    '1111000000' => [
        'title' => 'Department of Classical World and Asian Cultures',
        'url' => 'https://www.phil.fau.eu/faculty/organisation/departments/',
        'parent' => '1100000000'
    ],
    '1112000000' => [
        'title' => 'Department of English/American Studies and Romance Studies',
        'url' => 'https://www.angam.phil.fau.de',
        'parent' => '1100000000'
    ],
    '1113000000' => [
        'title' => 'Department of Subject-specific Education Research',
        'url' => 'https://www.fachdidaktiken.phil.fau.de',
        'parent' => '1100000000'
    ],
    '1114000000' => [
        'title' => 'Department of German and Comparative Studies',
        'url' => 'https://www.germanistik.phil.fau.de/',
        'parent' => '1100000000'
    ],
    '1115000000' => [
        'title' => 'Department of History',
        'url' => 'https://www.geschichte.phil.fau.de/',
        'parent' => '1100000000'
    ],
    '1116000000' => [
        'title' => 'Department of Media Studies and Art History',
        'url' => 'https://www.kunstgeschichte.phil.fau.de',
        'parent' => '1100000000'
    ],
    '1117000000' => [
        'title' => 'Department of Educational Science',
        'url' => 'https://www.department-paedagogik.phil.fau.eu',
        'parent' => '1100000000'
    ],
    '1118000000' => [
        'title' => 'Department of Psychology',
        'url' => 'https://www.phil.fau.eu/faculty/organisation/departments/',
        'parent' => '1100000000'
    ],
    '1119000000' => [
        'title' => 'Department of Social Sciences and Philosophy',
        'url' => 'https://www.phil.fau.eu/faculty/organisation/departments/',
        'parent' => '1100000000'
    ],
    '1120000000' => [
        'title' => 'School of Theology',
        'url' => 'https://www.theologie.fau.de',
        'parent' => '1100000000'
    ],
    '1121000000' => [
        'title' => 'Department of Islamic Religious Studies',
        'url' => 'https://www.dirs.phil.fau.de/',
        'parent' => '1100000000'
    ],
    '1122000000' => [
        'title' => 'Department of Sport Science and Sport',
        'url' => 'https://www.sport.fau.eu',
        'parent' => '1100000000'
    ],
    '1123000000' => [
        'title' => 'Department of Digital Humanities and Social Studies',
        'url' => 'https://www.dhss.phil.fau.eu',
        'parent' => '1100000000'
    ],

    '1200000000' => [
        'title' => 'School of Law and Economics',
        'shorttitle' => 'RW',
        'url' => 'https://www.rw.fau.eu',
        'parent' => '0000000000',
        'class' => 'rw',
        'faculty' => 'rw'
    ],
    '1211000000' => [
        'title' => 'School of Law',
        'shorttitle' => 'School of Law',
        'url' => 'https://www.jura.rw.fau.de',
        'parent' => '0000000000',
        'class' => 'rw',
        'faculty' => 'rw'
    ],
    '1212000000' => [
        'title' => 'School of Business, Economics and Society',
        'shorttitle' => 'FB WiSo',
        'url' => 'https://www.wiso.rw.fau.eu',
        'parent' => '0000000000',
        'class' => 'rw',
        'faculty' => 'rw'
    ],

    '1300000000' => [
        'title' => 'Faculty of Medicine',
        'shorttitle' => 'Med',
        'url' => 'https://www.med.fau.de',
        'parent' => '0000000000',
        'class' => 'med',
        'faculty' => 'med'
    ],
    '1311000000' => [
        'title' => 'Institutes not part of Universitätsklinikum Erlangen',
        'parent' => '1300000000',
        'hide' => true,
    ],
    '1311110000' => [
        'title' => 'Institute of Anatomy',
        'url' => 'https://www.anatomie.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311120000' => [
        'title' => 'Institute of Physiology and Pathophysiology',
        'url' => 'https://www.physiologie1.med.fau.de/en/',
        'parent' => '1311000000'
    ],
    '1311130000' => [
        'title' => 'Institute of Cellular and Molecular Physiology',
        'url' => 'https://www.physiologie2.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311140000' => [
        'title' => 'Institute of Biochemistry',
        'url' => 'https://www.biochemie.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311310000' => [
        'title' => 'Institute of Medical Informatics, Biometry and Epidemiology',
        'url' => 'https://www.imbe.med.uni-erlangen.de/',
        'parent' => '1311000000'
    ],
    '1311320000' => [
        'title' => 'Institute of History and Ethics of Medicine',
        'url' => 'https://www.igem.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311330000' => [
        'title' => 'Institute of Forensic Medicine',
        'url' => 'https://www.recht.med.uni-erlangen.de/',
        'parent' => '1311000000'
    ],
    '1311340000' => [
        'title' => 'Institute of Experimental and Clinical Pharmacology and Toxicology',
        'url' => 'https://www.pharmakologie.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311350000' => [
        'title' => 'Institute and Outpatient Clinic of Occupational, Social and Environmental Medicine',
        'url' => 'https://www.ipasum.med.fau.de/en/',
        'parent' => '1311000000'
    ],
    '1311360000' => [
        'title' => 'Institute of Biomedicine of Aging',
        'url' => 'https://www.iba.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311370000' => [
        'title' => 'Nikolaus Fiebiger Center of Molecular Medicine (NFZ)',
        'url' => 'https://www.em1.med.fau.de/#collapse_12',
        'parent' => '1311000000'
    ],
    '1311390000' => [
        'title' => 'Institute of Research and Teaching, Medizincampus Oberfranken',
        'url' => 'https://www.med.fau.de/fakultaet/einrichtungen/medizincampus-oberfranken/',
        'parent' => '1300000000',
    ],
    '1311400000' => [
        'title' => 'Medical Institute of Biophysics',
        'url' => 'https://www.med.fau.de/fakultaet/einrichtungen/klinisch-theoretische-institute/#collapse_4',
        'parent' => '1300000000',
    ],

    '1400000000' => [
        'title' => 'Faculty of Sciences',
        'shorttitle' => 'Nat',
        'url' => 'https://www.nat.fau.eu',
        'parent' => '0000000000',
        'class' => 'nat',
        'faculty' => 'nat'
    ],
    '1411000000' => [
        'title' => 'Department of Biology',
        'shorttitle' => 'Bio',
        'url' => 'https://www.biologie.nat.fau.eu/',
        'parent' => '1400000000'
    ],
    '1412000000' => [
        'title' => 'Department of Chemistry and Pharmacy',
        'url' => 'https://www.chemie.nat.fau.eu/',
        'parent' => '1400000000'
    ],
    '1413000000' => [
        'title' => 'Department of Geography and Geosciences',
        'url' => 'https://www.geo.nat.fau.de/',
        'parent' => '1400000000'
    ],
    '1414000000' => [
        'title' => 'Department of Mathematics',
        'url' => 'https://en.www.math.fau.de',
        'parent' => '1400000000'
    ],
    '1415000000' => [
        'title' => 'Department of Physics',
        'url' => 'https://www.physics.nat.fau.eu',
        'parent' => '1400000000'
    ],
    '1416000000' => [
        'title' => 'Department of Data Science',
        'url' => 'https://www.datascience.nat.fau.eu/',
        'parent' => '1400000000'
    ],

    '1500000000' => [
        'title' => 'Faculty of Engineering',
        'shorttitle' => 'TF',
        'url' => 'https://www.tf.fau.eu',
        'parent' => '0000000000',
        'class' => 'tf',
        'faculty' => 'tf'
    ],
    '1511000000' => [
        'title' => 'Department of Chemical and Biological Engineering',
        'shorttitle' => 'CBI',
        'url' => 'https://www.cbi.tf.fau.eu',
        'parent' => '1500000000'
    ],
    '1512000000' => [
        'title' => 'Department of Electrical, Electronic and Communication Engineering',
        'shorttitle' => 'EEI',
        'url' => 'https://www.eei.tf.fau.de/',
        'parent' => '1500000000'
    ],
    '1513000000' => [
        'title' => 'Department of Computer Science',
        'shorttitle' => 'CS',
        'url' => 'https://cs.fau.de/',
        'parent' => '1500000000'
    ],
    '1514000000' => [
        'title' => 'Department of Mechanical Engineering',
        'shorttitle' => 'MB',
        'url' => 'https://www.department.mb.tf.fau.de/',
        'parent' => '1500000000'
    ],
    '1515000000' => [
        'title' => 'Department of Materials Science',
        'url' => 'https://www.ww.tf.fau.eu',
        'parent' => '1500000000'
    ],
    '1518000000' => [
        'title' => 'Department of Artificial Intelligence in Biomedical Engineering',
        'url' => 'https://www.aibe.tf.fau.de/',
        'parent' => '1500000000'
    ],

    '9900000000' => [
        'title' => 'External Institutions',
    ],
];
