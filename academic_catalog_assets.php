<?php

$cats = array(
    '2023_2024_fall_a' => array(
        'version' => '2023_2024_fall_a',
        'publish' => 'April 28, 2023',
        'effective' => 'July 10, 2023',
        'title' => 'Fall 2023-2024',
        'header' => '2023-2024 Fall Academic Catalog'
    ),
    '2022_2023_spring_a' => array(
        'version' => '2022_2023_spring_a',
        'publish' => 'December 20, 2022',
        'effective' => 'March 13, 2023',
        'title' => 'Spring 2022-2023',
        'header' => '2022-2023 Spring Academic Catalog'
    ),
    '2022_2023_winter_a' => array(
        'version' => '2022_2023_winter_a',
        'publish' => 'September 30, 2022',
        'effective' => 'November 7, 2022',
        'title' => 'Winter 2022-2023',
        'header' => '2022-2023 Winter Academic Catalog'
    ),
    '2022_2023_fall_a' => array(
        'version' => '2022_2023_fall_a',
        'publish' => 'April 21, 2022',
        'effective' => 'July 18, 2022',
        'title' => 'Fall 2022-2023',
        'header' => '2022-2023 Fall Academic Catalog'
    ),
    '2021_2022_spring_b' => array(
        'version' => '2021_2022_spring_b',
        'publish' => 'March 28, 2022',
        'effective' => 'March 21, 2022',
        'title' => 'Spring 2021-2022',
        'header' => '2021-2022 Spring Academic Catalog'
    ),
    '2021_2022_spring_a' => array(
        'version' => '2021_2022_spring_a',
        'publish' => 'December 22, 2021',
        'effective' => 'March 21, 2022',
        'title' => 'Spring 2021-2022',
        'header' => '2021-2022 Spring Academic Catalog'
    ),
    '2021_2022_winter_b' => array(
        'version' => '2021_2022_winter_b',
        'publish' => 'December 21, 2021',
        'effective' => 'November 15, 2021',
        'title' => 'Winter 2021-2022',
        'header' => '2021-2022 Winter Academic Catalog'
    ),
    '2021_2022_winter_a' => array(
        'version' => '2021_2022_winter_a',
        'publish' => 'March 18, 2020',
        'effective' => 'November 15, 2021',
        'title' => 'Winter 2021-2022',
        'header' => '2021-2022 Winter Academic Catalog'
    ),
    '2021_2022_fall_b' => array(
        'version' => '2021_2022_fall_b',
        'publish' => 'March 18, 2020',
        'effective' => 'July 19, 2021',
        'title' => 'Fall 2021-2022',
        'header' => '2021-2022 Fall Academic Catalog'
    ),
    '2021_2022_fall_a' => array(
        'version' => '2021_2022_fall_a',
        'publish' => 'March 18, 2020',
        'effective' => 'July 19, 2021',
        'title' => 'Fall 2021-2022',
        'header' => '2021-2022 Fall Academic Catalog'
    ),
    '2020_2021_spring_b' => array(
        'version' => '2020_2021_spring_b',
        'publish' => 'March 18, 2020',
        'effective' => 'March 15, 2021',
        'title' => 'Spring 2020-2021',
        'header' => '2020-2021 Spring Academic Catalog'
    ),
    '2020_2021_spring_a' => array(
        'version' => '2020_2021_spring_a',
        'publish' => 'January 8, 2020',
        'effective' => 'March 15, 2021',
        'title' => 'Spring 2020-2021',
        'header' => '2020-2021 Spring Academic Catalog'
    ),
    '2020_2021_winter_c' => array(
        'version' => '2020_2021_winter_c',
        'publish' => 'December 7, 2020',
        'effective' => 'November 9, 2020',
        'title' => 'Winter 2020-2021',
        'header' => '2020-2021 Winter Academic Catalog'
    ),
    '2020_2021_winter_a' => array(
        'version' => '2020_2021_winter_a',
        'publish' => 'September 9, 2020',
        'effective' => 'November 9, 2020',
        'title' => 'Winter 2020-2021',
        'header' => '2020-2021 Winter Academic Catalog'
    ),
    '2020_2021_fall_b' => array(
        'version' => '2020_2021_fall_b',
        'publish' => 'June 4, 2020',
        'effective' => 'July 13, 2020',
        'title' => 'Fall 2020-2021',
        'header' => '2020-2021 Fall Academic Catalog'
    ),
    '2020_2021_fall_a' => array(
        'version' => '2020_2021_fall_a',
        'publish' => 'May 2, 2020',
        'effective' => 'July 13, 2020',
        'title' => 'Fall 2020-2021',
        'header' => '2020-2021 Fall Academic Catalog'
    ),
    '2019_2020_spring_c' => array(
        'version' => '2019_2020_spring_c',
        'publish' => 'January 16, 2020',
        'effective' => 'March 16, 2020',
        'title' => 'Spring 2019-2020',
        'header' => '2019-2020 Spring Academic Catalog'
    ),
    '2019_2020_spring_b' => array(
        'version' => '2019_2020_spring_b',
        'publish' => 'March 16, 2020',
        'effective' => 'March 16, 2020',
        'title' => 'Spring 2019-2020',
        'header' => '2019-2020 Spring Academic Catalog'
    )
);

