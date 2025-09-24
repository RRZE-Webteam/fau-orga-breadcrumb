<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/**
 * Organisatorische Daten
 */
return [
    '0000000000' => [
        'title' => 'Friedrich-Alexander-Universität',
        'shorttitle' => 'FAU',
        'url' => 'https://www.fau.de',
    ],

    '1005000000' => [
        'title' => 'Zentrale Universitätsverwaltung',
        'shorttitle' => 'ZUV',
        'parent' => '0000000000'
    ],
    '1011000000' => [
        'title' => 'Zentrale Einrichtungen',
        'parent' => '0000000000',
        'hide' => true,
    ],
    '1011200000' => [
        'title' => 'Graduiertenzentrum der FAU',
        'url' => 'https://www.fau.de/graduiertenzentrum/',
        'parent' => '1011000000'
    ],
    '1011120000' => [
        'title' => 'Regionales Rechenzentrum Erlangen',
        'shorttitle' => 'RRZE',
        'url' => 'https://www.rrze.fau.de',
        'parent' => '1011000000'
    ],
    '1011400000' => [
        'title' => 'Sprachenzentrum',
        'url' => 'https://sz.fau.de',
        'parent' => '1011000000'
    ],
    '1011110000' => [
        'title' => 'Universitätsbibliothek',
        'url' => 'https://ub.fau.de',
        'parent' => '1011000000'
    ],
    '1011190000' => [
        'title' => 'Zentrum für Lehrerinnen- und Lehrerbildung',
        'url' => 'https://www.zfl.fau.de',
        'parent' => '1011000000'
    ],
    '1011140000' => [
        'title' => 'Bayerisch-Kalifornisches Hochschulzentrum',
        'url' => 'https://ub.fau.de',
        'parent' => '1011000000'
    ],
    '1011430000' => [
        'title' => 'Bayerisches Hochschulzentrum für Lateinamerika',
        'url' => 'https://www.bacatec.de/de/',
        'parent' => '1011000000'
    ],
    '1011300000' => [
        'title' => 'Zentrum für Nationales Hochleistungsrechnen Erlangen',
        'url' => 'https://hpc.fau.de',
        'parent' => '1011000000'
    ],

    '1011320000' => [
        'title' => 'FAU Forschungszentren',
        'parent' => '1011000000'
    ],

    'profilzentren' => [
        'title' => 'FAU Profilzentren',
        'parent' => '1011000000'
    ],
    '1011330000' => [
        'title' => 'FAU Kompetenzzentren',
        'parent' => '1011000000'
    ],

    '1015000000' => [
        'title' => 'DFG-Sonderforschungsbereiche/Transregios/Transferbereiche',
        'parent' => '0000000000',
    ],
    '1016000000' => [
        'title' => 'DFG-Graduiertenkollegs',
        'parent' => '0000000000',
    ],
    '1019000000' => [
        'title' => 'DFG-Kollegforschergruppen',
        'parent' => '0000000000',
    ],
    '1017000000' => [
        'title' => 'Institutionelle Kooperations- und Förderprojekte',
        'parent' => '0000000000',
    ],
    '1040000000' => [
        'title' => 'Zentrale Serviceeinrichtungen',
        'parent' => '0000000000',
    ],
    '1014000000' => [
        'title' => 'Museen und Sammlungen',
        'parent' => '0000000000',
    ],
    '1100000000' => [
        'title' => 'Philosophische Fakultät und Fachbereich Theologie',
        'shorttitle' => 'Phil',
        'url' => 'https://www.phil.fau.de',
        'parent' => '0000000000',
        'class' => 'phil',
        'faculty' => 'phil'
    ],
    '1111000000' => [
        'title' => 'Department Alte Welt und Asiatische Kulturen',
        'parent' => '1100000000'
    ],
    '1112000000' => [
        'title' => 'Department Anglistik/Amerikanistik und Romanistik',
        'parent' => '1100000000'
    ],
    '1113000000' => [
        'title' => 'Department Fachdidaktiken',
        'url' => 'https://www.fachdidaktiken.phil.fau.de',
        'parent' => '1100000000'
    ],
    '1114000000' => [
        'title' => 'Department Germanistik und Komparatistik',
        'url' => 'https://www.germanistik.phil.fau.de/',
        'parent' => '1100000000'
    ],
    '1115000000' => [
        'title' => 'Department Geschichte',
        'url' => 'https://www.geschichte.phil.fau.de/',
        'parent' => '1100000000'
    ],
    '1116000000' => [
        'title' => 'Department Medienwissenschaften und Kunstgeschichte',
        'parent' => '1100000000'
    ],
    '1117000000' => [
        'title' => 'Department Pädagogik',
        'url' => 'https://www.department-paedagogik.phil.fau.de/',
        'parent' => '1100000000'
    ],
    '1118000000' => [
        'title' => 'Department Psychologie',
        'parent' => '1100000000'
    ],
    '1119000000' => [
        'title' => 'Department Sozialwissenschaften und Philosophie',
        'parent' => '1100000000'
    ],
    '1120000000' => [
        'title' => 'Fachbereich Theologie',
        'url' => 'https://www.theologie.fau.de',
        'parent' => '1100000000'
    ],
    '1121000000' => [
        'title' => 'Department Islamisch-Religiöse Studien',
        'url' => 'https://www.dirs.phil.fau.de/',
        'parent' => '1100000000'
    ],
    '1122000000' => [
        'title' => 'Department Sportwissenschaft und Sport',
        'url' => 'https://www.sport.fau.de',
        'parent' => '1100000000'
    ],
    '1123000000' => [
        'title' => 'Department Digital Humanities and Social Studies',
        'url' => 'https://www.dhss.phil.fau.de/',
        'parent' => '1100000000'
    ],


    '1200000000' => [
        'title' => 'Rechts- und Wirtschaftswissenschaftliche Fakultät',
        'shorttitle' => 'RW',
        'url' => 'https://www.rw.fau.de',
        'parent' => '0000000000',
        'class' => 'rw',
        'faculty' => 'rw'
    ],
    '1211000000' => [
        'title' => 'Fachbereich Rechtswissenschaft',
        'shorttitle' => 'FB Rechtsw.',
        'url' => 'https://www.jura.rw.fau.de',
        'parent' => '0000000000',
        'class' => 'rw',
        'faculty' => 'rw'
    ],
    '1212000000' => [
        'title' => 'Fachbereich Wirtschafts- und Sozialwissenschaften',
        'shorttitle' => 'FB WiSo',
        'url' => 'https://www.wiso.rw.fau.de',
        'parent' => '0000000000',
        'class' => 'rw',
        'faculty' => 'rw'
    ],


    '1300000000' => [
        'title' => 'Medizinische Fakultät',
        'shorttitle' => 'Med',
        'url' => 'https://www.med.fau.de',
        'parent' => '0000000000',
        'class' => 'med',
        'faculty' => 'med'
    ],
    '1311000000' => [
        'title' => 'Einrichtungen, die nicht zum Universitätsklinikum Erlangen gehören',
        'parent' => '1300000000',
        'hide' => true,
    ],
    '1311110000' => [
        'title' => 'Institut für Anatomie',
        'url' => 'https://www.anatomie.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311120000' => [
        'title' => 'Institut für Physiologie und Pathophysiologie',
        'url' => 'https://www.physiologie1.uni-erlangen.de/',
        'parent' => '1311000000'
    ],
    '1311130000' => [
        'title' => 'Institut für Zelluläre und Molekulare Physiologie',
        'url' => 'https://www.physiologie2.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311140000' => [
        'title' => 'Institut für Biochemie',
        'url' => 'https://www.biochemie.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311310000' => [
        'title' => 'Institut für Medizininformatik, Biometrie und Epidemiologie',
        'url' => 'https://www.imbe.med.uni-erlangen.de/',
        'parent' => '1311000000'
    ],
    '1311320000' => [
        'title' => 'Institut für Geschichte und Ethik der Medizin',
        'url' => 'https://www.igem.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311330000' => [
        'title' => 'Institut für Rechtsmedizin',
        'url' => 'https://www.recht.med.uni-erlangen.de/',
        'parent' => '1311000000'
    ],
    '1311340000' => [
        'title' => 'Institut für Experimentelle und Klinische Pharmakologie und Toxikologie',
        'url' => 'https://www.pharmakologie.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311350000' => [
        'title' => 'Institut und Poliklinik für Arbeits-, Sozial- und Umweltmedizin',
        'url' => 'https://www.ipasum.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311360000' => [
        'title' => 'Institut für Biomedizin des Alterns',
        'url' => 'https://www.iba.med.fau.de/',
        'parent' => '1311000000'
    ],
    '1311370000' => [
        'title' => 'Klinisch-Molekularbiologisches Forschungszentrum',
        'url' => 'http://www.molmed.uni-erlangen.de/',
        'parent' => '1311000000'
    ],
    '1311390000' => [
        'title' => 'Institut für Lehre und Forschung am Medizincampus Oberfranken',
        'url' => 'https://www.med.fau.de/fakultaet/einrichtungen/medizincampus-oberfranken/',
        'parent' => '1311000000',
    ],
    '1311400000' => [
        'title' => 'Medizinisches Institut für Biophysik',
        'url' => 'https://www.med.fau.de/fakultaet/einrichtungen/klinisch-theoretische-institute/#collapse_4',
        'parent' => '1311000000',
    ],

    '1400000000' => [
        'title' => 'Naturwissenschaftliche Fakultät',
        'shorttitle' => 'Nat',
        'url' => 'https://www.nat.fau.de',
        'parent' => '0000000000',
        'class' => 'nat',
        'faculty' => 'nat'
    ],
    '1411000000' => [
        'title' => 'Department Biologie',
        'shorttitle' => 'Bio',
        'url' => 'https://www.biologie.nat.fau.de/',
        'parent' => '1400000000'
    ],
    '1412000000' => [
        'title' => 'Department Chemie und Pharmazie',
        'url' => 'https://www.chemie.nat.fau.de/',
        'parent' => '1400000000'
    ],
    '1413000000' => [
        'title' => 'Department Geographie und Geowissenschaften',
        'url' => 'https://www.geo.nat.fau.de/',
        'parent' => '1400000000'
    ],
    '1414000000' => [
        'title' => 'Department Mathematik',
        'url' => 'https://www.math.fau.de/',
        'parent' => '1400000000'
    ],
    '1415000000' => [
        'title' => 'Department Physik',
        'url' => 'https://www.physik.nat.fau.de/',
        'parent' => '1400000000'
    ],
    '1416000000' => [
        'title' => 'Department of Data Science',
        'url' => 'https://www.datascience.nat.fau.eu/',
        'parent' => '1400000000'
    ],


    '1500000000' => [
        'title' => 'Technische Fakultät',
        'shorttitle' => 'TF',
        'url' => 'https://www.tf.fau.de',
        'parent' => '0000000000',
        'class' => 'tf',
        'faculty' => 'tf'
    ],
    '1511000000' => [
        'title' => 'Department Chemie- und Bioingenieurwesen',
        'shorttitle' => 'CBI',
        'url' => 'https://www.cbi.tf.fau.de/',
        'parent' => '1500000000'
    ],
    '1512000000' => [
        'title' => 'Department Elektrotechnik-Elektronik-Informationstechnik',
        'shorttitle' => 'EEI',
        'url' => 'https://www.eei.tf.fau.de/',
        'parent' => '1500000000'
    ],
    '1513000000' => [
        'title' => 'Department Informatik',
        'shorttitle' => 'CS',
        'url' => 'https://cs.fau.de/',
        'parent' => '1500000000'
    ],
    '1514000000' => [
        'title' => 'Department Maschinenbau',
        'shorttitle' => 'MB',
        'url' => 'https://www.department.mb.tf.fau.de/',
        'parent' => '1500000000'
    ],
    '1515000000' => [
        'title' => 'Department Werkstoffwissenschaften',
        'url' => 'https://www.ww.tf.fau.de',
        'parent' => '1500000000'
    ],
    '1518000000' => [
        'title' => 'Department Artificial Intelligence in Biomedical Engineering',
        'url' => 'https://www.aibe.tf.fau.de/',
        'parent' => '1500000000'
    ],

    '9900000000' => [
        'title' => 'Externe Einrichtungen',
    ],
];
