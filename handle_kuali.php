<?php
// Turn off all error reporting
error_reporting(0);

// Turn on all error reporting
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

session_start();

$now = new DateTime();

$lastPublished = strtotime('3/2/2023') * 1000;

$cat = array(
    "policyGroups" => array(
        "5bf3005251fdd6000116ade2" => "Admissions",
        "5bf30097b37dbb00011708e0" => "Transfer",
        "5bf300aa51fdd6000116ade6" => "Academic"
    ),
    "subjects" => array(
        "5a90494d621a472f00f5813a" => array("ACT","Accounting"),
        "5a90496f77a1d32e00d2596c" => array("ART","Art"),
        "5a5f6eb39a2fa52e002e0218" => array("BIO","Biology"),
        "5c47aad10c55252400b11cb9" => array("BUS","Business"),
        "5a5f6eba846de82e0031f212" => array("CHE","Chemistry"),
        "5a5f6ec1846de82e0031f213" => array("CMG","Construction Management"),
        "5a5f6ec7846de82e0031f214" => array("COM","Communications"),
        "5a5f6ecd9a2fa52e002e0219" => array("CRJ","Criminal Justice"),
        "5a5f6ed9846de82e0031f215" => array("CSC","Computer Science"),
        "5a5f6edf43d6892e0068179a" => array("ECN","Economics"),
        "5a5f6f02a1978f2e00753b4d" => array("EDL","Education Leadership"),
        "5a5f6f19a1978f2e00753b4e" => array("ELL","English Language Learning"),
        "5a5f6f29846de82e0031f216" => array("EMG","Emergency Management"),
        "5a56f1e104d45301001055f1" => array("ENG","English"),
        "62bdf5a48b0d6b41b44f7d60" => array("EPR","Exercise Physiology"),
        "5a5f6f389a2fa52e002e021a" => array("FIN","Finance"),
        "5a5f6f4343d6892e0068179b" => array("GEO","Geology"),
        "5a5f6f659a2fa52e002e021b" => array("HCI","Healthcare Informatics"),
        "5a5f6f70846de82e0031f217" => array("HCM","Healthcare Management"),
        "5a5f6f8ea1978f2e00753b4f" => array("HLS","Homeland Security"),
        "5de0320ba49ee224009b3fda" => array("HPR","Health Professional"),
        "5a5f6fb0a1978f2e00753b50" => array("HRM","Human Resource Management"),
        "5a5f6fcf43d6892e0068179c" => array("HSM","Human Services"),
        "5a5f6fd5846de82e0031f219" => array("HST","History"),
        "5c47aaf60c55252400b11cbd" => array("HTM","Hospitality Management"),
        "5a5f700aa1978f2e00753b51" => array("HUM","Humanities"),
        "5a5f702e9a2fa52e002e0220" => array("ISM","Information Systems Management"),
        "5a5f708443d6892e0068179f" => array("ITS","Information Technology Services"),
        "5e42f31b1e54212500e7305b" => array("ISD","Instructional Design"),
        "5a9049c7f9a7142e002667fa" => array("IPS","Interdisciplinary Professional Studies"),
        "5a5f70d743d6892e006817a0" => array("LIB","Library"),
        "621fa0ec89a2d4fa7d1e31ab" => array("MBA","Business Administration"),
        "5a9049e1621a472f00f5813c" => array("MGT","Management"),
        "5a9049f8621a472f00f5813d" => array("MIM","International Management"),
        "5a904a07f9a7142e002667fb" => array("MIS","Management Information Systems"),
        "5a904a19e30d1d2e000c7792" => array("MKG","Marketing"),
        "5a904a2077a1d32e00d25970" => array("MTH","Mathematics"),
        "5f4592b5dbae980026ba4274" => array("NUR","Nursing"),
        "5a904a43621a472f00f5813e" => array("OPS","Operations Management"),
        "5a904a4df9a7142e002667fc" => array("ORG","Organizational Leadership"),
        "5a904a30e30d1d2e000c779a" => array("OTL","Online Teaching and Learning"),
        "nc_pbs" => array("PBS",""),
        "5a904a5df9a7142e002667fd" => array("PHY","Physics"),
        "5a904a65621a472f00f58141" => array("PJM","Project Management"),
        "5a5f84b0846de82e0031f28c" => array("PMG","Public Management"),
        "5c47ab1c0c55252400b11cc0" => array("POL","Political Science"),
        "5a904a77621a472f00f58142" => array("PSL","Professional Sales"),
        "5c47ab26ee77472400e419bc" => array("PSY","Psychology"),
        "5a904a7e621a472f00f58143" => array("RES","Research"),
        "5a904a8a77a1d32e00d25972" => array("SMB","Small Business/Entrepreneurship"),
        "5a5f6e619a2fa52e002e0215" => array("SOC","Sociology")
    )
);