if (isset($_GET['cat']) AND array_key_exists($_GET['cat'], $cats)) {
    // effective date
    $effective = $cats[$_GET['cat']]['effective'];
    // set current catalog
    $currentCatalog = $_GET['cat'];
    // set current title
    $curTitle = $cats[$_GET['cat']]['title'];
    // set current header
    $curHeader = $cats[$_GET['cat']]['header'];
} else {
    foreach ($cats as $k => $v) {
        if (strtotime($v['publish']) < strtotime('now')) {
            // effective date
            $effective = $v['effective'];
            // set current catalog
            $currentCatalog = $v['version'];
            // set current title
            $curTitle = $v['title'];
            // set current header
            $curHeader = $v['header'];
            break;
        }
    }
}


// get programmatic data from kuali
$json = file_get_contents('catalog_'.$currentCatalog.'.json');
$cat = json_decode($json); 

// admissions policy array
$admissionsArray = array(
    "Application Process",
    "Applicant Integrity",
    "Submitting Official Transcripts to CSU Global",
    "Technical Requirements",
    "Undergraduate Admissions",
    "Undergraduate Admissions > Undergraduate First-time Freshman Admission Requirements",
    "Undergraduate Admissions > Undergraduate Transfer Admission Requirements",
    "Undergraduate Admissions > Undergraduate Provisional Admission",
    "Undergraduate Admissions > Undergraduate Conditional Admission",
    "Undergraduate Admissions > Undergraduate International Admission",
    "Undergraduate Admissions > Undergraduate Admission Decision Appeals",
    "Undergraduate Admissions > Undergraduate Dual Enrollment",
    "Graduate Admissions",
    "Graduate Admissions > Graduate Standard Admission",
    "Graduate Admissions > Graduate Conditional Admission",
    "Graduate Admissions > Graduate Provisional Admission",
    "Graduate Admissions > Graduate International Admission",
    "Non-Degree Seeking",
    "Non-Degree Seeking > CSU Global Direct",
    "Non-Degree Seeking > Students",
    "Returning Students",
    "Returning Students > Undergraduate Students",
    "Returning Students > Graduate Students",
    "Returning Students > Re-entry Catalog Appeal",
    "Double Major",
    "Double Major > Undergraduate Students",
    "Double Major > Graduate Students",
    "CSU Global Graduation Upgrade",
    "Alumni Admissions Process",
    "Alumni Admissions Process > Second Bachelor’s Degree",
    "Alumni Admissions Process > Second Master’s Degree",
    "Appeal of Admissions Decision",
    "State-Specific Authorizations",
    "State-Specific Authorizations > NC-SARA",
    "State-Specific Authorizations > Internships and Practica",
    "State-Specific Authorizations > State Contact Information for Grievances"
);

// transfer policy array
$transferArray = array(
    "Undergraduate Transfer Information",
    "Undergraduate Transfer Information > Collegiate Credit",
    "Undergraduate Transfer Information > Acceptance of all P/S grades from Colorado Community Colleges",
    "Undergraduate Transfer Information > Time Limitation of Credit Transfer",
    "Undergraduate Transfer Information > Credit from Other CSU System Campuses",
    "Undergraduate Transfer Information > Two-Year Institutions",
    "Undergraduate Transfer Information > Associate Degree Information",
    "Undergraduate Transfer Information > Career (Vocational), Technical, Co-operative Education and Internships",
    "Undergraduate Transfer Information > Bachelor of Applied Science Degrees",
    "Undergraduate Transfer Information > Limitation of Physical Education Credit",
    "Undergraduate Transfer Information > National Accreditation",
    "Undergraduate Transfer Information > International Credit",
    "Alternative Credit Options",
    "Alternative Credit Options > CSU Global Self-Study Assessments (SSAs)",
    "Alternative Credit Options > Prior Learning Assessment (PLA)",
    "Non-Traditional Sources of Credit",
    "Non-Traditional Sources of Credit > Credit By Exams",
    "Non-Traditional Sources of Credit > Military Credit",
    "Non-Traditional Sources of Credit > Non-Collegiate Credit",
    "Non-Traditional Sources of Credit > Non-Acceptance of Credit",
    "Non-Traditional Sources of Credit > Credit Evaluation Appeals Process",
    "Graduate Transfer Information",
    "Graduate Transfer Information > Time Limitation of Credit Transfer",
    "Graduate Transfer Information > International Credit",
    "Graduate Transfer Information > Non-Acceptance of Credit",
    "Graduate Transfer Information > Credit Evaluation Appeals Process"
);

// academic policy array
$academicArray = array(
    "Catalog Requirements",
    "Unit of Credit",
    "Change of Program",
    "Institutional Degree Requirements",
    "Institutional Degree Requirements > Undergraduate Requirements",
    "Institutional Degree Requirements > Course Substitutions/Waivers",
    "Institutional Degree Requirements > Graduate Requirements",
    "Learning Outcomes",
    "Learning Outcomes > Learning Outcome Assessments"
);