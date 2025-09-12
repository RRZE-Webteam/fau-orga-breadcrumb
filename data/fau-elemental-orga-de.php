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
        'url' => __('https://www.fau.de', 'fau-orga-breadcrumb'),
        'parent' => null,
    ],

    // Fakultäten Container
    'fakultaeten' => [
        'title' => __('Fakultäten', 'fau-orga-breadcrumb'),
        'url' => '',
        'parent' => null,
    ],

    // === PHILOSOPHISCHE FAKULTÄT ===
    '1100000000' => [
        'title' => __('Philosophische Fakultät und Fachbereich Theologie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.phil.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'fakultaeten',
        'class' => 'phil', //wichtig für die farbliche Darstellung im Menü
        'faculty' => 'phil' //wichtig für die farbliche Darstellung im Menü
    ],
    '1111000000' => [
        'title' => __('Department Alte Welt und Asiatische Kulturen', 'fau-orga-breadcrumb'),
        'url' => __('https://www.phil.fau.de/fakultaet/organisation-organe/departments', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1112000000' => [
        'title' => __('Department Anglistik/Amerikanistik und Romanistik', 'fau-orga-breadcrumb'),
        'url' => __('https://www.angam.phil.fau.de', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1123000000' => [
        'title' => __('Department Digital Humanities and Social Studies', 'fau-orga-breadcrumb'),
        'url' => __('https://www.dhss.phil.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1113000000' => [
        'title' => __('Department Fachdidaktiken', 'fau-orga-breadcrumb'),
        'url' => __('https://www.fachdidaktiken.phil.fau.de', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1114000000' => [
        'title' => __('Department Germanistik und Komparatistik', 'fau-orga-breadcrumb'),
        'url' => __('https://www.germanistik.phil.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1115000000' => [
        'title' => __('Department Geschichte', 'fau-orga-breadcrumb'),
        'url' => __('https://www.geschichte.phil.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1121000000' => [
        'title' => __('Department Islamisch-Religiöse Studien', 'fau-orga-breadcrumb'),
        'url' => __('https://www.dirs.phil.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1116000000' => [
        'title' => __('Department Medienwissenschaften und Kunstgeschichte', 'fau-orga-breadcrumb'),
        'url' => __('https://www.kunstgeschichte.phil.fau.de', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1117000000' => [
        'title' => __('Department Pädagogik', 'fau-orga-breadcrumb'),
        'url' => __('https://www.department-paedagogik.phil.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1118000000' => [
        'title' => __('Department Psychologie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.phil.fau.de/fakultaet/organisation-organe/departments', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1119000000' => [
        'title' => __('Department Sozialwissenschaften und Philosophie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.phil.fau.de/fakultaet/organisation-organe/departments', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],
    '1122000000' => [
        'title' => __('Department Sportwissenschaft und Sport', 'fau-orga-breadcrumb'),
        'url' => __('https://www.sport.fau.de', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],

    '1120000000' => [
        'title' => __('Fachbereich Theologie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.theologie.fau.de', 'fau-orga-breadcrumb'),
        'parent' => '1100000000',
    ],

    // === RECHTS- UND WIRTSCHAFTSWISSENSCHAFTLICHE FAKULTÄT ===
    '1200000000' => [
        'title' => __('Rechts- und Wirtschaftswissenschaftliche Fakultät', 'fau-orga-breadcrumb'),
        'url' => __('https://www.rw.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'fakultaeten',
        'class' => 'rw',
        'faculty' => 'rw'
    ],
    '1211000000' => [
        'title' => __('Fachbereich Rechtswissenschaft', 'fau-orga-breadcrumb'),
        'url' => __('https://www.jura.rw.fau.de', 'fau-orga-breadcrumb'),
        'parent' => '1200000000',
    ],
    '1212000000' => [
        'title' => __('Fachbereich Wirtschafts- und Sozialwissenschaften', 'fau-orga-breadcrumb'),
        'url' => __('https://www.wiso.rw.fau.de', 'fau-orga-breadcrumb'),
        'parent' => '1200000000',
    ],

    // === MEDIZINISCHE FAKULTÄT ===
    '1300000000' => [
        'title' => __('Medizinische Fakultät', 'fau-orga-breadcrumb'),
        'url' => __('https://www.med.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'fakultaeten',
        'class' => 'med',
        'faculty' => 'med'
    ],
    '1311110000' => [
        'title' => __('Institut für Anatomie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.anatomie.med.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311140000' => [
        'title' => __('Institut für Biochemie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.biochemie.med.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311360000' => [
        'title' => __('Institut für Biomedizin des Alterns', 'fau-orga-breadcrumb'),
        'url' => __('https://www.iba.med.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311340000' => [
        'title' => __('Institut für Experimentelle und Klinische Pharmakologie und Toxikologie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.pharmakologie.med.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311320000' => [
        'title' => __('Institut für Geschichte und Ethik der Medizin', 'fau-orga-breadcrumb'),
        'url' => __('https://www.igem.med.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],

    '1311390000' => [
        'title' => __('Institut für Lehre und Forschung am Medizincampus Oberfranken', 'fau-orga-breadcrumb'),
        'url' => __('https://www.med.fau.de/fakultaet/einrichtungen/medizincampus-oberfranken/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311310000' => [
        'title' => __('Institut für Medizininformatik, Biometrie und Epidemiologie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.imbe.med.uni-erlangen.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311120000' => [
        'title' => __('Institut für Physiologie und Pathophysiologie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.physiologie1.uni-erlangen.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311350000' => [
        'title' => __('Institut und Poliklinik für Arbeits-, Sozial- und Umweltmedizin', 'fau-orga-breadcrumb'),
        'url' => __('https://www.ipasum.med.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311330000' => [
        'title' => __('Institut für Rechtsmedizin', 'fau-orga-breadcrumb'),
        'url' => __('https://www.recht.med.uni-erlangen.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311130000' => [
        'title' => __('Institut für Zelluläre und Molekulare Physiologie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.physiologie2.med.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],
    '1311370000' => [
        'title' => __('Klinisch-Molekularbiologisches Forschungszentrum', 'fau-orga-breadcrumb'),
        'url' => __('http://www.molmed.uni-erlangen.de/', 'fau-orga-breadcrumb'),
        'parent' => '1300000000',
    ],

    // === NATURWISSENSCHAFTLICHE FAKULTÄT ===
    '1400000000' => [
        'title' => __('Naturwissenschaftliche Fakultät', 'fau-orga-breadcrumb'),
        'url' => __('https://www.nat.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'fakultaeten',
        'class' => 'nat',
        'faculty' => 'nat'
    ],
    '1411000000' => [
        'title' => __('Department Biologie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.biologie.nat.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1400000000',
    ],
    '1412000000' => [
        'title' => __('Department Chemie und Pharmazie', 'fau-orga-breadcrumb'),
        'url' => __('https://www.chemie.nat.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1400000000',
    ],
    '1416000000' => [
        'title' => __('Department of Data Science', 'fau-orga-breadcrumb'),
        'url' => __('https://www.datascience.nat.fau.eu/', 'fau-orga-breadcrumb'),
        'parent' => '1400000000',
    ],
    '1413000000' => [
        'title' => __('Department Geographie und Geowissenschaften', 'fau-orga-breadcrumb'),
        'url' => __('https://www.geo.nat.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1400000000',
    ],
    '1414000000' => [
        'title' => __('Department Mathematik', 'fau-orga-breadcrumb'),
        'url' => __('https://www.math.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1400000000',
    ],
    '1415000000' => [
        'title' => __('Department Physik', 'fau-orga-breadcrumb'),
        'url' => __('https://www.physik.nat.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1400000000',
    ],

    // === TECHNISCHE FAKULTÄT ===
    '1500000000' => [
        'title' => __('Technische Fakultät', 'fau-orga-breadcrumb'),
        'url' => __('https://www.tf.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'fakultaeten',
        'class' => 'tf',
        'faculty' => 'tf'
    ],
    '1518000000' => [
        'title' => __('Department Artificial Intelligence in Biomedical Engineering', 'fau-orga-breadcrumb'),
        'url' => __('https://www.aibe.tf.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1500000000',
    ],
    '1511000000' => [
        'title' => __('Department Chemie- und Bioingenieurwesen', 'fau-orga-breadcrumb'),
        'url' => __('https://www.cbi.tf.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1500000000',
    ],
    '1512000000' => [
        'title' => __('Department Elektrotechnik-Elektronik-Informationstechnik', 'fau-orga-breadcrumb'),
        'url' => __('https://www.eei.tf.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1500000000',
    ],
    '1513000000' => [
        'title' => __('Department Informatik', 'fau-orga-breadcrumb'),
        'url' => __('https://cs.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1500000000',
    ],
    '1514000000' => [
        'title' => __('Department Maschinenbau', 'fau-orga-breadcrumb'),
        'url' => __('https://www.department.mb.tf.fau.de/', 'fau-orga-breadcrumb'),
        'parent' => '1500000000',
    ],
    '1515000000' => [
        'title' => __('Department Werkstoffwissenschaften', 'fau-orga-breadcrumb'),
        'url' => __('https://www.ww.tf.fau.de', 'fau-orga-breadcrumb'),
        'parent' => '1500000000',
    ],

    // === ZENTRALE EINRICHTUNGEN ===
    'zentrale_einrichtungen' => [
        'title' => __('Zentrale Einrichtungen', 'fau-orga-breadcrumb'),
        'url' => '',
        'parent' => null,
    ],
    '1011200000' => [
        'title' => __('Graduiertenzentrum der FAU', 'fau-orga-breadcrumb'),
        'url' => __('https://www.fau.de/graduiertenzentrum/', 'fau-orga-breadcrumb'),
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011120000' => [
        'title' => __('Regionales Rechenzentrum Erlangen', 'fau-orga-breadcrumb'),
        'url' => __('https://www.rrze.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011400000' => [
        'title' => __('Sprachenzentrum', 'fau-orga-breadcrumb'),
        'url' => __('https://sz.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011110000' => [
        'title' => __('Universitätsbibliothek', 'fau-orga-breadcrumb'),
        'url' => __('https://ub.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011190000' => [
        'title' => __('Zentrum für Lehrerinnen- und Lehrerbildung', 'fau-orga-breadcrumb'),
        'url' => __('https://www.zfl.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011140000' => [
        'title' => __('Bayerisch-Kalifornisches Hochschulzentrum', 'fau-orga-breadcrumb'),
        'url' => __('https://ub.fau.de', 'fau-orga-breadcrumb'),
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011430000' => [
        'title' => __('Bayerisches Hochschulzentrum für Lateinamerika', 'fau-orga-breadcrumb'),
        'url' => __('https://www.bacatec.de/de/', 'fau-orga-breadcrumb'),
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011300000' => [
        'title' => __('Zentrum für Nationales Hochleistungsrechnen Erlangen', 'fau-orga-breadcrumb'),
        'url' => 'https://hpc.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],

    // === PROFILZENTREN ===
    'profilzentren' => [
        'title' => __('Profilzentren', 'fau-orga-breadcrumb'),
        'url' => '',
        'parent' => null,
    ],
    '1011311500' => [
        'title' => __('Immunmedizin (FAU I-MED)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.immunology.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311400' => [
        'title' => __('Licht.Materia.Quantentechnologien (FAU LMQ)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.lightmatter.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311200' => [
        'title' => __('Medizintechnik (FAU MT)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.medicalengineering.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311100' => [
        'title' => __('Neue Materialien und Prozesse (FAU NMP)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.newmaterials.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311300' => [
        'title' => __('Solar (FAU Solar)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.solar.fau.de',
        'parent' => 'profilzentren',
    ],

    // === FORSCHUNGSZENTREN ===
    'forschungszentren' => [
        'title' => __('Forschungszentren', 'fau-orga-breadcrumb'),
        'url' => '',
        'parent' => null,
    ],
    '1011321400' => [
        'title' => __('Center for Human Rights Erlangen-Nürnberg (FAU CHREN)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.humanrights.fau.de',
        'parent' => 'forschungszentren',
    ],
    '1011321200' => [
        'title' => __('Embedded Systems Initiative (FAU ESI)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.esi.fau.de',
        'parent' => 'forschungszentren',
    ],
    '1011321500' => [
        'title' => __('Islam und Recht in Europa (FAU EZIRE)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.ezire.fau.de',
        'parent' => 'forschungszentren',
    ],
    '1011321100' => [
        'title' => __('Mathematics of Data (FAU MoD)', 'fau-orga-breadcrumb'),
        'url' => 'https://mod.fau.eu',
        'parent' => 'forschungszentren',
    ],
    '1011321300' => [
        'title' => __('Neue Wirkstoffe (FAU NeW)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.new.fau.eu',
        'parent' => 'forschungszentren',
    ],

    // === KOMPETENZZENTREN ===
    'kompetenzzentren' => [
        'title' => __('Kompetenzzentren', 'fau-orga-breadcrumb'),
        'url' => '',
        'parent' => null,
    ],
    '1011331300' => [
        'title' => __('Engineering of Advanced Materials (FAU EAM)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.eam.fau.eu',
        'parent' => 'kompetenzzentren',
    ],
    '1011331500' => [
        'title' => __('Interdisziplinäre Wissenschaftsreflexion (FAU ZIWIS)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.ziwis.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331600' => [
        'title' => __('Lehre (FAU Lehre)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.lehre.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331400' => [
        'title' => __('Optical Imaging Compentence Center (FAU OICE)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.oice.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331100' => [
        'title' => __('Research Data and Information (FAU CDI)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.cdi.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331200' => [
        'title' => __('Scientific Computing (FAU CSC)', 'fau-orga-breadcrumb'),
        'url' => 'https://www.csc.fau.eu',
        'parent' => 'kompetenzzentren',
    ],

    // === INNOVATIONSORTE ===
    'innovationsorte' => [
        'title' => __('Innovationsorte', 'fau-orga-breadcrumb'),
        'url' => '',
        'parent' => null,
    ],
    '001' => [
        'title' => __('JOSEPHS', 'fau-orga-breadcrumb'),
        'url' => 'https://josephs-innovation.de/wp/',
        'parent' => 'innovationsorte',
    ],
    '002' => [
        'title' => __('ZOLLHOF', 'fau-orga-breadcrumb'),
        'url' => 'https://zollhof.de',
        'parent' => 'innovationsorte',
    ],
    '003' => [
        'title' => __('d.hip – Digital Health Innovation Platform', 'fau-orga-breadcrumb'),
        'url' => 'https://d-hip.de',
        'parent' => 'innovationsorte',
    ],
    '004' => [
        'title' => __('Medical Valley Center', 'fau-orga-breadcrumb'),
        'url' => 'https://www.medical-valley-emn.de',
        'parent' => 'innovationsorte',
    ],
    '005' => [
        'title' => __('FAU Innovationsökosystems', 'fau-orga-breadcrumb'),
        'url' => 'https://www.new.fau.eu',
        'parent' => 'innovationsorte',
    ],

];
