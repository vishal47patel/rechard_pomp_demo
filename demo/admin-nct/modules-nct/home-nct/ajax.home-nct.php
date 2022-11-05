<?php

$reqAuth = true;
$analytic_total_views = 0;
require_once("../../../includes-nct/config-nct.php");

$module = "home-nct";
$page_name = "home";

if (isset($_POST['action']) && $_POST['action'] == 'getReportData') {
    $response = array();
    $response['status'] = false;

    $report_type = filtering($_POST['report_type'], 'input', 'int');
    $month = filtering($_POST['month'], 'input', 'int');
    $year = filtering($_POST['year'], 'input', 'int');

    if ($report_type != "" && $year > 0) {
        if ($report_type == 'users' || $report_type == 'seekers' || $report_type == 'services') {

            $report_tenure = ( ( $month > 0 ) ? 'monthly' : 'yearly' );

            $objHome = new Home();
            $report_data = $objHome->getReportsArray($report_type, $month, $year, $report_tenure);

            $response['status'] = true;
            $response['report_data'] = json_decode($report_data);
            echo json_encode($response);
            exit;

        } else {
            $response['message'] = "The requested report can't be generated.";
            echo json_encode($response);
            exit;
        }
    } else {
        $response['message'] = "There seems to be some issue with the data you have sent to generate report.";
        echo json_encode($response);
        exit;
    }
}
