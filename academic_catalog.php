<?php
error_reporting(E_ALL);
ini_set('display_errors', 'Off');

if ($_GET['debug'] == '1234') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('memory_limit','512M');
}

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');
require_once('academic_catalog_assets.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // //Page header
    // public function Header() {
    //     // Logo
    //     $image_file = K_PATH_IMAGES.'logo_example.jpg';
    //     $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    //     // Set font
    //     $this->SetFont('helvetica', 'B', 20);
    //     // Title
    //     $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    // }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', '', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// default styles
$css_styles = '<style>
h1 {color:#aa1d40; font-size:48px; font-weight:bold;}
h2 {color:#d28f40; font-size:28px; font-weight:bold;}
h3 {color:#aa1d40; font-size:22px; font-weight:bold;}
h4 {color:#aa1d40; font-size:16px; font-weight:normal;}
h5 {color:#333333; font-size:14px; font-weight:bold;}
h6 {color:#aa1d40; font-size:14px; font-weight:bold; line-height:5px;}
p, li {color:#333333;}
p.quote {color:#999999; font-size:22px; font-style:italic;}
a {color:#17a0b0}
th {font-style:bold;}
</style>';

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Colorado State University Global');
$pdf->SetTitle('Academic Catalog');
$pdf->SetSubject('CSU Global Academic Catalog');
$pdf->SetKeywords('academic, catalog, programs, degrees, courses, bacholor, master, undergraduate, graduate, certificate, university');

// set default header data
$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, $curHeader, '', array(210,143,65), array(200,200,200));
$pdf->SetFooterData(array(51,51,51), array(200,200,200));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 25, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(8);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// set font
$pdf->SetFont('helvetica', '', 11);

// --------------------------------------------------------- cover page

// don't print header on this page
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->Image('imgs/catalog/'.$currentCatalog.'/cover_front.jpg', 0, 0, 216, '', 'JPG', '', '', false, 72, '', false, false, 0, false, false, false);
// $pdf->Rect(0, 172, 216, 2, 'F', array(), array(211,142,64));
$pdf->setY(182, true, false);
$html = '<style>
h1 {color:#aa1d40; font-size:56px; line-height:32px;}
h2 {color:#1c2333; font-size:36px; font-weigh:300; line-height:20px;}
h3 {color:#aa1d40;}
p {color:#666666;}
</style>
<h3>Colorado State University Global</h3>
<h1>Academic Catalog</h1>
<h2>'.$curTitle.'</h2>
<p>University policies, degree programs, and course descriptions<br />for undergraduate and graduate students.</p>
<p>The first independent, regionally accredited, 100% online state<br />university in the country.</p>
<h3>800-920-6723 | CSUGlobal.edu</h3>';
$pdf->writeHTML($html, true, false, false, false, '');

// --------------------------------------------------------- disclaimer page

$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->SetPrintHeader(true);
$pdf->AddPage();
$pdf->SetPrintFooter(true);
$html = $css_styles.'
<p>The Colorado State University Global Campus (CSU Global) Academic Catalog is the official source for academic program information. CSU Global reserves the right to make changes to the catalog in order to fulfill its mission or to accommodate administrative needs in a timely fashion. In the event that such a change is made during the course of a trimester, the catalog will be republished with the alteration clearly indicated. The university will work closely with students to minimize impact should any such change affect their degree progress. For a complete list of student policies, please visit <a href="https://csuglobal.edu/policies">csuglobal.edu/policies</a>.</p>
<p>&nbsp;</p>
<p>Effective Date: '.$effective.'</p>';
$pdf->writeHTML($html, true, false, false, false, '');

// --------------------------------------------------------- welcome letter

$pdf->AddPage();
$pdf->Bookmark('Welcome to CSU Global', 0, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Welcome to CSU Global</h2>
<img src="imgs/catalog/becky_headshot.jpg" alt="Becky Takeda-Tinker" />
<p>Dear Students,</p>
<p> Thank you for choosing CSU Global to help you achieve your educational goals for a brighter future.
Our mission at CSU Global is to advance student academic and professional success in a global society by providing access to dynamic education characterized by excellence, innovative delivery technologies, industry relevance, and strong stakeholder engagement.</p>
<p>We are committed to your career success and preparing you for the workforce through dedicated student success counselors, 24/7 support resources, our Career Center and its dedicated career professionals, engaged staff and faculty, and a curriculum focused on in-demand industry skills. As the nation’s first 100% online, fully accredited state university, CSU Global is a trailblazer in meeting the needs of nontraditional learners with high-quality online programs and services. We are honored to support your academic journey and welcome you to our community.</p>
<p>Our carefully selected degree programs, specializations, and certificates are designed to ensure you gain the knowledge and skills employers are looking for and that are necessary for you to excel in a changing marketplace. All our faculty members hold top academic credentials and are experts in their field, leveraging recent industry experience and real-world scenarios in the classroom to benefit our students.</p>
<p>We understand that CSU Global students are balancing other life responsibilities while managing classes. Our asynchronous structure, monthly start dates, and accelerated eight-week courses allow for maximum flexibility to work with your schedule and accommodate unforeseen circumstances. In addition, our affordable tuition rates, coupled with opportunities for customized pathways and transfer credits, help reduce your costs and time to completion.</p>
<p>As a nonprofit institution part of the renowned Colorado State University System, CSU Global provides:</p>
<ul>
	<li>24/7 student-centered support, including free tutoring, tech support, extensive library resources, writing center, and career navigation resources.</li>
	<li>Tuition Guarantee, which ensures your tuition will not increase as long as you are an active student; this, along with no student fees and personalized tuition planning, means you can budget successfully for your degree.</li>
	<li>Student scholarships opportunities every trimester, with no limit to the number of scholarships students can receive.</li>
</ul>
<p>We are proud to have you in the CSU Global community and look forward to helping you reach your academic and professional goals.</p>
<p>Sincerely,</p>
<p>Dr. Becky Takeda-Tinker<br />
CSU Global President</p>
<img src="imgs/catalog/becky_signature.jpg" alt="Signature" />';
$pdf->writeHTML($html, true, false, false, false, '');

// --------------------------------------------------------- degree programs image

// $pdf->AddPage();
// $pdf->Bookmark('Degree Programs', 1, 0, '', '', array(51,51,51));
// // get the current page break margin
// $bMargin = $pdf->getBreakMargin();
// // get current auto-page-break mode
// $auto_page_break = $pdf->getAutoPageBreak();
// // disable auto-page-break
// $pdf->SetAutoPageBreak(false, 0);
// // set bacground image
// $pdf->Image('imgs/catalog/'.$currentCatalog.'/degree_programs.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
// // restore auto-page-break status
// $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// // set the starting point for the page content
// $pdf->setPageMark();

// --------------------------------------------------------- accreditation

$pdf->SetPrintHeader(true);
$pdf->AddPage();
$pdf->SetPrintFooter(true);
$pdf->Bookmark('Accreditation', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h3>Accreditation</h3>
<p>Colorado State University Global Campus is regionally accredited by The Higher Learning Commission (HLC).</p>
<p>230 South LaSalle Street, Suite 7-500<br />
Chicago, Illinois 60604<br />
Phone: (800) 621-7440; (312) 263-0456;<br />
Fax: (312) 263-7462</p>
<p>Prior to receiving independent regional accreditation on June 30, 2011, CSU Global operated under extended accreditation from the Colorado State University System campuses of CSU in Fort Collins (graduate degrees) and CSU-Pueblo (undergraduate degrees). Admitted students starting a degree program prior to September 2011 were offered the option to continue their studies under an extended regional accreditation from CSU System campuses. The following indicator noted on the front of the transcript will identify students enrolled under extended accreditation:</p>
<ul>
	<li>Colorado State University-Pueblo online baccalaureate degree completion program offered through CSU Global.</li>
	<li>Colorado State University online master’s degree program offered through CSU Global.</li>
</ul>
<p>All other students pursue a program of study under CSU Global\'s independent regional accreditation. For questions about transferability, or for further information about the accreditation process, visit the Higher Learning Commission website (<a href="https://www.hlcommission.org" target="_blank">https://www.hlcommission.org</a>).</p>
<p>Select programs from the School of Management and Innovation are also accredited by The Accreditation Council for Business Schools and Programs (ACBSP). These programs include the B.S. in Accounting, B.S. in Business Management, B.S. in Human Resource Management, B.S. in Management Information Systems and Business Analytics, B.S. in Marketing, Master of Finance, Master of Human Resource Management, Master of Professional Accounting, M.S. in International Management, and M.S. in Management. More information about ACBSP accreditation can be found at <a href="http://www.acbsp.org" target="_blank">http://www.acbsp.org</a>.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- accreditation

$pdf->Bookmark('History of Colorado State University Global', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h3>History of Colorado State University Global</h3>
<p>Colorado State University Global is the newest institution in the Colorado State University System (CSUS), an established university system with a rich 140-year history that evolved from agrarian roots as a land-grant institution. CSU Global was established on August 24, 2007, by the CSUS Board of  Governors with a central goal of meeting the educational needs of adult learners in the State of Colorado and beyond by providing high quality online programs. On May 7, 2008, the CSUS Board of Governors delegated authority to CSU Global to oversee academic, personnel, and financial matters consistent with powers granted to CSU and CSU-Pueblo. Thereafter, CSU Global was legally sanctioned as a third, independent university on March 18, 2009, when Colorado\'s Governor Ritter signed into law the State of Colorado Senate Bill 09-086 declaring the establishment of CSU Global as an online university that is part of the Colorado State University System.</p>
<p>CSU Global is the first statutorily-defined 100% online public university in the United States. It has a unique focus on the success of adult, non-traditional learners with learning outcomes focused on theory, knowledge, and skills necessary to secure employment and improve job performance. From its first class of nearly 200 students in 2008, CSU Global has now grown to have a student body of over 10,000 students with more than 500 new enrollments admitted each term.</p>
<p>On June 30, 2011, Colorado State University Global Campus was officially granted independent regional accreditation status by the Higher Learning Commission (HLC) of the North Central Association of
Colleges and Schools. CSU Global is the first public university in Colorado to receive initial HLC accreditation since 1971, a significant achievement for the university, the CSU System, and online education.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- mission, vision, and values

$pdf->Bookmark('Mission, Vision, and Values', 1, 0, '', '', array(51,51,51));
$pdf->Bookmark('Mission Statement', 2, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h3>Mission, Vision, and Values</h3>
<h4>Mission Statement</h4>
<p>Colorado State University Global is committed to advancing student academic and professional success in a global society, by providing access to dynamic education characterized by excellence, innovative delivery technologies, industry relevance, and strong stakeholder engagement.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- Vision Statement

$pdf->Bookmark('Vision Statement', 2, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h4>Vision Statement</h4>
<p>CSU Global develops professionals for the workforce of the future.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- University Values

$pdf->Bookmark('University Values', 2, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h4>University Values</h4>
<p><strong>We continue to thrive and drive our mission forward because we are: </p>
<p><strong>Entrepreneurial</strong> - We continually learn, seek opportunities for growth, and believe we can do better with effort and persistence.</p>
<p><strong>Dedicated</strong> - We provide exceptional service and support to our stakeholders to drive the mission of the university. </p>
<p><strong>Tenacious</strong> - We are accountable for getting the job done right, acting thoughtfully and taking responsibility for our commitments and actions, and we thrive on achieving results.</p>
<p><strong>Agile</strong> - We are flexible in our thinking, focus on solutions, innovative problem-solving, and overcoming obstacles. </p>
<p><strong>Engaged</strong> - We collaborate, communicate, and motivate one another to achieve excellence.</p>
<p><strong>Champions of Integrity</strong> - We act ethically, honestly, and respectfully to be trustworthy and reliable towards all stakeholders.</p>-
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- commitment to diversity

$pdf->Bookmark('Commitment to Diversity', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h3>Commitment to Diversity</h3>
<p>CSU Global is committed to providing, and has a fundamental responsibility to provide, equal educational opportunities to all individuals with the courage, desire, and dedication to pursue an education and fulfill their aspirations and dreams in a democratic and pluralistic society. CSU Global strives to educate future leaders who will represent diverse perspectives as well as broad cultural experiences.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- equal employment opportunity

$pdf->Bookmark('Equal Employment Opportunity', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h3>Equal Employment Opportunity</h3>
<p>Colorado State University System is an equal opportunity/affirmative action employer and complies with all Federal and Colorado State laws, regulations, and executive orders regarding affirmative action requirements. In order to assist the CSU System in meeting its affirmative action responsibilities, ethnic minorities, women, and other protected class members are encouraged to apply and identify themselves.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- nondiscrimination policy

$pdf->Bookmark('Nondiscrimination Policy', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h3>Nondiscrimination Policy</h3>
<p>CSU Global does not discriminate on the basis of race, age, color, religion, national origin, gender, disability, sexual orientation, veteran status, or disability. CSU Global complies with the Civil Rights Act  of 1964, related Executive Orders 11246 and 11375, Title IX of the Education Amendments Act of 1972, Sections 503 and 504 of the Rehabilitation Act of 1973, Section 402 of the Vietnam Era Veteran’s Readjustment Act of 1974, the Age Discrimination in Employment Act of 1967 as amended, the Americans with Disabilities Act of 1990, the Civil Rights Act of 1991, and all civil rights laws of the state of Colorado. Accordingly, equal opportunity for admission shall be extended to all persons, and CSU Global shall promote equal opportunity and treatment through a positive and continuing affirmative action  program. In order to assist CSU Global in meeting its affirmative action responsibilities, ethnic  minorities, women, and other protected class members are encouraged to apply and to identify themselves.</p>
<p>Admission of students as well as availability and access to CSU Global programs and activities are made in accordance with policies of nondiscrimination.</p>
<p>Any CSU Global student who encounters acts of discrimination because of age, race, religion, color, gender, sexual orientation, national origin, veteran status, or disability, either on or off campus, is urged to report such an incident to the Office of Student Success. Any person who wishes to discuss a possible discriminatory act without filling out a complaint form is welcome to do so.</p>
<p>Any of the above discriminatory acts can also be the subject of complaints to the Department of Education, Office for Civil Rights, as well as to the Office of Federal Contract Compliance Programs, Equal Employment Opportunity Commission, and the Colorado Civil Rights Division.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- burgundy track past

$pdf->AddPage();
$pdf->Bookmark('Burgundy Track 2021-2022', 1, 0, '', '', array(51,51,51));
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->Image('imgs/catalog/'.$currentCatalog.'/calendar_burgundy_track_1.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

// --------------------------------------------------------- gold track past

$pdf->AddPage();
$pdf->Bookmark('Gold Track 2021-2022', 1, 0, '', '', array(51,51,51));
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->Image('imgs/catalog/'.$currentCatalog.'/calendar_gold_track_1.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

// --------------------------------------------------------- burgundy track future

$pdf->AddPage();
$pdf->Bookmark('Burgundy Track 2022-2023', 1, 0, '', '', array(51,51,51));
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->Image('imgs/catalog/'.$currentCatalog.'/calendar_burgundy_track_2.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

// --------------------------------------------------------- gold track future

$pdf->AddPage();
$pdf->Bookmark('Gold Track 2022-2023', 1, 0, '', '', array(51,51,51));
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->Image('imgs/catalog/'.$currentCatalog.'/calendar_gold_track_2.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();


















// --------------------------------------------------------- admissions policies

$pdf->AddPage();
$pdf->setY(80, true, false);
$html = $css_styles.'
<h1>Admissions<br />Policies</h1>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
// $params = $pdf->serializeTCPDFtagParameters(array(0, 184, 210, 2, 'F', array(), array(211,142,64)));
// $html .= '<tcpdf method="Rect" params="'.$params.'" />';
$pdf->Rect(16, 120, 20, 2, 'F', array(), array(23,160,176));
$html = $css_styles.'
<p>&nbsp;</p>
<p class="quote">CSU Global allowed me to fit classwork into my already busy schedule. I attribute my success in this program to the flexibility that has been provided. Even though all of the classes are online you truly do still have a connection with professors and other students.</p>
<p class="quote">&mdash;Gina Nogare, M.S. in Organizational Leadership Alumnus</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell(150, '', 16, '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- admissions policies

$pdf->AddPage();
$pdf->Bookmark('Admissions Policies', 0, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Admissions Policies</h2>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach ($admissionsArray as $v) {
    if (strpos($v, '>') === false) {
        $pdf->Bookmark($v, 1, 0, '', '', array(51,51,51));
        $html = $css_styles.
        $cat->policies->{$v}.'
        <p>&nbsp;</p>';
        $pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
    } else {
        list($parent,$child) = explode(' > ', $v);
        $pdf->Bookmark($child, 2, 0, '', '', array(51,51,51));
        $html = $css_styles.
        $cat->policies->{$v}.'
        <p>&nbsp;</p>';
        $pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
    }
}


















// --------------------------------------------------------- transfer policies

$pdf->AddPage();
$pdf->setY(80, true, false);
$html = $css_styles.'
<h1>Transfer<br />Credit Policies</h1>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
$pdf->Rect(16, 120, 20, 2, 'F', array(), array(23,160,176));
$html = $css_styles.'
<p>&nbsp;</p>
<p class="quote">My student experience here has been unforgettable. The teachers have been willing to work with me through all of my struggles. My advisors have been responsive and outstanding in answering any and all of my questions.</p>
<p class="quote">&mdash;Maryann Roth, M.S. in Management Student</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell(150, '', 16, '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- admissions policies

$pdf->AddPage();
$pdf->Bookmark('Transfer Credit Policies', 0, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Transfer Credit Policies</h2>
<p>Credit will be reviewed for transfer to CSU Global upon submission of official transcripts.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach ($transferArray as $v) {
    if (strpos($v, '>') === false) {
        $pdf->Bookmark($v, 1, 0, '', '', array(51,51,51));
        $html = $css_styles.
        $cat->policies->{$v}.'
        <p>&nbsp;</p>';
        $pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
    } else {
        list($parent,$child) = explode(' > ', $v);
        $pdf->Bookmark($child, 2, 0, '', '', array(51,51,51));
        $html = $css_styles.
        $cat->policies->{$v}.'
        <p>&nbsp;</p>';
        $pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
    }
}














// --------------------------------------------------------- academic policies

$pdf->AddPage();
$pdf->setY(80, true, false);
$html = $css_styles.'
<h1>Academic<br />Policies</h1>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
$pdf->Rect(16, 120, 20, 2, 'F', array(), array(23,160,176));
$html = $css_styles.'
<p>&nbsp;</p>
<p class="quote">I enjoy being part of the learning and knowing that I am not alone in my journey. The discussion boards are great and I enjoy meeting other students and reading their stories.</p>
<p class="quote">&mdash;Fred Vigil, B.S. in Project Management Student</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell(150, '', 16, '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- academic policies

$pdf->AddPage();
$pdf->Bookmark('Academic Policies', 0, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Academic Policies</h2>
<p>Students are advised to become familiar with the academic policies of CSU Global. Each student owns the responsibility to comply with these policies.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach ($academicArray as $v) {
    if (strpos($v, '>') === false) {
        $pdf->Bookmark($v, 1, 0, '', '', array(51,51,51));
        $html = $css_styles.
        $cat->policies->{$v}.'
        <p>&nbsp;</p>';
        $pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
    } else {
        list($parent,$child) = explode(' > ', $v);
        $pdf->Bookmark($child, 2, 0, '', '', array(51,51,51));
        $html = $css_styles.
        $cat->policies->{$v}.'
        <p>&nbsp;</p>';
        $pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
    }
    // if ($v == 'Institutional Degree Requirements > Course Substitutions/Waivers') {
    //     $pdf->AddPage();
    //     $bMargin = $pdf->getBreakMargin();
    //     $auto_page_break = $pdf->getAutoPageBreak();
    //     $pdf->SetAutoPageBreak(false, 0);
    //     $pdf->Image('imgs/catalog/'.$currentCatalog.'/successready_01.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
    //     $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
    //     $pdf->setPageMark();
        
    //     $pdf->AddPage();
    //     $bMargin = $pdf->getBreakMargin();
    //     $auto_page_break = $pdf->getAutoPageBreak();
    //     $pdf->SetAutoPageBreak(false, 0);
    //     $pdf->Image('imgs/catalog/'.$currentCatalog.'/successready_02.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
    //     $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
    //     $pdf->setPageMark();

    //     $pdf->AddPage();
    // }
}

















// --------------------------------------------------------- academic programs

$pdf->AddPage();
$pdf->setY(80, true, false);
$html = $css_styles.'
<h1>Academic<br />Programs</h1>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
$pdf->Rect(16, 120, 20, 2, 'F', array(), array(23,160,176));
$html = $css_styles.'
<p>&nbsp;</p>
<p class="quote">My CSU Global experience has been wonderful! I have more meaningful interactions with professors and fellow students than I have had at a traditional university. We are connecting more on an intellectual and classwork level and the time spent is efficient.</p>
<p class="quote">&mdash;Fred Vigil, B.S. in Project Management Student</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell(150, '', 16, '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- bachelor's degrees

$pdf->addPage();
$pdf->Bookmark('Academic Programs', 0, 0, '', '', array(51,51,51));
$pdf->Bookmark('Bachelor\'s Degrees', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Bachelor\'s Degrees</h2>';
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// EXCEPTION - minus 3 is to account for three degrees no longer offered
$bs_degree_count = count($cat->undergraduate->lists->degrees)-3;
$bs_degree_no_enroll = array(
    'Bachelor of Science in Applied Social Sciences',
    'Bachelor of Science in Communication',
    'Bachelor of Science in Public Management'
);
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$html.= '<p>CSU Global offers '.$bs_degree_count.' undergraduate programs, which lead to Bachelor of Science degrees:</p>
<ul>
';
foreach($cat->undergraduate->lists->degrees as $k => $v) {
    if (!in_array($v, $bs_degree_no_enroll)) {
        $html.= '<li>'.str_replace('Bachelor of Science in ', '', $v).'</li>';
    }
}
$html .= '</ul>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach($cat->undergraduate->degrees as $k => $v) {
	$title = str_replace("Bachelor of Science", "Major", $v->title);
	$pdf->Bookmark($title, 2, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h3>'.$title.'</h3>
	<p>'.str_replace('\u003Cbr \/\u003E', '', $v->description).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

	$pdf->Bookmark('Program Learning Outcomes', 3, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h4>Program Learning Outcomes</h4>
	<ul>
	';
	foreach ($v->outcomes1 as $k2 => $v2) {
		$html .= '<li>'.$v2->value.'</li>';
	}
	$html .= '</ul>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

	if ($v->specialAdmissionRequirements) {
		$pdf->Bookmark('Special Admission Requirements', 3, 0, '', '', array(51,51,51));
		$html = $css_styles.'
		<h4>Specific Admission Requirements</h4>
		<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->specialAdmissionRequirements).'</p>
		<p>&nbsp;</p>
		';
		$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	}

	$pdf->Bookmark('Courses', 3, 0, '', '', array(51,51,51));
	$courseSets = count($v->graduationRequirements->groupings[0]->rules->rules);
	$courses = $v->graduationRequirements->groupings[0]->rules->rules[0]->data->courses;
	$html = $css_styles.'
	<h4>Courses</h4>
	'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E',$v->courseListPreface);
	// foreach($courses as $k2 => $v2) {
	// 	$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
	// }
    // $html .= '</ul>';
	if ($courseSets > 1) {
		for ($i=0; $i < $courseSets; $i++) {
			if ($v->graduationRequirements->groupings[0]->rules->rules[$i]->key == 'completedCourses') {
				$html .= '<h5>Complete the following:</h5>
				<ul>';
			} else if ($v->graduationRequirements->groupings[0]->rules->rules[$i]->key == 'completednumberOfCourses') {
				$html .= '<h5>Completed at least '.$v->graduationRequirements->groupings[0]->rules->rules[$i]->data->number.' of the following:</h5>
				<ul>';
			}
			foreach($v->graduationRequirements->groupings[0]->rules->rules[$i]->data->courses as $k2 => $v2) {
				$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
			}
			$html .= '</ul>';
		}
	} else {
		$html .= '<ul>';
		foreach($courses as $k2 => $v2) {
			$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
		}
		$html .= '</ul>';
	}
    if ($v->footnote) {
        $html .= str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->footnote);
    }
	$html .= '<p>&nbsp;</p>';
    $pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
    
    if ($v->title == 'Bachelor of Science in Interdisciplinary Professional Studies') {
        $pdf->AddPage();
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->Image('imgs/catalog/'.$currentCatalog.'/ips_01.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        $pdf->setPageMark();

        $pdf->AddPage();
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->Image('imgs/catalog/'.$currentCatalog.'/ips_02.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        $pdf->setPageMark();

        $pdf->AddPage();
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->Image('imgs/catalog/'.$currentCatalog.'/ips_03.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        $pdf->setPageMark();
        
        $pdf->AddPage();
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->Image('imgs/catalog/'.$currentCatalog.'/ips_04.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        $pdf->setPageMark();
        
        $pdf->AddPage();
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->Image('imgs/catalog/'.$currentCatalog.'/ips_05.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        $pdf->setPageMark();

        $pdf->AddPage();
    }
}

// --------------------------------------------------------- undergraduate certificate

$pdf->addPage();
$pdf->Bookmark('Undergraduate Certificates', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Undergraduate Certificates</h2>
<p>CSU Global offers credentialed undergraduate certificates that may be declared as a single program of study. Students interested in undergraduate certificate programs must meet university requirements for standard or provisional admission. Certificates may be financial-aid eligible. Please contact a Student Success Counselor with any questions regarding these programs.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach($cat->undergraduate->certificates as $k => $v) {
	$pdf->Bookmark($v->title, 2, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h3>'.$v->title.'</h3>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->description).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	
	$pdf->Bookmark('Certificate Learning Outcomes', 3, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h4>Certificate Learning Outcomes</h4>
	<ul>
	';
	foreach ($v->outcomes1 as $k2 => $v2) {
		$html .= '<li>'.$v2->value.'</li>';
	}
	$html .= '</ul>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

	if ($v->specialAdmissionRequirements) {
		$pdf->Bookmark('Special Admission Requirements', 3, 0, '', '', array(51,51,51));
		$html = $css_styles.'
		<h4>Special Admission Requirements</h4>
		<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->specialAdmissionRequirements).'</p>
		<p>&nbsp;</p>
		';
		$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	}
	
	$pdf->Bookmark('Courses', 3, 0, '', '', array(51,51,51));
	$courseSets = count($v->requisites->groupings[0]->rules->rules);
	$courses = $v->requisites->groupings[0]->rules->rules[0]->data->courses;
	$html = $css_styles.'
	<h4>Courses</h4>
	';
	// foreach($courses as $k2 => $v2) {
	// 	$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
	// }
	// $html .= '</ul>';
	if ($courseSets > 1) {
		for ($i=0; $i < $courseSets; $i++) {
			if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completedCourses') {
				$html .= '<h5>Complete the following:</h5>
				<ul>';
			} else if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completednumberOfCourses') {
				$html .= '<h5>Completed at least '.$v->requisites->groupings[0]->rules->rules[$i]->data->number.' of the following:</h5>
				<ul>';
			}
			foreach($v->requisites->groupings[0]->rules->rules[$i]->data->courses as $k2 => $v2) {
				$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
			}
			$html .= '</ul>';
		}
	} else {
		$html .= '<ul>';
		foreach($courses as $k2 => $v2) {
			$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
		}
		$html .= '</ul>';
	}
	if ($v->footnote) {
        $html .= str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->footnote);
    }
	$html .= '<p>&nbsp;</p>';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
}

// --------------------------------------------------------- undergraduate specializations

$pdf->addPage();
$pdf->Bookmark('Undergraduate Specializations', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Undergraduate Specializations</h2>
<p>Students may complete a specialization that consists of five upper division courses (15 credits) as a supplement to their program major. Specializations allow students to select a series of courses in a career-relevant field based on professional and personal interests. Not all specializations are available for all majors. See the Bachelor’s Degree Specialization Chart for more information. Due to course overlap in some programs, a supplemental course may be required to bring the total of classes to five.</p>
<p>Once a student has completed all the courses within a specialization, they can request a non- transcribable Certificate of Completion to be mailed to them prior to the completion of their degree. Students should contact their Student Success Counselors for more information.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach($cat->undergraduate->specializations as $k => $v) {
	$title = str_replace("Undergraduate Specialization in ", "", $v->title);
	$pdf->Bookmark($title, 2, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h3>'.$title.'</h3>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->description).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	
	$pdf->Bookmark('Program Learning Outcomes', 3, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h4>Program Learning Outcomes</h4>
	<ul>
	';
	foreach ($v->outcomes1 as $k2 => $v2) {
		$html .= '<li>'.$v2->value.'</li>';
	}
	$html .= '</ul>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->specialAdmissionRequirements).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	
	$pdf->Bookmark('Courses', 3, 0, '', '', array(51,51,51));
	$courseSets = count($v->requisites->groupings[0]->rules->rules);
	$courses = $v->requisites->groupings[0]->rules->rules[0]->data->courses;
	$html = $css_styles.'
	<h4>Courses</h4>
	';
	// foreach($courses as $k2 => $v2) {
	// 	$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
	// }
	// $html .= '</ul>';
	if ($courseSets > 1) {
		for ($i=0; $i < $courseSets; $i++) {
			if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completedCourses') {
				$html .= '<h5>Complete the following:</h5>
				<ul>';
			} else if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completednumberOfCourses') {
				$html .= '<h5>Completed at least '.$v->requisites->groupings[0]->rules->rules[$i]->data->number.' of the following:</h5>
				<ul>';
			}
			foreach($v->requisites->groupings[0]->rules->rules[$i]->data->courses as $k2 => $v2) {
				$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
			}
			$html .= '</ul>';
		}
	} else {
		$html .= '<ul>';
		foreach($courses as $k2 => $v2) {
			$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
		}
		$html .= '</ul>';
	}
	if ($v->footnote) {
        $html .= str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->footnote);
    }
	$html .= '<p>&nbsp;</p>';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
}

// --------------------------------------------------------- undergraduate specializations chart

// $pdf->AddPage();
// $bMargin = $pdf->getBreakMargin();
// $auto_page_break = $pdf->getAutoPageBreak();
// $pdf->SetAutoPageBreak(false, 0);
// $pdf->Image('imgs/catalog/'.$currentCatalog.'/specializations_undergraduate.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
// $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// $pdf->setPageMark();


















// --------------------------------------------------------- master's degrees

$pdf->addPage();
$pdf->Bookmark('Master\'s Degrees', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Master\'s Degrees</h2>
<p>CSU Global offers '.count($cat->graduate->lists->degrees).' graduate-level degree programs. These include both academic Master of Science and professional focused Master programs:</p>
<ul>';
foreach($cat->graduate->lists->degrees as $k => $v) {
	$html .= '<li>'.$v.'</li>';
}
$html .= '</ul>
<p>To ensure success, students who do not fulfill select admission criteria may be required to take one additional credit-bearing course designed to familiarize them expectations for research, writing, and content knowledge. This Master’s Plus course increases the program to 39 credits. Management applicants with GPA or content area deficiencies may be required to take RES500. Organizational Leadership, Criminal Justice, and Healthcare Administration applicants with GPA deficiencies may be required to take RES501. These courses provide students with the opportunity to sharpen their skills and better prepare for the learning objectives of the program.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach($cat->graduate->degrees as $k => $v) {
	// if ($v->title == 'Master of Science in Management') {
	// 	echo $v->description;
	// 	exit;
	// }
	$pdf->Bookmark($v->title, 2, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h3>'.$v->title.'</h3>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->description).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

	$pdf->Bookmark('Program Learning Outcomes', 3, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h4>Program Learning Outcomes</h4>
	<ul>
	';
	foreach ($v->outcomes1 as $k2 => $v2) {
		$html .= '<li>'.$v2->value.'</li>';
	}
	$html .= '</ul>
	<p>&nbsp;</p>
	';
    $pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
    
    if ($v->specialAdmissionRequirements) {
		$pdf->Bookmark('Special Admission Requirements', 3, 0, '', '', array(51,51,51));
		$html = $css_styles.'
		<h4>Specific Admission Requirements</h4>
		<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->specialAdmissionRequirements).'</p>
		<p>&nbsp;</p>
		';
		$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	}

	$pdf->Bookmark('Courses', 3, 0, '', '', array(51,51,51));
	$courseSets = count($v->graduationRequirements->groupings[0]->rules->rules);
	$courses = $v->graduationRequirements->groupings[0]->rules->rules[0]->data->courses;
	$html = $css_styles.'
	<h4>Courses</h4>
	'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->courseListPreface);
	if ($courseSets > 1) {
		for ($i=0; $i < $courseSets; $i++) {
			if ($v->graduationRequirements->groupings[0]->rules->rules[$i]->key == 'completedCourses') {
				$html .= '<h5>Complete the following:</h5>
				<ul>';
			} else if ($v->graduationRequirements->groupings[0]->rules->rules[$i]->key == 'completednumberOfCourses') {
				$html .= '<h5>Completed at least '.$v->graduationRequirements->groupings[0]->rules->rules[$i]->data->number.' of the following:</h5>
				<ul>';
			}
			foreach($v->graduationRequirements->groupings[0]->rules->rules[$i]->data->courses as $k2 => $v2) {
				$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
			}
			$html .= '</ul>';
		}
	} else {
		$html .= '<ul>';
		foreach($courses as $k2 => $v2) {
			$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
		}
		$html .= '</ul>';
	}
    if ($v->footnote) {
        $html .= str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->footnote);
    }
	$html .= '<p>&nbsp;</p>';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
}

// --------------------------------------------------------- graduate certificate

$pdf->addPage();
$pdf->Bookmark('Graduate Certificates', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Graduate Certificates</h2>
<p>CSU Global offers credentialed graduate certificates that may be declared as a single program of study. Students interested in certificate programs must meet standard admissions requirements. Certificates may be financial aid eligible. Please contact a Student Success Counselor with any questions regarding these programs.</p>
<p>Students interested in certificate programs should have a firm knowledge of the basic competencies indicated by the learning outcomes. This includes knowledge of specialized terminology, work flow, or technology. A previous exposure to curriculum may be necessary for student success.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach($cat->graduate->certificates as $k => $v) {
	$pdf->Bookmark($v->title, 2, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h3>'.$v->title.'</h3>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->description).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	
	$pdf->Bookmark('Certificate Learning Outcomes', 3, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h4>Certificate Learning Outcomes</h4>
	<ul>
	';
	foreach ($v->outcomes1 as $k2 => $v2) {
		$html .= '<li>'.$v2->value.'</li>';
	}
	$html .= '</ul>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

	if ($v->specialAdmissionRequirements) {
		$pdf->Bookmark('Special Admission Requirements', 3, 0, '', '', array(51,51,51));
		$html = $css_styles.'
		<h4>Special Admission Requirements</h4>
		<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->specialAdmissionRequirements).'</p>
		<p>&nbsp;</p>
		';
		$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	}
	
	$pdf->Bookmark('Courses', 3, 0, '', '', array(51,51,51));
	$courseSets = count($v->requisites->groupings[0]->rules->rules);
	$courses = $v->requisites->groupings[0]->rules->rules[0]->data->courses;
	$html = $css_styles.'
	<h4>Courses</h4>
	';
	// foreach($courses as $k2 => $v2) {
	// 	$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
	// }
	// $html .= '</ul>';
	if ($courseSets > 1) {
		for ($i=0; $i < $courseSets; $i++) {
			if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completedCourses') {
				$html .= '<h5>Complete the following:</h5>
				<ul>';
			} else if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completednumberOfCourses') {
				$html .= '<h5>Completed at least '.$v->requisites->groupings[0]->rules->rules[$i]->data->number.' of the following:</h5>
				<ul>';
			}
			foreach($v->requisites->groupings[0]->rules->rules[$i]->data->courses as $k2 => $v2) {
				$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
			}
			$html .= '</ul>';
		}
	} else {
		$html .= '<ul>';
		foreach($courses as $k2 => $v2) {
			$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
		}
		$html .= '</ul>';
	}
	if ($v->footnote) {
        $html .= str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->footnote);
    }
	$html .= '<p>&nbsp;</p>';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
}

// --------------------------------------------------------- graduate licensures

$pdf->addPage();
$pdf->Bookmark('Graduate Licensure Programs', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Graduate Licensure Programs</h2>
<p>The certifying agent for the completion of these Licensure programs is the Colorado State University Global Campus Registrar. Eligibility for licensure is indicated on the official transcript upon completion.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach($cat->graduate->licensures as $k => $v) {
	$title = str_replace("Graduate Licensure Program in ", "", $v->title);
	$pdf->Bookmark($title, 2, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h3>'.$title.'</h3>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->description).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	
	$pdf->Bookmark('Program Learning Outcomes', 3, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h4>Program Learning Outcomes</h4>
	<ul>
	';
	foreach ($v->outcomes1 as $k2 => $v2) {
		$html .= '<li>'.$v2->value.'</li>';
	}
	$html .= '</ul>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->specialAdmissionRequirements).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	
	$pdf->Bookmark('Courses', 3, 0, '', '', array(51,51,51));
	$courseSets = count($v->requisites->groupings[0]->rules->rules);
	$courses = $v->requisites->groupings[0]->rules->rules[0]->data->courses;
	$html = $css_styles.'
	<h4>Courses</h4>
	'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->courseListPreface);
	// foreach($courses as $k2 => $v2) {
	// 	$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
	// }
	// $html .= '</ul>';
	if ($courseSets > 1) {
		for ($i=0; $i < $courseSets; $i++) {
			if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completedCourses') {
				$html .= '<h5>Complete the following:</h5>
				<ul>';
			} else if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completednumberOfCourses') {
				$html .= '<h5>Completed at least '.$v->requisites->groupings[0]->rules->rules[$i]->data->number.' of the following:</h5>
				<ul>';
			}
			foreach($v->requisites->groupings[0]->rules->rules[$i]->data->courses as $k2 => $v2) {
				$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
			}
			$html .= '</ul>';
		}
	} else {
		$html .= '<ul>';
		foreach($courses as $k2 => $v2) {
			$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
		}
		$html .= '</ul>';
	}
	if ($v->footnote) {
        $html .= str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->footnote);
    }
	$html .= '<p>&nbsp;</p>';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
}

// --------------------------------------------------------- graduate specializations

$pdf->addPage();
$pdf->Bookmark('Graduate Specializations', 1, 0, '', '', array(51,51,51));
$html = $css_styles.'
<h2>Graduate Specializations</h2>
<p>Students must complete a specialization that consists of four graduate courses (12 semester hours of credit) as a supplement to their program major. Specializations allow students to select a series of courses in a career-relevant area based on professional/personal interests.</p>
<p>Not all specializations are available for all degree programs. See the Master’s Degree Specialization Chart for more information. Students should consult the requirements for their specific degree program prior to starting specialization coursework. Students should complete most major courses for their program (except the capstone prep and capstone project) before taking specialization courses.</p>
<p>Once a student has completed all the courses within a specialization, they can request a non-transcribable Certificate of Completion to be mailed to them prior to the completion of their degree. Students should contact their Student Success Counselor for more information.</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);

foreach($cat->graduate->specializations as $k => $v) {
	$title = str_replace("Graduate Specialization in ", "", $v->title);
	$pdf->Bookmark($title, 2, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h3>'.$title.'</h3>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->description).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	
	$pdf->Bookmark('Program Learning Outcomes', 3, 0, '', '', array(51,51,51));
	$html = $css_styles.'
	<h4>Program Learning Outcomes</h4>
	<ul>
	';
	foreach ($v->outcomes1 as $k2 => $v2) {
		$html .= '<li>'.$v2->value.'</li>';
	}
	$html .= '</ul>
	<p>'.str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->specialAdmissionRequirements).'</p>
	<p>&nbsp;</p>
	';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
	
	$pdf->Bookmark('Courses', 3, 0, '', '', array(51,51,51));
	$courseSets = count($v->requisites->groupings[0]->rules->rules);
	$courses = $v->requisites->groupings[0]->rules->rules[0]->data->courses;
	$html = $css_styles.'
	<h4>Courses</h4>
	';
	// foreach($courses as $k2 => $v2) {
	// 	$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
	// }
	// $html .= '</ul>';
	if ($courseSets > 1) {
		for ($i=0; $i < $courseSets; $i++) {
			if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completedCourses') {
				$html .= '<h5>Complete the following:</h5>
				<ul>';
			} else if ($v->requisites->groupings[0]->rules->rules[$i]->key == 'completednumberOfCourses') {
				$html .= '<h5>Completed at least '.$v->requisites->groupings[0]->rules->rules[$i]->data->number.' of the following:</h5>
				<ul>';
			}
			foreach($v->requisites->groupings[0]->rules->rules[$i]->data->courses as $k2 => $v2) {
				$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
			}
			$html .= '</ul>';
		}
	} else {
		$html .= '<ul>';
		foreach($courses as $k2 => $v2) {
			$html .= '<li>'.$cat->courses->{$v2}->subjectCodeActual.$cat->courses->{$v2}->number.' - '.$cat->courses->{$v2}->title.'</li>';
		}
		$html .= '</ul>';
	}
	if ($v->footnote) {
        $html .= str_replace('\u003C\/p\u003E \u003Cbr \/\u003E', '\u003C\/p\u003E', $v->footnote);
    }
	$html .= '<p>&nbsp;</p>';
	$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
}

// --------------------------------------------------------- graduate specializations chart

// $pdf->AddPage();
// $bMargin = $pdf->getBreakMargin();
// $auto_page_break = $pdf->getAutoPageBreak();
// $pdf->SetAutoPageBreak(false, 0);
// $pdf->Image('imgs/catalog/'.$currentCatalog.'/specializations_graduate.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
// $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// $pdf->setPageMark();


















// --------------------------------------------------------- courses

$pdf->AddPage();
$pdf->setY(80, true, false);
$html = $css_styles.'
<h1>Courses of<br />Instruction</h1>
<p>&nbsp;</p>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
$pdf->Rect(16, 120, 20, 2, 'F', array(), array(23,160,176));
$html = $css_styles.'
<p>&nbsp;</p>
<p class="quote">Going through my program has helped me develop new ideas on how to be an effective educator. I have always enjoyed teaching people how to do things and breaking things down into bite-sized, easy-to-understand concepts. The classes I\'ve taken so far have helped me sharpen those skills and I can\'t wait to get out and really put my new skills to use in the classroom.</p>
<p class="quote">&mdash;Joshua Stoneking, M.S. in Teaching and Learning Student</p>
<p>&nbsp;</p>';
$pdf->writeHTMLCell(150, '', 16, '', $html, 0, 1, false, true, '', true);

// --------------------------------------------------------- graduate specializations

$pdf->addPage();
$pdf->Bookmark('Courses', 0, 0, '', '', array(51,51,51));

foreach($cat->courses->lists as $k => $v) {
	// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	// EXCEPTION - filters out the random ART101 TEst Course that I can't seem to delete
	if ($k != 'Art') {
		$pdf->Bookmark($k, 1, 0, '', '', array(51,51,51));
		$html = $css_styles.'
		<hr>
		<p>&nbsp;</p>
		<h3>'.$k.'</h3>
		<p>&nbsp;</p>
		';
		$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
		
		foreach($v as $k2 => $v2) {
			if (substr($cat->courses->{$v2[0]}->number[3], -1) != 'S') {
				$html = $css_styles.'
				<p><span style="color:#aa1d40; font-weight:bold;">'.$cat->courses->{$v2[0]}->subjectCodeActual.$cat->courses->{$v2[0]}->number.' - '.$cat->courses->{$v2[0]}->title.'</span><br />
				<strong>Course Description</strong><br />
				'.strip_tags($cat->courses->{$v2[0]}->description).'<br />';
				if ($cat->courses->{$v2[0]}->prerequisites->rules->rules[0]->data->courses) {
					$html .= 'Prerequisite: ';
					foreach($cat->courses->{$v2[0]}->prerequisites->rules->rules[0]->data->courses as $k3 => $v3) {
						$html .= $cat->courses->{$v3}->subjectCodeActual.$cat->courses->{$v3}->number.' ';
					}
				}
				$html .= '<strong>Credit Hours: '.$cat->courses->{$v2[0]}->credits->value.'</strong>
				</p>
				<p>&nbsp;</p>';
				$pdf->writeHTMLCell('', '', '', '', $html, 0, 1, false, true, '', true);
			}
		}
	}
	// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
}















// --------------------------------------------------------- back cover

$pdf->SetPrintHeader(false);
$pdf->AddPage();
$pdf->SetPrintFooter(false);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->Image('imgs/catalog/'.$currentCatalog.'/cover_back.jpg', 0, 0, 216, '', '', '', '', false, 150, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();	
	
	
	
	
	


























// . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .

// print headers and footers from now on
$pdf->setPrintHeader();

// add a new page for TOC
$pdf->addTOCPage();
$pdf->setPrintFooter();

$html = $css_styles.'
<h3>Contents</h3>';
$pdf->writeHTMLCell('', '', '', '', $html, 0, 2, false, true, '', true);
$pdf->Ln();

// add a simple Table Of Content at first page
// (check the example n. 59 for the HTML version)
$pdf->addTOC(3, 'helvetica', '.', 'INDEX', '', array(51,51,51));

// end of TOC page
$pdf->endTOCPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('academic_catalog.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