$access_token = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

// Get Policies
$url = "https://csuglobal.kuali.co/api/cm/policies/queryAll?status=active&sort=title";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: OAuth $access_token", "Content-type: application/json"));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSLVERSION, 6);
$json_response = curl_exec($curl);
$response = json_decode($json_response, true);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ($status != 200) {
    $msg = array(
        'status' => 'failed',
        'code' => $status,
        'message' => 'Unable to get policies from Kuali API'
    );
    die(print_r($msg,true));
} else {
    foreach($response['res'] as $k => $v) {
        unset($v['meta'],$v['status'],$v['createdBy'],$v['pid'],$v['created'],$v['updatedBy'],$v['dateStartLabel'],$v['catalogActivationDate'],$v['includeInCatalog'],$v['approvalDate'],$v['originalProposalId'],$v['id']);
        if ($v['policyGroup'] == '5bf3005251fdd6000116ade2') { // admissions
            $cat['policies']['lists']['admissions'][] = $v['title'];
        } else if ($v['policyGroup'] == '5bf30097b37dbb00011708e0') { // transfer
            $cat['policies']['lists']['transfer'][] = $v['title'];
        } else if ($v['policyGroup'] == '5bf300aa51fdd6000116ade6') { // academic
            $cat['policies']['lists']['academic'][] = $v['title'];
        }
        $cat['policies'][$v['title']] = str_replace('&quot;', '"', $v['body']);
    }
}

// Get Programs
$url = "https://csuglobal.kuali.co/api/cm/programs/queryAll?status=active&sort=title";
// $url = "https://csuglobal.kuali.co/api/cm/programs/queryAll?status=active&created=lte(".time()."000)&sort=title";
// $url = "https://csuglobal.kuali.co/api/cm/programs/queryAll?status=active&created=lte(".$lastPublished.")&sort=title";
// echo "<br /><br /><br />".$url;
// exit;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: OAuth $access_token", "Content-type: application/json"));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSLVERSION, 6);
$json_response = curl_exec($curl);
$response = json_decode($json_response, true);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ($status != 200) {
    $msg = array(
        'status' => 'failed',
        'code' => $status,
        'message' => 'Unable to get programs from Kuali API'
    );
    die(print_r($msg,true));
} else {
    foreach($response['res'] as $k => $v) {
        $dateEnd = new DateTime($v['dateEnd']);
        if (!$v['dateEnd'] OR $dateEnd > $now) {
            $v['description'] = str_replace('</p> <br />', '</p>', $v['description']);
            $v['specialAdmissionRequirements'] = str_replace('</p> <br />', '</p>', $v['specialAdmissionRequirements']);
            $v['courseListPreface'] = str_replace('</p> <br />', '</p>', $v['courseListPreface']);
            $v['footnote'] = str_replace('</p> <br />', '</p>', $v['footnote']);
            if ($v['programLevel'] == '5c59d3b303bdde240091d28a') {
                unset($v['status'],$v['includeInCatalog'],$v['programType'],$v['programLevel'],$v['programChairPlaceholder'],$v['groupFilter2'],$v['createdBy'],$v['updatedBy'],$v['pid'],$v['careerDevelopmentCriteria'],$v['proposedOutcomeMap'],$v['groupFilter1'],$v['id']);
                $cat['undergraduate']['lists']['degrees'][] = $v['title'];
                $cat['undergraduate']['degrees'][] = $v;
            } else {
                unset($v['status'],$v['includeInCatalog'],$v['programType'],$v['programLevel'],$v['programChairPlaceholder'],$v['groupFilter2'],$v['createdBy'],$v['updatedBy'],$v['pid'],$v['careerDevelopmentCriteria'],$v['proposedOutcomeMap'],$v['groupFilter1'],$v['id']);
                $cat['graduate']['lists']['degrees'][] = $v['title'];
                $v['description'] = str_replace('&quot;', '"', $v['description']);
                $v['specialAdmissionRequirements'] = str_replace('&quot;', '"', $v['specialAdmissionRequirements']);
                $v['courseListPreface'] = str_replace('&quot;', '"', $v['courseListPreface']);
                $v['footnote'] = str_replace('&quot;', '"', $v['footnote']);
                $cat['graduate']['degrees'][] = $v;
            }
        }
    }
}

