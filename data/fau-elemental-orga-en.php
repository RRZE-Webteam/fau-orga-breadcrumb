<?php

namespace FAU\ORGA\Breadcrumb;

defined('ABSPATH') || exit;

/*
 * Organizational data for the FAU Elemental Theme
 */
return [
    // FAU top level
    '0000000000' => [
        'title' => 'FAU',
        'url' => 'https://www.fau.eu',
        'parent' => null,
    ],

    // Faculties container
    'fakultaeten' => [
        'title' => 'Faculties',
        'url' => '',
        'parent' => null,
    ],

    // === FACULTY OF HUMANITIES, SOCIAL SCIENCES, AND THEOLOGY ===
    '1100000000' => [
        'title' => 'Faculty of Humanities, Social Sciences, and Theology',
        'url' => 'https://www.phil.fau.eu',
        'parent' => 'fakultaeten',
        'class' => 'phil',
        'faculty' => 'phil'
    ],
    'virt_1100000000_overview' => [
        'title' => 'Faculty of Humanities, Social Sciences, and Theology',
        'url' => 'https://www.phil.fau.eu',
        'parent' => '1100000000',
    ],
    '1111000000' => [
        'title' => 'Department of Classical World and Asian Cultures',
        'url' => 'https://www.phil.fau.eu/faculty/organisation/departments/',
        'parent' => '1100000000',
    ],
    '1112000000' => [
        'title' => 'Department of English, American and Romance Studies',
        'url' => 'https://www.angam.phil.fau.de',
        'parent' => '1100000000',
    ],
    '1113000000' => [
        'title' => 'Department of Subject-specific Education Research',
        'url' => 'https://www.fachdidaktiken.phil.fau.de',
        'parent' => '1100000000',
    ],
    '1114000000' => [
        'title' => 'Department of German and Comparative Studies',
        'url' => 'https://www.germanistik.phil.fau.de/',
        'parent' => '1100000000',
    ],
    '1115000000' => [
        'title' => 'Department of History',
        'url' => 'https://www.geschichte.phil.fau.de/',
        'parent' => '1100000000',
    ],
    '1116000000' => [
        'title' => 'Department of Media Studies and Art History',
        'url' => 'https://www.phil.fau.eu/faculty/organisation/departments/',
        'parent' => '1100000000',
    ],
    '1117000000' => [
        'title' => 'Department of Education',
        'url' => 'https://www.department-paedagogik.phil.fau.eu',
        'parent' => '1100000000',
    ],
    '1118000000' => [
        'title' => 'Department of Psychology',
        'url' => 'https://www.phil.fau.eu/faculty/organisation/departments/',
        'parent' => '1100000000',
    ],
    '1119000000' => [
        'title' => 'Department of Social Sciences and Philosophy',
        'url' => 'https://www.phil.fau.eu/faculty/organisation/departments/',
        'parent' => '1100000000',
    ],
    '1120000000' => [
        'title' => 'School of Theology',
        'url' => 'https://www.theologie.fau.de',
        'parent' => '1100000000',
    ],
    '1121000000' => [
        'title' => 'Department of Islamic Religious Studies',
        'url' => 'https://www.dirs.phil.fau.eu',
        'parent' => '1100000000',
    ],
    '1122000000' => [
        'title' => 'Department of Sport Science and Sport',
        'url' => 'https://www.sport.fau.eu',
        'parent' => '1100000000',
    ],
    '1123000000' => [
        'title' => 'Department of Digital Humanities and Social Studies',
        'url' => 'https://www.dhss.phil.fau.eu',
        'parent' => '1100000000',
    ],

    // === SCHOOL OF LAW AND ECONOMICS ===
    '1200000000' => [
        'title' => 'Faculty of Business, Economics and Law',
        'url' => 'https://www.rw.fau.eu',
        'parent' => 'fakultaeten',
        'class' => 'rw',
        'faculty' => 'rw'
    ],
    'virt_1200000000_overview' => [
        'title' => 'Faculty of Business, Economics and Law',
        'url' => 'https://www.rw.fau.eu',
        'parent' => '1200000000',
    ],
    '1211000000' => [
        'title' => 'School of Law',
        'url' => 'https://www.jura.rw.fau.de',
        'parent' => '1200000000',
    ],
    '1212000000' => [
        'title' => 'School of Business, Economics and Society | WiSo ',
        'url' => 'https://www.wiso.rw.fau.eu',
        'parent' => '1200000000',
    ],

    // === FACULTY OF MEDICINE ===
    '1300000000' => [
        'title' => 'Faculty of Medicine',
        'url' => 'https://www.med.fau.eu',
        'parent' => 'fakultaeten',
        'class' => 'med',
        'faculty' => 'med'
    ],
    'virt_1300000000_overview' => [
        'title' => 'Faculty of Medicine',
        'url' => 'https://www.med.fau.eu',
        'parent' => '1300000000',
    ],
    '1311110000' => [
        'title' => 'Institute of Anatomy',
        'url' => 'https://www.anatomie.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311120000' => [
        'title' => 'Institute of Physiology and Pathophysiology',
        'url' => 'https://www.physiologie1.med.fau.de/en/',
        'parent' => '1300000000',
    ],
    '1311130000' => [
        'title' => 'Institute of Cellular and Molecular Physiology',
        'url' => 'https://www.physiologie2.med.fau.de/en/',
        'parent' => '1300000000',
    ],
    '1311140000' => [
        'title' => 'Institute of Biochemistry',
        'url' => 'https://www.biochemie.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311310000' => [
        'title' => 'Institute of Medical Informatics, Biometry and Epidemiology',
        'url' => 'https://www.imbe.med.uni-erlangen.de/',
        'parent' => '1300000000',
    ],
    '1311320000' => [
        'title' => 'Institute of the History of Medicine and Medical Ethics',
        'url' => 'https://www.igem.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311330000' => [
        'title' => 'Institute of Forensic Medicine',
        'url' => 'https://www.recht.med.uni-erlangen.de/',
        'parent' => '1300000000',
    ],
    '1311340000' => [
        'title' => 'Institute of Experimental and Clinical Pharmacology and Toxicology',
        'url' => 'https://www.pharmakologie.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311350000' => [
        'title' => 'Institute and Outpatient Clinic of Occupational, Social and Environmental Medicine',
        'url' => 'https://www.ipasum.med.fau.de/en/',
        'parent' => '1300000000',
    ],
    '1311360000' => [
        'title' => 'Institute of Biomedicine of Aging',
        'url' => 'https://www.iba.med.fau.de/',
        'parent' => '1300000000',
    ],
    '1311370000' => [
        'title' => 'Nikolaus Fiebiger Center of Molecular Medicine',
        'url' => 'https://www.med.fau.eu/faculty/institutes-departments/clinical-theoretical-institutes/#collapse_6',
        'parent' => '1300000000',
    ],
    '1311390000' => [
        'title' => 'Institute of Research and Teaching, Medizincampus Oberfranken',
        'url' => 'https://www.med.fau.de/fakultaet/einrichtungen/medizincampus-oberfranken/',
        'parent' => '1300000000',
    ],
//    '1311400000' => [
//        'title' => 'Medical Institute of Biophysics',
//        'url' => 'https://www.med.fau.de/fakultaet/einrichtungen/klinisch-theoretische-institute/#collapse_4',
//        'parent' => '1300000000',
//    ],


    // === FACULTY OF SCIENCES ===
    '1400000000' => [
        'title' => 'Faculty of Sciences',
        'url' => 'https://www.nat.fau.eu',
        'parent' => 'fakultaeten',
        'class' => 'nat',
        'faculty' => 'nat'
    ],
    'virt_1400000000_overview' => [
        'title' => 'Faculty of Sciences',
        'url' => 'https://www.nat.fau.eu',
        'parent' => '1400000000',
    ],
    '1411000000' => [
        'title' => 'Department of Biology',
        'url' => 'https://www.biology.nat.fau.eu',
        'parent' => '1400000000',
    ],
    '1412000000' => [
        'title' => 'Department of Chemistry and Pharmacy',
        'url' => 'https://www.chemistry.nat.fau.eu',
        'parent' => '1400000000',
    ],
    '1413000000' => [
        'title' => 'Department of Geography and Geosciences',
        'url' => 'https://www.geo.nat.fau.de/',
        'parent' => '1400000000',
    ],
    '1414000000' => [
        'title' => 'Department of Mathematics',
        'url' => 'https://en.www.math.fau.de',
        'parent' => '1400000000',
    ],
    '1415000000' => [
        'title' => 'Department of Physics',
        'url' => 'https://www.physics.nat.fau.eu',
        'parent' => '1400000000',
    ],
    '1416000000' => [
        'title' => 'Department of Data Science',
        'url' => 'https://www.datascience.nat.fau.eu/',
        'parent' => '1400000000',
    ],

    // === FACULTY OF ENGINEERING ===
    '1500000000' => [
        'title' => 'Faculty of Engineering',
        'url' => 'https://www.tf.fau.eu',
        'parent' => 'fakultaeten',
        'class' => 'tf',
        'faculty' => 'tf'
    ],
    'virt_1500000000_overview' => [
        'title' => 'Faculty of Engineering',
        'url' => 'https://www.tf.fau.eu',
        'parent' => '1500000000',
    ],
    '1518000000' => [
        'title' => 'Department of Artificial Intelligence in Biomedical Engineering',
        'url' => 'https://www.aibe.tf.fau.de/',
        'parent' => '1500000000',
    ],
    '1511000000' => [
        'title' => 'Department of Chemical and Biological Engineering',
        'url' => 'https://www.cbi.tf.fau.eu',
        'parent' => '1500000000',
    ],
    '1512000000' => [
        'title' => 'Department of Electrical, Electronic and Communication Engineering',
        'url' => 'https://www.eei.tf.fau.de/',
        'parent' => '1500000000',
    ],
    '1513000000' => [
        'title' => 'Department of Computer Science',
        'url' => 'https://cs.fau.de/',
        'parent' => '1500000000',
    ],
    '1514000000' => [
        'title' => 'Department of Mechanical Engineering',
        'url' => 'https://www.department.mb.tf.fau.de/',
        'parent' => '1500000000',
    ],
    '1515000000' => [
        'title' => 'Department of Materials Science',
        'url' => 'https://www.ww.tf.fau.eu',
        'parent' => '1500000000',
    ],


    // === CENTRAL FACILITIES (menu section) ===
    'zentrale_einrichtungen' => [
        'title' => 'Central Institutions',
        'url' => '',
        'parent' => null,
    ],
    '1011110000' => [
        'title' => 'University Library',
        'url' => 'https://ub.fau.de/en/',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011120000' => [
        'title' => 'Regional Computer Center Erlangen (RRZE)',
        'url' => 'https://www.rrze.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011140000' => [
        'title' => 'Bavaria California Technology Center (BaCaTeC)',
        'url' => 'https://www.bacatec.de/en/',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011180000' => [
        'title' => 'Language Center',
        'url' => 'https://sz.fau.eu',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011190000' => [
        'title' => 'Center for Teacher Education',
        'url' => 'https://www.zfl.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011200000' => [
        'title' => 'Graduate Center',
        'url' => 'https://www.fau.eu/graduate-centre/',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011430000' => [
        'title' => 'Bavarian University Center for Latin America (BAYLAT)',
        'url' => 'https://www.baylat.org',
        'parent' => 'zentrale_einrichtungen',
    ],
    '1011300000' => [
        'title' => 'Erlangen National High-Performance Computing Center (NHR)',
        'url' => 'https://hpc.fau.de',
        'parent' => 'zentrale_einrichtungen',
    ],

    // === PROFILE CENTERS ===
    'profilzentren' => [
        'title' => 'Profile Centers',
        'url' => '',
        'parent' => null,
    ],
    '1011311100' => [
        'title' => 'New Materials and Processes (FAU NMP)',
        'url' => 'https://www.newmaterials.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311200' => [
        'title' => 'Medical Engineering (FAU MT)',
        'url' => 'https://www.medicalengineering.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311300' => [
        'title' => 'Solar (FAU Solar)',
        'url' => 'https://www.solar.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311400' => [
        'title' => 'Light.Matter.Quantum Technologies (FAU LMQ)',
        'url' => 'https://www.lightmatter.fau.de',
        'parent' => 'profilzentren',
    ],
    '1011311500' => [
        'title' => 'Immunomedicine (FAU I-MED)',
        'url' => 'https://www.immunology.fau.de',
        'parent' => 'profilzentren',
    ],


    // === RESEARCH CENTERS ===
    'forschungszentren' => [
        'title' => 'Research Centers',
        'url' => '',
        'parent' => null,
    ],
    '1011321100' => [
        'title' => 'Mathematics of Data (FAU MoD)',
        'url' => 'https://mod.fau.eu',
        'parent' => 'forschungszentren',
    ],
    '1011321200' => [
        'title' => 'Embedded Systems Initiative (FAU ESI)',
        'url' => 'https://www.esi.fau.de/en/',
        'parent' => 'forschungszentren',
    ],
    '1011321300' => [
        'title' => 'New Bioactive Compounds (FAU NeW)',
        'url' => 'https://www.new.fau.eu',
        'parent' => 'forschungszentren',
    ],
    '1011321400' => [
        'title' => 'Human Rights Erlangen-Nuremberg (FAU CHREN)',
        'url' => 'https://www.humanrights.fau.eu',
        'parent' => 'forschungszentren',
    ],
    '1011321500' => [
        'title' => 'Islam and Law in Europe (FAU EZIRE)',
        'url' => 'https://www.ezire.fau.eu',
        'parent' => 'forschungszentren',
    ],



    // === COMPETENCE CENTERS ===
    'kompetenzzentren' => [
        'title' => 'Competence Centers',
        'url' => '',
        'parent' => null,
    ],
    '1011331100' => [
        'title' => 'Research Data and Information (FAU CDI)',
        'url' => 'https://www.cdi.fau.de/en/',
        'parent' => 'kompetenzzentren',
    ],
    '1011331200' => [
        'title' => 'Scientific Computing (FAU CSC)',
        'url' => 'https://www.csc.fau.eu',
        'parent' => 'kompetenzzentren',
    ],
    '1011331300' => [
        'title' => 'Engineering of Advanced Materials (FAU EAM)',
        'url' => 'https://www.eam.fau.eu',
        'parent' => 'kompetenzzentren',
    ],
    '1011331400' => [
        'title' => 'Optical Imaging Competence Center (FAU OICE)',
        'url' => 'https://www.oice.fau.de',
        'parent' => 'kompetenzzentren',
    ],
    '1011331500' => [
        'title' => 'Applied Philosophy of Science and Key Qualifications (FAU ZIWIS)',
        'url' => 'https://www.ziwis.fau.eu',
        'parent' => 'kompetenzzentren',
    ],
    '1011331600' => [
        'title' => 'Eduction (FAU Education)',
        'url' => 'https://www.lehre.fau.de/en/',
        'parent' => 'kompetenzzentren',
    ],




    // === INNOVATION LOCATIONS ===
    'innovationsorte' => [
        'title' => 'Innovation Locations',
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
        'url' => 'https://www.medical-valley-emn.de/en/',
        'parent' => 'innovationsorte',
    ],
    '005' => [
        'title' => 'FAU Innovation Ecosystem',
        'url' => 'https://www.new.fau.eu',
        'parent' => 'innovationsorte',
    ],

];