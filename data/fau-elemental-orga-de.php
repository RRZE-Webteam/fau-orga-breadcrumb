<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/*
 * Organisatorische Daten für das FAU-Elemental Theme
 */
return [
    // FAU Hauptebene
    '0000000000' => [
        'title' => 'FAU',
        'url' => 'https://www.fau.de',
        'parent' => null,
    ],

    // Fakultäten Container
    'fakultaeten' => [
        'title' => 'Fakultäten',
        'url' => '',
        'parent' => null,
    ],

    // === PHILOSOPHISCHE FAKULTÄT ===
    '1100000000' => [
        'title' => 'Philosophische Fakultät und Fachbereich Theologie',
        'url' => 'https://www.phil.fau.de',
        'parent' => 'fakultaeten',
        'class' => 'phil', //important for the right menu color
        'faculty' => 'phil' //important for the right menu color
    ],
    'virt_1100000000_overview' => [
        'title' => 'Philosophische Fakultät und Fachbereich Theologie',
        'url' => 'https://www.phil.fau.de',
        'parent' => '1100000000',
    ],
    '1111000000' => [
        'title' => 'Department Alte Welt und Asiatische Kulturen',
        'url' => 'https://www.phil.fau.de/fakultaet/organisation-organe/departments',
        'parent' => '1100000000',
    ],
    '1112000000' => [
        'title' => 'Department Anglistik/Amerikanistik und Romanistik',
        'url' => 'https://www.angam.phil.fau.de',
        'parent' => '1100000000',
    ],
    '1113000000' => [
        'title' => 'Department Fachdidaktiken',
        'url' => 'https://www.fachdidaktiken.phil.fau.de',
        'parent' => '1100000000',
    ],
    '1114000000' => [
        'title' => 'Department Germanistik und Komparatistik',
        'url' => 'https://www.germanistik.phil.fau.de/',
        'parent' => '1100000000',
    ],
    '1115000000' => [
        'title' => 'Department Geschichte',
        'url' => 'https://www.geschichte.phil.fau.de/',
        'parent' => '1100000000',
    ],

    '1116000000' => [
        'title' => 'Department Medienwissenschaften und Kunstgeschichte',
        'url' => 'https://www.kunstgeschichte.phil.fau.de',
        'parent' => '1100000000',
    ],
    '1117000000' => [
        'title' => 'Department Pädagogik',
        'url' => 'https://www.department-paedagogik.phil.fau.de/',
        'parent' => '1100000000',
    ],
    '1118000000' => [
        'title' => 'Department Psychologie',
        'url' => 'https://www.phil.fau.de/fakultaet/organisation-organe/departments',
        'parent' => '1100000000',
    ],
    '1119000000' => [
        'title' => 'Department Sozialwissenschaften und Philosophie',
        'url' => 'https://www.phil.fau.de/fakultaet/organisation-organe/departments',
        'parent' => '1100000000',
    ],
        '1120000000' => [
        'title' => 'Fachbereich Theologie',
        'url' => 'https://www.theologie.fau.de',
        'parent' => '1100000000',
    ],
    '1121000000' => [
        'title' => 'Department Islamisch-Religiöse Studien',
        'url' => 'https://www.dirs.phil.fau.de/',
        'parent' => '1100000000',
    ],
    '1122000000' => [
        'title' => 'Department Sportwissenschaft und Sport',
        'url' => 'https://www.sport.fau.de',
        'parent' => '1100000000',
    ],
    '1123000000' => [
        'title' => 'Department Digital Humanities and Social Studies',
        'url' => 'https://www.dhss.phil.fau.de/',
        'parent' => '1100000000',
    ],


    // === RECHTS- UND WIRTSCHAFTSWISSENSCHAFTLICHE FAKULTÄT ===
    '1200000000' => [
        'title' => 'Rechts- und Wirtschaftswissenschaftliche Fakultät',
        'url' => 'https://www.rw.fau.de',
        'parent' => 'fakultaeten',
        'class' => 'rw',
        'faculty' => 'rw'
    ],
    'virt_1200000000_overview' => [
        'title' => 'Rechts- und Wirtschaftswissenschaftliche Fakultät',
        'url' => 'https://www.rw.fau.de',
        'parent' => '1200000000',
    ],
    '1211000000' => [
        'title' => 'Fachbereich Rechtswissenschaft',
        'url' => 'https://www.jura.rw.fau.de',
        'parent' => '1200000000',
    ],
    '1212000000' => [
        'title' => 'Fachbereich Wirtschafts- und Sozialwissenschaften',
        'url' => 'https://www.wiso.rw.fau.de',
        'parent' => '1200000000',
    ],

    // === MEDIZINISCHE FAKULTÄT ===
    '1300000000' => [
        'title' => 'Medizinische Fakultät',
        'url' => 'https://www.med.fau.de',
        'parent' => 'fakultaeten',
        'class' => 'med',
        'faculty' => 'med'
    ],
    'virt_1300000000_overview' => [
        'title' => 'Medizinische Fakultät',
        'url' => 'https://www.med.fau.de',
        'parent' => '1300000000',
    ],
    '1311110000' => [
        'title' => 'Institut für Anatomie',
        'url' => 'https://www.anatomie.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311120000' => [
        'title' => 'Institut für Physiologie und Pathophysiologie',
        'url' => 'https://www.physiologie1.uni-erlangen.de/',
        'parent' => '1300000000',
    ],
    '1311130000' => [
        'title' => 'Institut für Zelluläre und Molekulare Physiologie',
        'url' => 'https://www.physiologie2.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311140000' => [
        'title' => 'Institut für Biochemie',
        'url' => 'https://www.biochemie.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311310000' => [
        'title' => 'Institut für Medizininformatik, Biometrie und Epidemiologie',
        'url' => 'https://www.imbe.med.uni-erlangen.de/',
        'parent' => '1300000000',
    ],
    '1311320000' => [
        'title' => 'Institut für Geschichte und Ethik der Medizin',
        'url' => 'https://www.igem.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311330000' => [
        'title' => 'Institut für Rechtsmedizin',
        'url' => 'https://www.recht.med.uni-erlangen.de/',
        'parent' => '1300000000',
    ],
    '1311340000' => [
        'title' => 'Institut für Experimentelle und Klinische Pharmakologie und Toxikologie',
        'url' => 'https://www.pharmakologie.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311350000' => [
        'title' => 'Institut und Poliklinik für Arbeits-, Sozial- und Umweltmedizin',
        'url' => 'https://www.ipasum.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311360000' => [
        'title' => 'Institut für Biomedizin des Alterns',
        'url' => 'https://www.iba.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311370000' => [
        'title' => 'Klinisch-Molekularbiologisches Forschungszentrum',
        'url' => 'http://www.molmed.uni-erlangen.de/',
        'parent' => '1300000000',
    ],
    '1311390000' => [
        'title' => 'Institut für Lehre und Forschung am Medizincampus Oberfranken',
        'url' => 'https://www.med.fau.de/fakultaet/einrichtungen/medizincampus-oberfranken/',
        'parent' => '1300000000',
    ],
    '1311400000' => [
        'title' => 'Medizinisches Institut für Biophysik',
        'url' => 'https://www.med.fau.de/fakultaet/einrichtungen/klinisch-theoretische-institute/#collapse_4',
        'parent' => '1300000000',
    ],


    // === NATURWISSENSCHAFTLICHE FAKULTÄT ===
    '1400000000' => [
        'title' => 'Naturwissenschaftliche Fakultät',
        'url' => 'https://www.nat.fau.de',
        'parent' => 'fakultaeten',
        'class' => 'nat',
        'faculty' => 'nat'
    ],
    'virt_1400000000_overview' => [
        'title' => 'Naturwissenschaftliche Fakultät',
        'url' => 'https://www.nat.fau.de',
        'parent' => '1400000000',
    ],
    '1411000000' => [
        'title' => 'Department Biologie',
        'url' => 'https://www.biologie.nat.fau.de/',
        'parent' => '1400000000',
    ],
    '1412000000' => [
        'title' => 'Department Chemie und Pharmazie',
        'url' => 'https://www.chemie.nat.fau.de/',
        'parent' => '1400000000',
    ],
    '1413000000' => [
        'title' => 'Department Geographie und Geowissenschaften',
        'url' => 'https://www.geo.nat.fau.de/',
        'parent' => '1400000000',
    ],
    '1414000000' => [
        'title' => 'Department Mathematik',
        'url' => 'https://www.math.fau.de/',
        'parent' => '1400000000',
    ],
    '1415000000' => [
        'title' => 'Department Physik',
        'url' => 'https://www.physik.nat.fau.de/',
        'parent' => '1400000000',
    ],
    '1416000000' => [
        'title' => 'Department of Data Science',
        'url' => 'https://www.datascience.nat.fau.eu/',
        'parent' => '1400000000',
    ],

    // === TECHNISCHE FAKULTÄT ===
    '1500000000' => [
        'title' => 'Technische Fakultät',
        'url' => 'https://www.tf.fau.de',
        'parent' => 'fakultaeten',
        'class' => 'tf',
        'faculty' => 'tf'
    ],
    'virt_1500000000_overview' => [
        'title' => 'Technische Fakultät',
        'url' => 'https://www.tf.fau.de',
        'parent' => '1500000000',
    ],
    '1511000000' => [
        'title' => 'Department Chemie- und Bioingenieurwesen',
        'url' => 'https://www.cbi.tf.fau.de/',
        'parent' => '1500000000',
    ],
    '1512000000' => [
        'title' => 'Department Elektrotechnik-Elektronik-Informationstechnik',
        'url' => 'https://www.eei.tf.fau.de/',
        'parent' => '1500000000',
    ],
    '1513000000' => [
        'title' => 'Department Informatik',
        'url' => 'https://cs.fau.de/',
        'parent' => '1500000000',
    ],
    '1514000000' => [
        'title' => 'Department Maschinenbau',
        'url' => 'https://www.department.mb.tf.fau.de/',
        'parent' => '1500000000',
    ],
    '1515000000' => [
        'title' => 'Department Werkstoffwissenschaften',
        'url' => 'https://www.ww.tf.fau.de',
        'parent' => '1500000000',
    ],
    '1518000000' => [
        'title' => 'Department Artificial Intelligence in Biomedical Engineering',
        'url' => 'https://www.aibe.tf.fau.de/',
        'parent' => '1500000000',
    ],

    // === ZENTRALE EINRICHTUNGEN ===
    'zentrale_einrichtungen' => [
        'title' => 'Zentrale Einrichtungen',
        'url' => '',
        'parent' => null,
    ],
    '1011110000' => [
        'title' => 'Universitätsbibliothek',
        'url' => 'https://ub.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011120000' => [
        'title' => 'Regionales Rechenzentrum Erlangen (RRZE)',
        'url' => 'https://www.rrze.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011140000' => [
        'title' => 'Bayerisch-Kalifornisches Hochschulzentrum (BaCaTeC)',
        'url' => 'https://www.bacatec.de/de/',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011180000' => [
        'title' => 'Sprachenzentrum',
        'url' => 'https://sz.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011190000' => [
        'title' => 'Zentrum für Lehrerinnen- und Lehrerbildung',
        'url' => 'https://www.zfl.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011200000' => [
        'title' => 'Graduiertenzentrum der FAU',
        'url' => 'https://www.fau.de/graduiertenzentrum/',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011430000' => [
        'title' => 'Bayerisches Hochschulzentrum für Lateinamerika (BAYLAT)',
        'url' => 'https://www.baylat.org',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011300000' => [
        'title' => 'Zentrum für Nationales Hochleistungsrechnen Erlangen (NHR)',
        'url' => 'https://hpc.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],

    // === PROFILZENTREN ===
    'profilzentren' => [
        'title' => 'Profilzentren',
        'url' => '',
        'parent' => null,
    ],
    '1011311500' => [
        'title' => 'Immunmedizin (FAU I-MED)',
        'url' => 'https://www.immunology.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311400' => [
        'title' => 'Licht.Materia.Quantentechnologien (FAU LMQ)',
        'url' => 'https://www.lightmatter.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311200' => [
        'title' => 'Medizintechnik (FAU MT)',
        'url' => 'https://www.medicalengineering.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311100' => [
        'title' => 'Neue Materialien und Prozesse (FAU NMP)',
        'url' => 'https://www.newmaterials.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311300' => [
        'title' => 'Solar (FAU Solar)',
        'url' => 'https://www.solar.fau.de',
        'parent' => 'profilzentren',
    ],

    // === FORSCHUNGSZENTREN ===
    'forschungszentren' => [
        'title' => 'Forschungszentren',
        'url' => '',
        'parent' => null,
    ],
    '1011321400' => [
        'title' => 'Center for Human Rights Erlangen-Nürnberg (FAU CHREN)',
        'url' => 'https://www.humanrights.fau.de',
        'parent' => 'forschungszentren',
    ],
    '1011321200' => [
        'title' => 'Embedded Systems Initiative (FAU ESI)',
        'url' => 'https://www.esi.fau.de',
        'parent' => 'forschungszentren',
    ],
    '1011321500' => [
        'title' => 'Islam und Recht in Europa (FAU EZIRE)',
        'url' => 'https://www.ezire.fau.de',
        'parent' => 'forschungszentren',
    ],
    '1011321100' => [
        'title' => 'Mathematics of Data (FAU MoD)',
        'url' => 'https://mod.fau.eu',
        'parent' => 'forschungszentren',
    ],
    '1011321300' => [
        'title' => 'Neue Wirkstoffe (FAU NeW)',
        'url' => 'https://www.new.fau.eu',
        'parent' => 'forschungszentren',
    ],

    // === KOMPETENZZENTREN ===
    'kompetenzzentren' => [
        'title' => 'Kompetenzzentren',
        'url' => '',
        'parent' => null,
    ],
    '1011331300' => [
        'title' => 'Engineering of Advanced Materials (FAU EAM)',
        'url' => 'https://www.eam.fau.eu',
        'parent' => 'kompetenzzentren',
    ],
    '1011331500' => [
        'title' => 'Interdisziplinäre Wissenschaftsreflexion (FAU ZIWIS)',
        'url' => 'https://www.ziwis.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331600' => [
        'title' => 'Lehre (FAU Lehre)',
        'url' => 'https://www.lehre.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331400' => [
        'title' => 'Optical Imaging Compentence Center (FAU OICE)',
        'url' => 'https://www.oice.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331100' => [
        'title' => 'Research Data and Information (FAU CDI)',
        'url' => 'https://www.cdi.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331200' => [
        'title' => 'Scientific Computing (FAU CSC)',
        'url' => 'https://www.csc.fau.eu',
        'parent' => 'kompetenzzentren',
    ],

    // === INNOVATIONSORTE ===
    'innovationsorte' => [
        'title' => 'Innovationsorte',
        'url' => '',
        'parent' => null,
    ],
    '001' => [
        'title' => 'JOSEPHS',
        'url' => 'https://josephs-innovation.de/wp/',
        'parent' => 'innovationsorte',
    ],
    '002' => [
        'title' => 'ZOLLHOF',
        'url' => 'https://zollhof.de',
        'parent' => 'innovationsorte',
    ],
    '003' => [
        'title' => 'd.hip – Digital Health Innovation Platform',
        'url' => 'https://d-hip.de',
        'parent' => 'innovationsorte',
    ],
    '004' => [
        'title' => 'Medical Valley Center',
        'url' => 'https://www.medical-valley-emn.de',
        'parent' => 'innovationsorte',
    ],
    '005' => [
        'title' => 'FAU Innovationsökosystems',
        'url' => 'https://www.new.fau.eu',
        'parent' => 'innovationsorte',
    ],

];