// Certificates and Specializatoins
$url = "https://csuglobal.kuali.co/api/cm/specializations/queryAll?status=active&sort=title";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: OAuth $access_token", "Content-type: application/json"));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSLVERSION, 6);
$json_response = curl_exec($curl);
$response = json_decode($json_response, true);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ($status != 200) {
    $msg = array(
        'status' => 'failed',
        'code' => $status,
        'message' => 'Unable to get specializations from Kuali API'
    );
    die(print_r($msg,true));
} else {
    foreach($response['res'] as $k => $v) { 
        $dateEnd = new DateTime($v['dateEnd']);
        if (!$v['dateEnd'] OR $dateEnd > $now) {
            unset($v['createdBy'],$v['proposalOwner'],$v['status'],$v['pid'],$v['updatedBy'],$v['inheritedFrom'],$v['approvalDate'],$v['originalProposalId'],$v['id']);
            $v['description'] = str_replace('&quot;', '"', $v['description']);
            $v['specialAdmissionRequirements'] = str_replace('&quot;', '"', $v['specialAdmissionRequirements']);
            if (strpos($v['title'], 'Undergraduate') !== false) {
                if (strpos($v['title'], 'Certificate') !== false) {
                    $cat['undergraduate']['lists']['certificates'][] = $v['title'];
                    $cat['undergraduate']['certificates'][] = $v;
                } else {
                    $cat['undergraduate']['lists']['specializations'][] = $v['title'];
                    $cat['undergraduate']['specializations'][] = $v;
                }  
            } else {
                if (strpos($v['title'], 'Certificate') !== false) {
                    $cat['graduate']['lists']['certificates'][] = $v['title'];
                    $cat['graduate']['certificates'][] = $v;
                } else if (strpos($v['title'], 'Licensure') !== false) {
                    $cat['graduate']['lists']['licensures'][] = $v['title'];
                    $cat['graduate']['licensures'][] = $v;
                } else {
                    $cat['graduate']['lists']['specializations'][] = $v['title'];
                    $cat['graduate']['specializations'][] = $v;
                }  
            }
        }
    }
}

// Get Courses
$url = "https://csuglobal.kuali.co/api/cm/courses/queryAll?status=active&sort=number";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: OAuth $access_token", "Content-type: application/json"));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSLVERSION, 6);
$json_response = curl_exec($curl);
$response = json_decode($json_response, true);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ($status != 200) {
    $msg = array(
        'status' => 'failed',
        'code' => $status,
        'message' => 'Unable to get courses from Kuali API'
    );
    die(print_r($msg,true));
} else {
    foreach($response['res'] as $k => $v) {
        $dateEnd = new DateTime($v['dateEnd']);
        if (!$v['dateEnd'] OR $dateEnd > $now) {
            unset($v['status'],$v['includeInCatalog'],$v['createdBy'],$v['updatedBy'],$v['id'],$v['courseOverview']);
            $v['subjectCodeActual'] = $cat['subjects'][$v['subjectCode']][0];
            $cat['courses']['lists'][$cat['subjects'][$v['subjectCode']][1]][] = array($v['pid'],$v['subjectCodeActual'].$v['number'].' - '.$v['title']);
            // $v['description'] = $v['description'];
            $v['description'] = str_replace('&quot;', '"', $v['description']);
            $cat['courses'][$v['pid']] = $v;
        }
    }
}

ksort($cat['courses']['lists']);
ksort($cat['courses']);
echo json_encode($cat, JSON_HEX_QUOT | JSON_HEX_TAG);